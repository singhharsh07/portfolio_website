<?php
$projects_file = '../projects.json';
$projects = file_exists($projects_file) ? json_decode(file_get_contents($projects_file), true) : [];
// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $delete_index = (int)$_POST['delete_index'];
    if (isset($projects[$delete_index])) {
        array_splice($projects, $delete_index, 1);
        file_put_contents($projects_file, json_encode($projects, JSON_PRETTY_PRINT));
        header('Location: project.php');
        exit();
    }
}
// Handle edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_index'])) {
    $edit_index = (int)$_POST['edit_index'];
    if (isset($projects[$edit_index])) {
        $name = trim($_POST['edit_name'] ?? '');
        $duration = trim($_POST['edit_duration'] ?? '');
        $technologies = trim($_POST['edit_technologies'] ?? '');
        $desc = trim($_POST['edit_desc'] ?? '');
        $old_images = $_POST['edit_old_images'] ?? [];
        $images = is_array($old_images) ? array_values(array_filter($old_images)) : [];
        $uploads_dir = '../uploads/';
        if (!file_exists($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        // Handle new uploads
        if (!empty($_FILES['edit_images']['name'][0])) {
            foreach ($_FILES['edit_images']['tmp_name'] as $idx => $tmp_name) {
                if ($_FILES['edit_images']['error'][$idx] === 0) {
                    $ext = pathinfo($_FILES['edit_images']['name'][$idx], PATHINFO_EXTENSION);
                    $filename = uniqid('img_', true) . '.' . $ext;
                    $target = $uploads_dir . $filename;
                    if (move_uploaded_file($tmp_name, $target)) {
                        $images[] = 'uploads/' . $filename;
                    }
                }
            }
        }
        $cover_image = $_POST['edit_cover_image'] ?? ($images[0] ?? '');
        if ($name && $duration && $technologies && $desc && count($images) > 0 && $cover_image) {
            $projects[$edit_index] = [
                'name' => $name,
                'desc' => $desc,
                'duration' => $duration,
                'technologies' => $technologies,
                'images' => $images,
                'cover_image' => $cover_image
            ];
            file_put_contents($projects_file, json_encode($projects, JSON_PRETTY_PRINT));
            header('Location: project.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Projects | Harsh Kumar</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #23233a 0%, #6366f1 100%);
            color: #f3f4f6;
            min-height: 100vh;
        }
        .navbar {
            position: fixed; top: 0; left: 0; width: 100%; background: rgba(24,24,27,0.7);
            box-shadow: 0 2px 24px #6366f144; z-index: 1000; backdrop-filter: blur(12px) saturate(180%);
            border-bottom: 1px solid rgba(99,102,241,0.15); transition: background 0.3s; height: 48px;
        }
        .navbar-container {
            max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between;
            padding: 0.2rem 1rem; height: 48px;
        }
        .logo { font-size: 1.1rem; color: #fbbf24; font-weight: bold; letter-spacing: 1px; text-shadow: 0 1px 4px #6366f1aa; margin-right: 1.2rem; white-space: nowrap; }
        .nav-links { list-style: none; display: flex; gap: 1.1rem; margin: 0; padding: 0; align-items: center; }
        .nav-links li a { color: #a5b4fc; text-decoration: none; font-size: 0.98rem; font-weight: 500; padding: 5px 10px; border-radius: 6px; transition: color 0.3s, background 0.3s, box-shadow 0.3s; position: relative; line-height: 1.2; }
        .nav-links li a:hover, .nav-links li a:focus { color: #fff; background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%); box-shadow: 0 2px 12px #6366f1aa; }
        .nav-links li a.active { color: #fbbf24; background: #23233a; box-shadow: 0 2px 8px #fbbf24aa; }
        .admin-container { max-width: 1200px; margin: 80px auto 0 auto; padding: 32px 16px 0 16px; }
        .topbar { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 24px; }
        .add-btn { background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%); color: #fff; border: none; border-radius: 8px; padding: 12px 24px; font-size: 1.1rem; font-weight: 600; cursor: pointer; box-shadow: 0 2px 8px #6366f1aa; transition: background 0.3s, color 0.3s; }
        .add-btn:hover { background: #fbbf24; color: #23233a; }
        table { width: 100%; border-collapse: collapse; background: #23233a; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px #6366f1aa; }
        th, td { padding: 18px 12px; text-align: left; border-bottom: 1px solid #6366f1; }
        th { background: #23233a; color: #fbbf24; font-size: 1.1rem; font-weight: 700; }
        td { color: #f3f4f6; font-size: 1.05rem; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        .project-images { display: flex; gap: 8px; }
        .project-images img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px #6366f1aa; border: 1.5px solid #6366f1; }
        .action-btn {
            background: #23233a;
            border-radius: 50%;
            border: 2px solid #6366f1;
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, border 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px #6366f1aa;
            margin-right: 4px;
            color: #a5b4fc;
            position: relative;
        }
        .action-btn:last-child { margin-right: 0; }
        .action-btn.edit:hover {
            background: #fbbf24;
            color: #23233a;
            border-color: #fbbf24;
        }
        .action-btn.delete:hover {
            background: #ef4444;
            color: #fff;
            border-color: #ef4444;
        }
        .action-btn svg {
            width: 20px;
            height: 20px;
            display: block;
        }
        .action-btn[title]::after {
            content: attr(title);
            position: absolute;
            left: 50%;
            top: -32px;
            transform: translateX(-50%);
            background: #23233a;
            color: #fbbf24;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.95rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
            z-index: 10;
        }
        .action-btn:hover[title]::after {
            opacity: 1;
        }
        @media (max-width: 900px) {
            .admin-container { padding: 12px 2vw 0 2vw; }
            th, td { padding: 10px 6px; font-size: 0.98rem; }
            .project-images img { width: 40px; height: 40px; }
            .action-btn { width: 32px; height: 32px; }
            .action-btn svg { width: 16px; height: 16px; }
        }
        @media (max-width: 600px) {
            .admin-container { padding: 4px 0 0 0; }
            table, thead, tbody, th, td, tr { display: block; }
            th { position: absolute; left: -9999px; top: -9999px; }
            tr { margin-bottom: 18px; border-radius: 12px; box-shadow: 0 2px 8px #6366f1aa; background: #23233a; }
            td { border: none; position: relative; padding: 12px 8px; font-size: 0.95rem; }
            .project-images { gap: 4px; }
        }
        .modal-bg { display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(24,24,27,0.7); z-index:2000; align-items:center; justify-content:center; }
        .modal-bg.active { display:flex; }
        .modal-card { background:#23233a; border-radius:20px; box-shadow:0 8px 48px #6366f1aa,0 2px 16px #23233a88; padding:36px 32px 28px 32px; min-width:320px; max-width:500px; width:100%; display:flex; flex-direction:column; align-items:center; border:1.5px solid rgba(99,102,241,0.18); position:relative; }
        .modal-card h2 { color:#fbbf24; margin-bottom:1.2rem; font-size:1.5rem; }
        .modal-card form { width:100%; display:flex; flex-direction:column; gap:1.1rem; }
        .modal-card label { color:#a5b4fc; font-weight:600; margin-bottom:0.2rem; }
        .modal-card input, .modal-card textarea { padding:10px; border-radius:8px; border:none; background:#18181b; color:#f3f4f6; font-size:1rem; box-shadow:0 1px 4px #6366f122; }
        .modal-card textarea { min-height:60px; max-height:120px; }
        .modal-card .form-btns { display:flex; justify-content:flex-end; gap:1rem; margin-top:1.2rem; }
        .modal-card button, .modal-card .back-link { background:linear-gradient(90deg,#6366f1 60%,#fbbf24 100%); color:#fff; border:none; border-radius:8px; padding:10px 22px; font-size:1.05rem; cursor:pointer; font-weight:600; box-shadow:0 2px 8px #6366f1aa; transition:background 0.3s,color 0.3s; text-decoration:none; display:inline-block; }
        .modal-card button:hover, .modal-card .back-link:hover { background:#fbbf24; color:#23233a; }
        .modal-card .close-btn { position:absolute; top:12px; right:18px; background:none; border:none; color:#a5b4fc; font-size:1.5rem; cursor:pointer; }
        .image-preview-list { display:flex; gap:16px; flex-wrap:wrap; margin:10px 0; }
        .image-preview-item { display:flex; flex-direction:column; align-items:center; }
        .image-preview-item img { width:80px; height:80px; object-fit:cover; border-radius:8px; box-shadow:0 2px 8px #6366f1aa; border:2px solid #6366f1; margin-bottom:4px; }
        .cover-radio { margin-top:4px; }
        .remove-img { color:#ef4444; background:none; border:none; cursor:pointer; font-size:0.9rem; margin-top:2px; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="admin.php">Home</a></li>
                <li><a href="project.php" class="active">Projects</a></li>
                <li><a href="certification.php">Certifications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </nav>
    <div class="admin-container">
        <div class="topbar">
            <a href="add_project.php" class="add-btn">+ Add New Project</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Technologies</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $index => $project): ?>
                <tr>
                    <td><?php echo htmlspecialchars($project['name']); ?></td>
                    <td><?php echo htmlspecialchars($project['desc']); ?></td>
                    <td><?php echo htmlspecialchars($project['duration']); ?></td>
                    <td><?php echo htmlspecialchars($project['technologies']); ?></td>
                    <td style="min-width:90px;">
                        <a href="edit_project.php?id=<?php echo $index; ?>" class="action-btn edit" title="Edit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="width:20px;height:20px;display:block;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                        </a>
                        <form method="POST" action="project.php" style="display:inline;">
                            <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                            <button type="submit" title="Delete"
                                style="display:inline-flex;align-items:center;justify-content:center;width:38px;height:38px;border-radius:50%;border:2px solid #6366f1;background:#23233a;color:#a5b4fc;box-shadow:0 2px 8px #6366f1aa;transition:background 0.2s,border 0.2s,color 0.2s;text-decoration:none;position:relative;"
                                onmouseover="this.style.background='#ef4444';this.style.color='#fff';this.style.borderColor='#ef4444'"
                                onmouseout="this.style.background='#23233a';this.style.color='#a5b4fc';this.style.borderColor='#6366f1'">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="width:20px;height:20px;display:block;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Edit Modal -->
    <div class="modal-bg" id="editModalBg">
        <div class="modal-card">
            <button class="close-btn" onclick="closeEditModal()">&times;</button>
            <h2>Edit Project</h2>
            <form method="POST" enctype="multipart/form-data" id="editProjectForm" action="project.php">
                <input type="hidden" name="edit_index" id="edit_index">
                <label for="edit_name">Project Name</label>
                <input type="text" id="edit_name" name="edit_name" required>
                <label>Current Images</label>
                <div id="edit_imagePreviewList" class="image-preview-list"></div>
                <label for="edit_images">Add New Images</label>
                <input type="file" id="edit_images" name="edit_images[]" accept="image/*" multiple onchange="showEditNewImagePreviews(this)">
                <div id="edit_newImagePreviewList" class="image-preview-list"></div>
                <label for="edit_duration">Duration</label>
                <input type="text" id="edit_duration" name="edit_duration" required>
                <label for="edit_technologies">Technologies Used</label>
                <input type="text" id="edit_technologies" name="edit_technologies" required>
                <label for="edit_desc">Description</label>
                <textarea id="edit_desc" name="edit_desc" required></textarea>
                <div class="form-btns">
                    <button type="button" class="back-link" onclick="closeEditModal()">Cancel</button>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script>
    // Modal logic
    const projects = <?php echo json_encode($projects); ?>;
    function openEditModal(idx) {
        const modalBg = document.getElementById('editModalBg');
        const form = document.getElementById('editProjectForm');
        const project = projects[idx];
        document.getElementById('edit_index').value = idx;
        document.getElementById('edit_name').value = project.name;
        document.getElementById('edit_duration').value = project.duration;
        document.getElementById('edit_technologies').value = project.technologies;
        document.getElementById('edit_desc').value = project.desc;
        // Images
        const previewList = document.getElementById('edit_imagePreviewList');
        previewList.innerHTML = '';
        if (project.images) {
            project.images.forEach(function(img, i) {
                const div = document.createElement('div');
                div.className = 'image-preview-item';
                div.innerHTML = `<img src="${img}" alt="Current Image"><label class='cover-radio'><input type='radio' name='edit_cover_image' value='${img}' ${(img===project.cover_image)?'checked':''}/> Cover</label><label><input type='checkbox' name='edit_old_images[]' value='${img}' checked> Keep</label>`;
                previewList.appendChild(div);
            });
        }
        document.getElementById('edit_newImagePreviewList').innerHTML = '';
        modalBg.classList.add('active');
    }
    function closeEditModal() {
        document.getElementById('editModalBg').classList.remove('active');
        document.getElementById('editProjectForm').reset();
        document.getElementById('edit_imagePreviewList').innerHTML = '';
        document.getElementById('edit_newImagePreviewList').innerHTML = '';
    }
    // Show new image previews in modal
    function showEditNewImagePreviews(input) {
        const previewList = document.getElementById('edit_newImagePreviewList');
        previewList.innerHTML = '';
        if (input.files && input.files.length > 0) {
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    previewList.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        }
    }
    // Close modal on background click
    document.getElementById('editModalBg').onclick = function(e) {
        if (e.target === this) closeEditModal();
    };
    </script>
</body>
</html> 