<?php
$projects_file = '../projects.json';
$uploads_dir = '../uploads/';
if (!file_exists($uploads_dir)) {
    mkdir($uploads_dir, 0777, true);
}
$projects = file_exists($projects_file) ? json_decode(file_get_contents($projects_file), true) : [];
$index = isset($_GET['id']) ? (int)$_GET['id'] : -1;
if ($index < 0 || !isset($projects[$index])) {
    header('Location: project.php');
    exit();
}
$project = $projects[$index];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    $desc = trim($_POST['desc'] ?? '');
    $old_images = $_POST['old_images'] ?? [];
    $images = is_array($old_images) ? array_values(array_filter($old_images)) : [];
    // Handle new uploads
    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $idx => $tmp_name) {
            if ($_FILES['images']['error'][$idx] === 0) {
                $ext = pathinfo($_FILES['images']['name'][$idx], PATHINFO_EXTENSION);
                $filename = uniqid('img_', true) . '.' . $ext;
                $target = $uploads_dir . $filename;
                if (move_uploaded_file($tmp_name, $target)) {
                    $images[] = 'uploads/' . $filename;
                }
            }
        }
    }
    // Normalize all image paths to uploads/
    foreach ($images as &$img) {
        if (strpos($img, 'uploads/') !== 0) {
            $img = 'uploads/' . ltrim(str_replace(['images/', 'uploads/'], '', $img), '/');
        }
    }
    unset($img);
    $cover_image = $_POST['cover_image'] ?? ($images[0] ?? '');
    if ($name && $duration && $technologies && $desc && count($images) > 0 && $cover_image) {
        $projects[$index] = [
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | Admin</title>
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
        .form-container {
            max-width: 520px; margin: 80px auto 0 auto; background: #23233a; border-radius: 20px; box-shadow: 0 8px 48px #6366f1aa, 0 2px 16px #23233a88; padding: 36px 32px 28px 32px; display: flex; flex-direction: column; align-items: center; border: 1.5px solid rgba(99,102,241,0.18); }
        .form-container h2 { color: #fbbf24; margin-bottom: 1.2rem; font-size: 1.5rem; }
        form { width: 100%; display: flex; flex-direction: column; gap: 1.1rem; }
        label { color: #a5b4fc; font-weight: 600; margin-bottom: 0.2rem; }
        input, textarea { padding: 10px; border-radius: 8px; border: none; background: #18181b; color: #f3f4f6; font-size: 1rem; box-shadow: 0 1px 4px #6366f122; }
        textarea { min-height: 60px; max-height: 120px; }
        .image-preview-list { display: flex; gap: 16px; flex-wrap: wrap; margin: 10px 0; }
        .image-preview-item { display: flex; flex-direction: column; align-items: center; }
        .image-preview-item img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px #6366f1aa; border: 2px solid #6366f1; margin-bottom: 4px; }
        .cover-radio { margin-top: 4px; }
        .remove-img { color: #ef4444; background: none; border: none; cursor: pointer; font-size: 0.9rem; margin-top: 2px; }
        .form-btns { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.2rem; }
        button, .back-link { background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%); color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 1.05rem; cursor: pointer; font-weight: 600; box-shadow: 0 2px 8px #6366f1aa; transition: background 0.3s, color 0.3s; text-decoration: none; display: inline-block; }
        button:hover, .back-link:hover { background: #fbbf24; color: #23233a; }
        .back-link { margin-right: auto; }
        @media (max-width: 600px) {
            .form-container { padding: 18px 4vw 12px 4vw; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="project.php" class="active">Projects</a></li>
                <li><a href="certification.php">Certifications</a></li>
                <li><a href="../contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    <div class="form-container">
        <h2>Edit Project</h2>
        <form method="POST" enctype="multipart/form-data" action="edit_project.php?id=<?php echo $index; ?>">
            <label for="name">Project Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
            <label>Current Images</label>
            <div class="image-preview-list">
                <?php foreach ($project['images'] as $i => $img): ?>
                <div class="image-preview-item">
                    <img src="<?php echo htmlspecialchars($img); ?>" alt="Current Image">
                    <label class='cover-radio'><input type='radio' name='cover_image' value='<?php echo htmlspecialchars($img); ?>' <?php if ($img == $project['cover_image']) echo 'checked'; ?>/> Cover</label>
                    <label><input type="checkbox" name="old_images[]" value="<?php echo htmlspecialchars($img); ?>" checked> Keep</label>
                </div>
                <?php endforeach; ?>
            </div>
            <label for="images">Add New Images</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
            <label for="duration">Duration</label>
            <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($project['duration']); ?>" required>
            <label for="technologies">Technologies Used</label>
            <input type="text" id="technologies" name="technologies" value="<?php echo htmlspecialchars($project['technologies']); ?>" required>
            <label for="desc">Description</label>
            <textarea id="desc" name="desc" required><?php echo htmlspecialchars($project['desc']); ?></textarea>
            <div class="form-btns">
                <a href="project.php" class="back-link">Cancel</a>
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html> 