<?php
$projects_file = '../projects.json';
$projects = file_exists($projects_file) ? json_decode(file_get_contents($projects_file), true) : [];
$index = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = $projects[$index] ?? $projects[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['name']); ?> | Project Details</title>
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
        .container { max-width: 100vw; margin: 0; padding: 0; display: flex; flex-direction: column; align-items: center; min-height: 100vh; }
        .slider-container { width: 100vw; height: calc(100vh - 180px); max-width: 100vw; max-height: calc(100vh - 180px); background: #23233a; border-radius: 0; box-shadow: none; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; margin-bottom: 0; margin-top: 48px; }
        .slider-img { width: 100vw; height: 100%; object-fit: contain; border-radius: 0; position: absolute; left: 0; top: 0; opacity: 0; transition: opacity 0.5s, transform 0.5s; z-index: 1; background: #18181b; }
        .slider-img.active { opacity: 1; z-index: 2; transform: translateX(0); }
        .slider-img.slide-left { transform: translateX(-100%); }
        .slider-img.slide-right { transform: translateX(100%); }
        .slider-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: rgba(35,35,58,0.7); border: none; color: #fbbf24; font-size: 2.8rem; border-radius: 50%; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 10; transition: background 0.2s; }
        .slider-arrow.left { left: 18px; }
        .slider-arrow.right { right: 18px; }
        .slider-arrow:hover { background: #6366f1; color: #fff; }
        .slider-dots { position: absolute; bottom: 18px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 20; }
        .slider-dot { width: 14px; height: 14px; border-radius: 50%; background: #6366f1; opacity: 0.5; cursor: pointer; transition: opacity 0.2s, background 0.2s; }
        .slider-dot.active { background: #fbbf24; opacity: 1; }
        .project-title { color: #fbbf24; font-size: 2.2rem; font-weight: 800; margin: 24px 0 0 0; text-align: center; text-shadow: 0 4px 24px #6366f1cc, 0 2px 8px #23233a44; }
        .project-desc { color: #a5b4fc; font-size: 1.18rem; font-weight: 500; line-height: 1.7; text-align: center; margin-bottom: 0; margin-top: 12px; }
        .back-btn { margin-top: 24px; background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%); color: #fff; border: none; border-radius: 8px; padding: 12px 28px; font-size: 1.1rem; font-weight: 600; cursor: pointer; box-shadow: 0 2px 8px #6366f1aa; transition: background 0.3s, color 0.3s; }
        .back-btn:hover { background: #fbbf24; color: #23233a; }
        @media (max-width: 900px) { .slider-arrow { width: 40px; height: 40px; font-size: 2rem; } .slider-dot { width: 10px; height: 10px; } .slider-container { height: 40vh; max-height: 40vh; } }
        @media (max-width: 600px) { .slider-img { height: 40vh; } .slider-container { height: 40vh; max-height: 40vh; } .slider-arrow { width: 28px; height: 28px; font-size: 1.2rem; left: 8px; right: 8px; } .slider-dot { width: 8px; height: 8px; } .project-title { font-size: 1.2rem; } .project-desc { font-size: 1rem; } .container { padding: 0; } }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="project.php" class="active">Projects</a></li>
                <li><a href="certifications.html">Certifications</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="slider-container" id="sliderContainer">
            <?php foreach ($project['images'] as $i => $img): ?>
                <?php
                $imgSrc = (strpos($img, 'http') === 0 || strpos($img, '/') === 0) ? $img : '../' . $img;
                ?>
                <img class="slider-img<?php echo $i === 0 ? ' active' : ''; ?>" src="<?php echo htmlspecialchars($imgSrc); ?>" alt="Screenshot" data-index="<?php echo $i; ?>" />
            <?php endforeach; ?>
            <?php if (count($project['images']) > 1): ?>
                <button class="slider-arrow left" id="sliderPrev">&#8592;</button>
                <button class="slider-arrow right" id="sliderNext">&#8594;</button>
                <div class="slider-dots" id="sliderDots">
                    <?php foreach ($project['images'] as $i => $img): ?>
                        <div class="slider-dot<?php echo $i === 0 ? ' active' : ''; ?>" data-index="<?php echo $i; ?>"></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="project-title"><?php echo htmlspecialchars($project['name']); ?></div>
        <div style="color: #fbbf24; font-size: 1.05rem; font-weight: 600; margin-top: 10px; text-align: center;">
            Duration: <?php echo htmlspecialchars($project['duration']); ?>
        </div>
        <div style="color: #a5b4fc; font-size: 1.05rem; font-weight: 600; margin-top: 4px; text-align: center;">
            Technologies Used: <?php echo htmlspecialchars($project['technologies']); ?>
        </div>
        <div class="project-desc"><?php echo nl2br(htmlspecialchars($project['desc'])); ?></div>
        <a href="project.php" class="back-btn">&larr; Back to Projects</a>
    </div>
    <script>
    const imgs = document.querySelectorAll('.slider-img');
    const dots = document.querySelectorAll('.slider-dot');
    let current = 0;
    let autoSlideTimer = null;
    function showSlide(idx, direction) {
        imgs.forEach((img, i) => {
            img.classList.remove('active', 'slide-left', 'slide-right');
            if (i === idx) {
                img.classList.add('active');
            } else if (direction === 'left' && i === current) {
                img.classList.add('slide-right');
            } else if (direction === 'right' && i === current) {
                img.classList.add('slide-left');
            }
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === idx);
        });
        current = idx;
    }
    function nextSlide() {
        let next = (current + 1) % imgs.length;
        showSlide(next, 'right');
    }
    function startAutoSlide() {
        if (autoSlideTimer) clearInterval(autoSlideTimer);
        autoSlideTimer = setInterval(nextSlide, 2000);
    }
    function pauseAutoSlide() {
        if (autoSlideTimer) clearInterval(autoSlideTimer);
        autoSlideTimer = setInterval(nextSlide, 2000);
    }
    if (imgs.length > 1) {
        document.getElementById('sliderPrev').onclick = function(e) {
            let next = (current - 1 + imgs.length) % imgs.length;
            showSlide(next, 'left');
            pauseAutoSlide();
        };
        document.getElementById('sliderNext').onclick = function(e) {
            let next = (current + 1) % imgs.length;
            showSlide(next, 'right');
            pauseAutoSlide();
        };
        dots.forEach(dot => {
            dot.onclick = function() {
                let idx = parseInt(dot.getAttribute('data-index'));
                showSlide(idx, idx < current ? 'left' : 'right');
                pauseAutoSlide();
            };
        });
        startAutoSlide();
    }
    </script>
</body>
</html> 