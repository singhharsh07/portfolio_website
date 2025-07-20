<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Harsh Kumar</title>
    <style>
html {
    scroll-behavior: smooth;
}
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #23233a 0%, #6366f1 100%);
    color: #f3f4f6;
    line-height: 1.6;
    min-height: 100vh;
}
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: rgba(24, 24, 27, 0.7);
    box-shadow: 0 2px 24px #6366f144;
    z-index: 1000;
    backdrop-filter: blur(12px) saturate(180%);
    border-bottom: 1px solid rgba(99, 102, 241, 0.15);
    transition: background 0.3s;
    height: 48px;
}
.navbar-container {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.2rem 1rem;
    height: 48px;
}
.logo {
    font-size: 1.1rem;
    color: #fbbf24;
    font-weight: bold;
    letter-spacing: 1px;
    text-shadow: 0 1px 4px #6366f1aa;
    margin-right: 1.2rem;
    white-space: nowrap;
}
.nav-links {
    list-style: none;
    display: flex;
    gap: 1.1rem;
    margin: 0;
    padding: 0;
    align-items: center;
}
.nav-links li a {
    color: #a5b4fc;
    text-decoration: none;
    font-size: 0.98rem;
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 6px;
    transition: color 0.3s, background 0.3s, box-shadow 0.3s;
    position: relative;
    line-height: 1.2;
}
.nav-links li a:hover, .nav-links li a:focus {
    color: #fff;
    background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%);
    box-shadow: 0 2px 12px #6366f1aa;
}
.nav-links li a.active {
    color: #fbbf24;
    background: #23233a;
    box-shadow: 0 2px 8px #fbbf24aa;
}
.hero {
    margin-top: 80px;
    position: relative;
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, #23233a 60%, #6366f1 100%);
    overflow: hidden;
}
.hero-content {
    position: relative;
    z-index: 2;
    background: rgba(35, 35, 58, 0.7);
    border-radius: 32px;
    box-shadow: 0 8px 48px #6366f1aa, 0 2px 16px #23233a88;
    padding: 32px 36px 24px 36px;
    display: flex;
    flex-direction: column;
    align-items: center;
    backdrop-filter: blur(8px) saturate(160%);
    border: 1.5px solid rgba(99, 102, 241, 0.18);
    min-width: 320px;
    max-width: 420px;
    margin: 0 16px;
}
.hero-content h1 {
    font-size: 2.1rem;
    font-weight: 800;
    color: #fbbf24;
    letter-spacing: 2px;
    margin-bottom: 0.5rem;
    text-shadow: 0 4px 24px #6366f1cc, 0 2px 8px #23233a44;
    text-align: center;
}
.hero-content p {
    font-size: 1.08rem;
    color: #a5b4fc;
    margin-bottom: 1.2rem;
    font-weight: 600;
    text-shadow: 0 2px 8px #23233a44;
    text-align: center;
}
.dashboard-section {
    max-width: 900px;
    margin: 36px auto 0 auto;
    padding: 24px 0 0 0;
    display: flex;
    flex-wrap: wrap;
    gap: 32px;
    justify-content: center;
    align-items: flex-start;
}
.dashboard-card {
    width: 320px;
    height: 180px;
    background: #18181b;
    border-radius: 20px;
    box-shadow: 0 2px 16px #6366f1aa, 0 2px 8px #23233a44;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 28px 18px 18px 18px;
    border: 2px solid #6366f1;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
    text-align: center;
}
.dashboard-card:hover {
    transform: scale(1.04) rotateY(2deg);
    box-shadow: 0 8px 32px #6366f1cc;
}
.dashboard-icon {
    font-size: 2.8rem;
    margin-bottom: 0.7rem;
    color: #fbbf24;
    text-shadow: 0 2px 8px #6366f1aa;
}
.dashboard-title {
    color: #a5b4fc;
    font-size: 1.18rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}
.dashboard-desc {
    color: #f3f4f6;
    font-size: 1.01rem;
    font-weight: 400;
    line-height: 1.5;
}
.footer {
    background: linear-gradient(90deg, #23233a 60%, #6366f1 100%);
    color: #a5b4fc;
    padding: 32px 0 16px 0;
    text-align: center;
    margin-top: 40px;
    box-shadow: 0 -4px 32px #6366f1aa;
    border-top-left-radius: 32px;
    border-top-right-radius: 32px;
    position: relative;
    overflow: hidden;
}
.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}
.footer-links {
    display: flex;
    gap: 1.5rem;
    margin-top: 0.5rem;
}
.footer-links a {
    color: #fbbf24;
    text-decoration: none;
    font-size: 1.1rem;
    font-weight: 500;
    transition: color 0.3s, text-shadow 0.3s;
    text-shadow: 0 2px 8px #6366f1aa;
}
.footer-links a:hover {
    color: #fff;
    text-shadow: 0 2px 16px #fbbf24aa;
}
@media (max-width: 900px) {
    .navbar-container {
        padding: 0.2rem 0.5rem;
    }
    .dashboard-section {
        gap: 18px;
    }
    .dashboard-card {
        width: 98vw;
        max-width: 340px;
        min-width: 180px;
    }
}
@media (max-width: 700px) {
    .dashboard-section {
        flex-direction: column;
        gap: 18px;
        align-items: center;
    }
    .dashboard-card {
        width: 98vw;
        min-width: 120px;
        height: auto;
        padding: 18px 8px 14px 8px;
    }
}
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="admin.php" class="active">Admin</a></li>
                <li><a href="project.php">Projects</a></li>
                <li><a href="certification.php">Certifications</a></li>
                <li><a href="messages.php">Messages</a></li>
            </ul>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <h1>Admin Dashboard</h1>
            <p>Manage your portfolio content and messages here.</p>
        </div>
    </section>
    <!-- Dashboard Section -->
    <section class="dashboard-section" id="dashboard">
        <div class="dashboard-card">
            <div class="dashboard-icon">📁</div>
            <div class="dashboard-title">Projects</div>
            <div class="dashboard-desc">Add, edit, or remove portfolio projects. Keep your work up to date.</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon">🎓</div>
            <div class="dashboard-title">Certifications</div>
            <div class="dashboard-desc">Manage your certifications and achievements to showcase your skills.</div>
        </div>
        <div class="dashboard-card">
            <div class="dashboard-icon">✉️</div>
            <div class="dashboard-title">Messages</div>
            <div class="dashboard-desc">View and respond to messages sent via your contact form.</div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <span>&copy; 2024 Harsh Kumar. All rights reserved.</span>
            <div class="footer-links">
                <a href="https://linkedin.com/in/Harshkumar" target="_blank">LinkedIn</a>
                <a href="https://github.com/Harshkumar" target="_blank">GitHub</a>
                <a href="mailto:harshanskd@gmail.com">Email</a>
            </div>
        </div>
    </footer>
    <script>
    // Hamburger menu for mobile
    window.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelector('.nav-links');
        const navbar = document.querySelector('.navbar');
        if (window.innerWidth <= 700 && navLinks) {
            if (!document.querySelector('.hamburger')) {
                const hamburger = document.createElement('div');
                hamburger.className = 'hamburger';
                hamburger.innerHTML = '<span></span><span></span><span></span>';
                navbar.querySelector('.navbar-container').appendChild(hamburger);
                hamburger.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }
        }
        window.addEventListener('resize', () => {
            if (window.innerWidth > 700 && navLinks) {
                navLinks.classList.remove('active');
            }
        });
    });
    </script>
</body>
</html>
