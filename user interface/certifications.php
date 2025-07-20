<?php
$certifications_file = '../certifications.json';
$certifications = file_exists($certifications_file) ? json_decode(file_get_contents($certifications_file), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certifications | Harsh Kumar</title>
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
        .certifications-section { max-width: 1100px; margin: 40px auto 0 auto; padding: 0 16px; }
        .certifications-title { color: #fbbf24; font-size: 2rem; font-weight: 800; margin-bottom: 1.5rem; text-align: center; text-shadow: 0 4px 24px #6366f1cc, 0 2px 8px #23233a44; }
        .certification-cards { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; align-items: flex-start; }
        .certification-card { width: 340px; height: 340px; background: #18181b; border-radius: 20px; box-shadow: 0 2px 16px #6366f1aa, 0 2px 8px #23233a44; display: flex; flex-direction: column; align-items: stretch; justify-content: stretch; margin-bottom: 0; transition: transform 0.5s cubic-bezier(.68,-0.55,.27,1.55), box-shadow 0.3s; padding: 0; text-align: left; border: 2px solid #6366f1; position: relative; overflow: hidden; opacity: 0; transform: translateY(60px); }
        .certification-card.visible { opacity: 1; transform: translateY(0); }
        .certification-img-section { flex: 0 0 50%; height: 50%; display: flex; align-items: center; justify-content: center; background: #23233a; border-bottom: 1.5px solid #6366f1; border-right: none; padding: 0; width: 100%; min-height: 0; max-height: none; }
        .certification-img-section img { max-width: 90%; max-height: 90%; object-fit: contain; border-radius: 12px; box-shadow: 0 2px 8px #6366f1aa; }
        .certification-info-section { flex: 1 1 50%; height: 50%; display: flex; flex-direction: column; align-items: flex-start; justify-content: center; padding: 24px 18px 18px 18px; background: transparent; width: 100%; height: 100%; box-sizing: border-box; overflow: hidden; }
        .certification-title { color: #fbbf24; font-size: 1.25rem; font-weight: 700; margin-bottom: 0.7rem; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .certification-desc { color: #f3f4f6; font-size: 1.08rem; font-weight: 400; line-height: 1.6; word-break: break-word; margin-bottom: 0; margin-top: 0; text-align: left; width: 100%; max-width: 100%; overflow-wrap: break-word; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; }
        .certification-duration { color: #a5b4fc; font-size: 1rem; font-weight: 500; margin-top: 0.5rem; }
        @media (max-width: 900px) {
            .navbar-container { padding: 0.2rem 0.5rem; }
            .certification-card { width: 45vw; min-width: 220px; max-width: 98vw; height: 260px; }
            .certification-cards { gap: 18px; }
        }
        @media (max-width: 700px) {
            .certification-cards { flex-direction: column; gap: 18px; }
            .certification-card { width: 98vw; min-width: 120px; height: 220px; flex-direction: column; }
            .certification-img-section { border-right: none; border-bottom: 1.5px solid #6366f1; width: 100%; min-height: 0; max-height: none; height: 50%; }
            .certification-info-section { align-items: center; padding: 14px 8px 10px 8px; width: 100%; min-height: 0; height: 50%; }
            .certification-desc { text-align: center; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="project.php">Projects</a></li>
                <li><a href="certifications.php" class="active">Certifications</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    <section class="certifications-section" id="certifications">
        <div class="certifications-title">My Certifications</div>
        <div class="certification-cards" id="certificationCards">
            <?php foreach ($certifications as $cert): ?>
                <div class="certification-card">
                    <div class="certification-img-section">
                        <?php
                        $img = !empty($cert['images'][0]) ? $cert['images'][0] : '';
                        $imgSrc = ($img && (strpos($img, 'http') === 0 || strpos($img, '/') === 0)) ? $img : ($img ? '../' . $img : '');
                        if ($imgSrc) {
                            echo '<img src="' . htmlspecialchars($imgSrc) . '" alt="' . htmlspecialchars($cert['title']) . '" />';
                        } else {
                            echo '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#a5b4fc;">No Image</div>';
                        }
                        ?>
                    </div>
                    <div class="certification-info-section">
                        <div class="certification-title"><?php echo htmlspecialchars($cert['title']); ?></div>
                        <div class="certification-desc"><?php echo htmlspecialchars($cert['desc']); ?></div>
                        <div class="certification-duration"><?php echo htmlspecialchars($cert['duration']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <script>
    // Slide-in animation for certification cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.certification-card');
        cards.forEach((card, i) => {
            setTimeout(() => {
                card.classList.add('visible');
            }, 200 + i * 180);
        });
    });
    </script>
</body>
</html> 