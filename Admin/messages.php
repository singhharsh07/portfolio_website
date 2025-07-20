<?php
$messages_file = '../messages.json';
$messages = file_exists($messages_file) ? json_decode(file_get_contents($messages_file), true) : [];

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_index'])) {
    $delete_index = (int)$_POST['delete_index'];
    // Reverse to match display order
    $messages = array_reverse($messages);
    if (isset($messages[$delete_index])) {
        array_splice($messages, $delete_index, 1);
        $messages = array_reverse($messages); // Restore order
        file_put_contents($messages_file, json_encode($messages, JSON_PRETTY_PRINT));
        header('Location: messages.php');
        exit;
    }
    $messages = array_reverse($messages); // Restore order if not deleted
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Admin</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #23233a 0%, #6366f1 100%); color: #f3f4f6; min-height: 100vh; }
        .navbar { position: fixed; top: 0; left: 0; width: 100%; background: rgba(24,24,27,0.7); box-shadow: 0 2px 24px #6366f144; z-index: 1000; backdrop-filter: blur(12px) saturate(180%); border-bottom: 1px solid rgba(99,102,241,0.15); transition: background 0.3s; height: 48px; }
        .navbar-container { max-width: 1100px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; padding: 0.2rem 1rem; height: 48px; }
        .logo { font-size: 1.1rem; color: #fbbf24; font-weight: bold; letter-spacing: 1px; text-shadow: 0 1px 4px #6366f1aa; margin-right: 1.2rem; white-space: nowrap; }
        .nav-links { list-style: none; display: flex; gap: 1.1rem; margin: 0; padding: 0; align-items: center; }
        .nav-links li a { color: #a5b4fc; text-decoration: none; font-size: 0.98rem; font-weight: 500; padding: 5px 10px; border-radius: 6px; transition: color 0.3s, background 0.3s, box-shadow 0.3s; position: relative; line-height: 1.2; }
        .nav-links li a:hover, .nav-links li a:focus { color: #fff; background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%); box-shadow: 0 2px 12px #6366f1aa; }
        .nav-links li a.active { color: #fbbf24; background: #23233a; box-shadow: 0 2px 8px #fbbf24aa; }
        .admin-container { max-width: 1200px; margin: 80px auto 0 auto; padding: 32px 16px 0 16px; }
        table { width: 100%; border-collapse: collapse; background: #23233a; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px #6366f1aa; }
        th, td { padding: 18px 12px; text-align: left; border-bottom: 1px solid #6366f1; }
        th { background: #23233a; color: #fbbf24; font-size: 1.1rem; font-weight: 700; }
        td { color: #f3f4f6; font-size: 1.05rem; vertical-align: top; }
        tr:last-child td { border-bottom: none; }
        .delete-btn { background: none; border: none; cursor: pointer; padding: 0; margin: 0; }
        .delete-btn svg { width: 22px; height: 22px; fill: #ef4444; transition: fill 0.2s; vertical-align: middle; }
        .delete-btn:hover svg { fill: #b91c1c; }
        @media (max-width: 900px) { .admin-container { padding: 12px 2vw 0 2vw; } th, td { padding: 10px 6px; font-size: 0.98rem; } }
        @media (max-width: 600px) { .admin-container { padding: 4px 0 0 0; } table, thead, tbody, th, td, tr { display: block; } th { position: absolute; left: -9999px; top: -9999px; } tr { margin-bottom: 18px; border-radius: 12px; box-shadow: 0 2px 8px #6366f1aa; background: #23233a; } td { border: none; position: relative; padding: 12px 8px; font-size: 0.95rem; } }
    </style>
    <script>
    function confirmDelete(form) {
        if (confirm('Are you sure you want to delete this message?')) {
            form.submit();
        }
        return false;
    }
    </script>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="admin.php">Home</a></li>
                <li><a href="project.php">Projects</a></li>
                <li><a href="certification.php">Certifications</a></li>
                <li><a href="messages.php" class="active">Messages</a></li>
            </ul>
        </div>
    </nav>
    <div class="admin-container">
        <h2 style="color:#fbbf24; margin-bottom:1.5rem;">User Messages</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $displayed = array_reverse($messages); foreach ($displayed as $i => $msg): ?>
                <tr>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($msg['message'])); ?></td>
                    <td><?php echo htmlspecialchars($msg['date']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;" onsubmit="return confirmDelete(this);">
                            <input type="hidden" name="delete_index" value="<?php echo $i; ?>">
                            <button type="submit" class="delete-btn" title="Delete">
                                <svg viewBox="0 0 24 24"><path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zm3.46-8.12a1 1 0 0 1 1.41 0L12 11.59l1.12-1.12a1 1 0 1 1 1.41 1.41L13.41 13l1.12 1.12a1 1 0 0 1-1.41 1.41L12 14.41l-1.12 1.12a1 1 0 1 1-1.41-1.41L10.59 13l-1.12-1.12a1 1 0 0 1 0-1.41z"/><rect x="4" y="4" width="16" height="2" rx="1"/></svg>
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