<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harsh Kumar | Portfolio</title>
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

/* Glassmorphism Navbar */
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
    min-height: 420px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(120deg, #23233a 60%, #6366f1 100%);
    overflow: hidden;
}
.hero::before {
    content: '';
    position: absolute;
    top: -40px;
    left: -40px;
    width: 120%;
    height: 120%;
    background: radial-gradient(circle at 60% 40%, #6366f1 0%, #23233a 80%);
    opacity: 0.25;
    z-index: 0;
}
.hero-content {
    position: relative;
    z-index: 2;
    background: rgba(35, 35, 58, 0.7);
    border-radius: 32px;
    box-shadow: 0 8px 48px #6366f1aa, 0 2px 16px #23233a88;
    padding: 48px 36px 36px 36px;
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
    font-size: 2.7rem;
    font-weight: 800;
    color: #fbbf24;
    letter-spacing: 2px;
    margin-bottom: 0.5rem;
    text-shadow: 0 4px 24px #6366f1cc, 0 2px 8px #23233a44;
    text-align: center;
}
.hero-content p {
    font-size: 1.3rem;
    color: #a5b4fc;
    margin-bottom: 2rem;
    font-weight: 600;
    text-shadow: 0 2px 8px #23233a44;
    text-align: center;
}
#threejs-canvas {
    width: 200px;
    height: 200px;
    margin: 0 auto 16px auto;
    background: #22223b;
    border-radius: 16px;
    box-shadow: 0 4px 32px #6366f1aa;
    border: 2px solid #6366f1;
}
#extra-animation {
    /* keep previous styles for glowing/gradient */
    margin-top: 12px;
}
@keyframes gradientGlow {
    0% {
        filter: brightness(1) blur(0px);
        background-position: 0% 50%;
    }
    100% {
        filter: brightness(1.2) blur(2px);
        background-position: 100% 50%;
    }
}
.bubble {
    position: absolute;
    border-radius: 50%;
    opacity: 0.6;
    animation: floatBubble 8s infinite linear;
}
@keyframes floatBubble {
    0% {
        transform: translateY(0) scale(1);
        opacity: 0.7;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: translateY(-200px) scale(1.2);
        opacity: 0;
    }
}
section {
    max-width: 820px;
    min-width: 220px;
    min-height: 80px;
    margin: 24px auto;
    padding: 12px 38px 10px 38px;
    background: rgba(35, 35, 58, 0.92);
    border-radius: 12px 32px 12px 32px;
    box-shadow: 0 2px 16px #6366f133;
    backdrop-filter: blur(4px);
    display: flex;
    flex-direction: column;
    justify-content: center;
}
h2 {
    color: #a5b4fc;
    margin-bottom: 1rem;
    font-size: 2rem;
    text-shadow: 0 2px 8px #23233a44;
}
.card {
    background: #18181b;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px #6366f122;
    transition: transform 0.3s, box-shadow 0.3s;
}
.card:hover {
    transform: translateY(-6px) scale(1.03) rotateY(2deg);
    box-shadow: 0 8px 32px #6366f1aa;
}
.skills ul, .certifications ul {
    list-style: none;
    padding: 0;
}
.skills li, .certifications li {
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}
.contact-info {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin: 30px 0;
    font-size: 1.1rem;
}
.contact-info a, .contact-info span {
    color: #fbbf24;
    text-decoration: none;
    transition: color 0.3s;
}
.contact-info a:hover {
    color: #6366f1;
}
.contact-form form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 400px;
    margin: 0 auto;
}
.contact-form input, .contact-form textarea {
    padding: 12px;
    border-radius: 8px;
    border: none;
    background: #18181b;
    color: #f3f4f6;
    font-size: 1rem;
    box-shadow: 0 1px 4px #6366f122;
}
.contact-form button {
    background: linear-gradient(90deg, #6366f1 60%, #fbbf24 100%);
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.3s, color 0.3s;
    font-weight: 600;
    box-shadow: 0 2px 8px #6366f1aa;
}
.contact-form button:hover {
    background: #fbbf24;
    color: #23233a;
}

/* Glowing Footer */
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
    #extra-animation {
        right: 2%;
        width: 80px;
        height: 80px;
    }
    section {
        max-width: 99vw;
        padding: 8px 2vw 8px 2vw;
        margin: 14px 0;
        border-radius: 8px 18px 8px 18px;
    }
}
@media (max-width: 700px) {
    .nav-links {
        flex-direction: column;
        background: rgba(35, 35, 58, 0.95);
        position: absolute;
        top: 48px;
        right: 0;
        width: 160px;
        display: none;
        box-shadow: 0 4px 16px #6366f122;
        border-radius: 0 0 12px 12px;
    }
    .nav-links.active {
        display: flex;
    }
    .navbar-container {
        flex-direction: row;
        justify-content: space-between;
    }
    .navbar .hamburger {
        display: block;
        cursor: pointer;
        width: 28px;
        height: 28px;
        margin-left: 1rem;
    }
    .navbar .hamburger span {
        display: block;
        height: 3px;
        width: 100%;
        background: #a5b4fc;
        margin: 5px 0;
        border-radius: 2px;
        transition: 0.3s;
    }
    .hero-content {
        padding: 28px 8px 24px 8px;
        min-width: 0;
        max-width: 98vw;
    }
    .hero-content h1 {
        font-size: 1.5rem;
    }
    .hero {
        min-height: 320px;
    }
    @media (max-width: 600px) {
        section {
            padding: 4px 1vw 4px 1vw;
            margin: 8px 0;
            min-width: 0;
            border-radius: 6px 12px 6px 12px;
        }
    }
} 
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <span class="logo">Harsh Kumar</span>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="project.php">Projects</a></li>
                <li><a href="certifications.php">Certifications</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <h1>Harsh Kumar</h1>
            <p>Full Stack Web Developer</p>
            <div id="threejs-canvas"></div>
            <div id="extra-animation"></div>
        </div>
    </section>
    <!-- Skills -->
    <section class="skills" id="skills">
        <h2>Skills Summary</h2>
        <ul>
            <li><strong>Languages:</strong> Javascript, C, C++, Python, Java, PHP</li>
            <li><strong>Frameworks:</strong> Bootstrap, Tailwind</li>
            <li><strong>Tools/Platform:</strong> Pandas, NumPy, Matplotlib, Seaborn</li>
            <li><strong>Soft Skills:</strong> Leadership, Communication, Project Management, Decision-Making, Team Coordination</li>
        </ul>
    </section>
    <!-- Internship -->
    <section class="internship" id="internship">
        <h2>Internship</h2>
        <div class="card">
            <h3>Front End Web Development</h3>
            <span>Byteminders (Remote) | Nov 2024 - Feb 2025</span>
            <p>At Byteminders, I create visual components of a website or web application that users interact with. During my time at Bytemiders, I worked as a Front-End Web Developer, contributing to the development and maintenance of dynamic, user-centric web applications. My responsibilities included collaborating with designers and back-end developers to create seamless, responsive, and visually engaging websites.</p>
            <p><strong>Tech stacks used:</strong> HTML5, CSS3, Javascript</p>
        </div>
    </section>
    <!-- Projects -->
    <section class="projects" id="projects">
        <h2>Full Stack Projects</h2>
        <div class="card">
            <h3>Resort Website</h3>
            <span>Jan 2024 – Feb 2024</span>
            <p>The resort website is designed to provide visitors with a user-friendly, visually appealing interface to explore the amenities, book rooms, and view the resort's offerings. The website includes sections such as a homepage, about the resort, rooms & amenities, booking options, and a contact form.</p>
        </div>
        <div class="card">
            <h3>Medical Website</h3>
            <span>June 2025 – July 2025</span>
            <p>This medical website is designed to provide patients with easy access to healthcare services, information, and appointment scheduling. It offers features such as online doctor consultation, appointment booking, health articles, and patient record management. Built with a user-friendly interface, the site ensures a smooth experience for both patients and healthcare providers. The website aims to bridge the gap between doctors and patients through digital solutions that promote better healthcare accessibility and efficiency.</p>
        </div>
    </section>
    <!-- Certifications -->
    <section class="certifications" id="certifications">
        <h2>Certifications</h2>
        <ul>
            <li>Python: Numpy, Pandas, Matplotlib by Great Learning (Aug 2024)</li>
            <li>Web Development: Bootstrap, Tailwind CSS by Byteminders (Nov 2025)</li>
            <li>Website Design and Development by Byteminders (Dec 2025)</li>
        </ul>
    </section>
    <!-- Education -->
    <section class="education" id="education">
        <h2>Education</h2>
        <div class="card">
            <h3>Guru Nanak Dev University</h3>
            <span>Punjab, India | Bachelor in Computer Application; Percentage: 67% | Oct 2022 - June 2025</span>
            <p>Favorite Courses: Natural Language Programming</p>
        </div>
        <div class="card">
            <h3>Singhiya High School</h3>
            <span>Munger, Bihar | Intermediate; Percentage: 75% | April 2020 - March 2022</span>
            <p>Favorite Courses: History, Geography, Economics</p>
        </div>
        <div class="card">
            <h3>Saraswati Vidya Mandir</h3>
            <span>Munger, Bihar | Matriculation; Percentage: 67% | April 2019 - March 2020</span>
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
// 3D Rotating Cube in Hero Section
window.addEventListener('DOMContentLoaded', () => {
    // Three.js Cube
    const container = document.getElementById('threejs-canvas');
    if (container && window.THREE) {
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, 1, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(200, 200);
        container.appendChild(renderer.domElement);

        const geometry = new THREE.BoxGeometry();
        const material = new THREE.MeshStandardMaterial({ color: 0x6366f1 });
        const cube = new THREE.Mesh(geometry, material);
        scene.add(cube);

        const light = new THREE.PointLight(0xffffff, 1, 100);
        light.position.set(5, 5, 5);
        scene.add(light);

        camera.position.z = 3;

        function animate() {
            requestAnimationFrame(animate);
            cube.rotation.x += 0.01;
            cube.rotation.y += 0.01;
            renderer.render(scene, camera);
        }
        animate();
    }

    // Floating Bubbles Animation
    const extraAnim = document.getElementById('extra-animation');
    if (extraAnim) {
        function createBubble() {
            const bubble = document.createElement('div');
            bubble.className = 'bubble';
            const size = Math.random() * 30 + 20;
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;
            bubble.style.left = `${Math.random() * 80}%`;
            bubble.style.background = `radial-gradient(circle at 30% 30%, #6366f1, #fbbf24 80%)`;
            bubble.style.animationDuration = `${6 + Math.random() * 4}s`;
            extraAnim.appendChild(bubble);
            setTimeout(() => bubble.remove(), 8000);
        }
        setInterval(createBubble, 800);
        for (let i = 0; i < 5; i++) createBubble();
    }

    // Smooth scroll for nav links
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Hamburger menu for mobile
    const navLinks = document.querySelector('.nav-links');
    const navbar = document.querySelector('.navbar');
    if (window.innerWidth <= 700 && navLinks) {
        // Add hamburger if not present
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

    // Scroll-based fade-in animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('section').forEach(section => {
        section.classList.add('fade-init');
        observer.observe(section);
    });
}); 
    </script>
</body>
</html>
