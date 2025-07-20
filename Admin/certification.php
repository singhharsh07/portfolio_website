<?php
$certifications_file = '../certifications.json';
$certifications = file_exists($certifications_file) ? json_decode(file_get_contents($certifications_file), true) : [
    [
        'title' => 'Full Stack Web Development',
        'desc' => 'Certification for completing a comprehensive full stack web development course covering HTML, CSS, JavaScript, PHP, and MySQL.',
        'duration' => 'Jan 2023 - May 2023',
        'images' => [
            'uploads/cert1.jpg',
            'uploads/cert2.jpg'
        ]
    ],
    [
        'title' => 'Responsive Design',
        'desc' => 'Certification for mastering responsive web design techniques and building mobile-friendly websites.',
        'duration' => 'Jun 2022 - Aug 2022',
        'images' => [
            'uploads/cert3.jpg'
        ]
    ]
];
// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $delete_index = (int)$_POST['delete_index'];
    if (isset($certifications[$delete_index])) {
        array_splice($certifications, $delete_index, 1);
        file_put_contents($certifications_file, json_encode($certifications, JSON_PRETTY_PRINT));
        header('Location: certification.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Certifications | Harsh Kumar</title>
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
        }
        @media (max-width: 600px) {
            .admin-container { padding: 4px 0 0 0; }
            table, thead, tbody, th, td, tr { display: block; }
            th { position: absolute; left: -9999px; top: -9999px; }
            tr { margin-bottom: 18px; border-radius: 12px; box-shadow: 0 2px 8px #6366f1aa; background: #23233a; }
            td { border: none; position: relative; padding: 12px 8px; font-size: 0.95rem; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="admin.php">Home</a></li>
                <li><a href="project.php">Projects</a></li>
                <li><a href="certification.php" class="active">Certifications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </nav>
    <div class="admin-container">
        <div class="topbar">
            <a href="add_certification.php" class="add-btn">+ Add New Certification</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($certifications as $index => $cert): ?>
                <tr>
                    <td><?php echo htmlspecialchars($cert['title']); ?></td>
                    <td><?php echo htmlspecialchars($cert['desc']); ?></td>
                    <td><?php echo htmlspecialchars($cert['duration']); ?></td>
                    <td style="min-width:90px;">
                        <a href="edit_certification.php?id=<?php echo $index; ?>" class="action-btn edit" title="Edit">
                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19.5 3 21l1.5-4L16.5 3.5z"/></svg>
                        </a>
                        <form method="POST" action="certification.php" style="display:inline;">
                            <input type="hidden" name="delete_index" value="<?php echo $index; ?>">
                            <button type="submit" class="action-btn delete" title="Delete">
                                <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 