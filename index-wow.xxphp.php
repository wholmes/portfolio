<?php
require_once 'config.php';

// Fetch all projects
$conn = getDBConnection();
$stmt = $conn->query("SELECT * FROM projects ORDER BY display_order ASC, id ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Visual Excellence</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #6366f1;
            --secondary: #ec4899;
            --dark: #0f172a;
            --light: #f8fafc;
            --accent: #8b5cf6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Elegant Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cursor {
            display: inline-block;
            width: 3px;
            height: 20px;
            background: var(--primary);
            animation: blink 1s infinite;
            border-radius: 2px;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        .nav-links {
            display: flex;
            gap: 3rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section - Magazine Style */
        .hero-magazine {
            margin-top: 80px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-magazine::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: pulse 10s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; }
            50% { opacity: 1; }
        }

        .hero-content-magazine {
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 3rem;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            color: white;
        }

        .hero-eyebrow {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .hero-title-magazine {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 2rem;
            letter-spacing: -0.03em;
        }

        .hero-title-magazine span {
            display: block;
            background: linear-gradient(90deg, #fff 30%, rgba(255,255,255,0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-description-magazine {
            font-size: 1.25rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            font-weight: 300;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary);
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }

        .btn-primary-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
        }

        .btn-secondary-hero {
            background: transparent;
            color: white;
            border: 2px solid rgba(255,255,255,0.3);
        }

        .btn-secondary-hero:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.6);
        }

        .hero-image-container {
            position: relative;
        }

        .code-window {
            background: #1a1a1a;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .code-window-header {
            background: #2d2d2d;
            padding: 0.75rem 1rem;
            display: flex;
            gap: 0.5rem;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .window-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }

        .code-animation {
            font-family: 'Courier New', monospace;
            font-size: 0.85rem;
            color: #00ff00;
            line-height: 1.8;
            padding: 1.5rem;
            min-height: 300px;
            white-space: pre;
            overflow: hidden;
        }

        .code-animation .keyword {
            color: #c678dd;
        }

        .code-animation .function {
            color: #61afef;
        }

        .code-animation .string {
            color: #98c379;
        }

        .code-animation .comment {
            color: #5c6370;
            font-style: italic;
        }

        .arrow {
            transition: transform 0.3s;
        }

        /* Bento Grid for Projects */
        .projects-bento {
            max-width: 1400px;
            margin: 6rem auto;
            padding: 0 3rem;
        }

        .section-header-bento {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title-bento {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 900;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle-bento {
            font-size: 1.2rem;
            color: #64748b;
            font-weight: 300;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            grid-auto-rows: 200px;
        }

        .bento-item {
            border-radius: 24px;
            padding: 2.5rem;
            background: white;
            border: 1px solid #e2e8f0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .bento-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 0;
        }

        .bento-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            border-color: transparent;
        }

        .bento-item:hover::before {
            opacity: 0.05;
        }

        .bento-item:nth-child(1) { grid-column: span 6; grid-row: span 2; }
        .bento-item:nth-child(2) { grid-column: span 6; grid-row: span 2; }
        .bento-item:nth-child(3) { grid-column: span 4; grid-row: span 2; }
        .bento-item:nth-child(4) { grid-column: span 4; grid-row: span 2; }
        .bento-item:nth-child(5) { grid-column: span 4; grid-row: span 2; }
        .bento-item:nth-child(6) { grid-column: span 8; grid-row: span 2; }
        .bento-item:nth-child(7) { grid-column: span 4; grid-row: span 2; }
        .bento-item:nth-child(8) { grid-column: span 6; grid-row: span 2; }
        .bento-item:nth-child(9) { grid-column: span 6; grid-row: span 2; }
        .bento-item:nth-child(10) { grid-column: span 12; grid-row: span 1; }

        .bento-content {
            position: relative;
            z-index: 1;
        }

        .project-category-bento {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            background: rgba(99, 102, 241, 0.1);
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            margin-bottom: 1rem;
        }

        .project-title-bento {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .project-description-bento {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .project-link-bento {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: gap 0.3s;
        }

        .project-link-bento:hover {
            gap: 1rem;
        }

        .project-link-bento:hover .arrow {
            transform: translateX(5px);
        }

        /* Footer */
        .footer-elegant {
            background: var(--dark);
            color: white;
            padding: 4rem 3rem;
            margin-top: 6rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 4rem;
        }

        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .footer-description {
            color: #94a3b8;
            line-height: 1.8;
        }

        .footer-section h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 3rem auto 0;
            padding-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            text-align: center;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content-magazine {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .bento-grid {
                grid-template-columns: 1fr;
                grid-auto-rows: auto;
            }

            .bento-item {
                grid-column: span 1 !important;
                grid-row: span 1 !important;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                gap: 1.5rem;
            }

            .hero-cta {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <div class="nav-container">
            <div class="logo">Portfolio<span class="cursor"></span></div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#projects">Work</a></li>
                <li><a href="index.php">Classic</a></li>
                <li><a href="login.php">Admin</a></li>
            </ul>
        </div>
    </header>

    <section id="home" class="hero-magazine">
        <div class="hero-content-magazine">
            <div class="hero-text">
                <span class="hero-eyebrow">Digital Craftsman</span>
                <h1 class="hero-title-magazine">
                    <span>Building</span>
                    <span>Tomorrow's</span>
                    <span>Solutions</span>
                </h1>
                <p class="hero-description-magazine">
                    WordPress specialist, SaaS architect, and analytics expert crafting 
                    exceptional digital experiences that drive results and inspire innovation.
                </p>
                <div class="hero-cta">
                    <a href="#projects" class="btn-hero btn-primary-hero">
                        Explore Work
                        <span>→</span>
                    </a>
                    <a href="#contact" class="btn-hero btn-secondary-hero">
                        Get in Touch
                    </a>
                </div>
            </div>
            <div class="hero-image-container">
                <div class="code-window">
                    <div class="code-window-header">
                        <div class="window-dot dot-red"></div>
                        <div class="window-dot dot-yellow"></div>
                        <div class="window-dot dot-green"></div>
                    </div>
                    <div class="code-animation" id="codeDisplay"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="projects-bento">
        <div class="section-header-bento">
            <h2 class="section-title-bento">Selected Work</h2>
            <p class="section-subtitle-bento">A curated collection of impactful projects</p>
        </div>

        <div class="bento-grid">
            <?php foreach ($projects as $project): ?>
                <div class="bento-item">
                    <div class="bento-content">
                        <div>
                            <span class="project-category-bento"><?php echo htmlspecialchars($project['category']); ?></span>
                            <h3 class="project-title-bento"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p class="project-description-bento"><?php echo htmlspecialchars($project['description']); ?></p>
                        </div>
                        <?php if ($project['url']): ?>
                            <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" class="project-link-bento">
                                View Project
                                <span class="arrow">→</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer id="contact" class="footer-elegant">
        <div class="footer-content">
            <div>
                <div class="footer-brand">Portfolio</div>
                <p class="footer-description">
                    Creating digital excellence through innovation, creativity, and technical expertise.
                    Let's build something amazing together.
                </p>
            </div>
            <div class="footer-section">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="index.php">Classic View</a></li>
                    <li><a href="login.php">Admin</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect</h4>
                <ul class="footer-links">
                    <li><a href="mailto:contact@example.com">Email</a></li>
                    <li><a href="#">LinkedIn</a></li>
                    <li><a href="#">GitHub</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> All rights reserved. Crafted with precision.</p>
        </div>
    </footer>

    <script>
        // Animated code display
        const codeLines = [
            'const portfolio = {',
            '  wordpress: "expert",',
            '  saas: "architect",',
            '  analytics: "specialist",',
            '  passion: Infinity',
            '};',
            '',
            'function buildAmazing() {',
            '  return portfolio',
            '    .innovate()',
            '    .create()',
            '    .deliver();',
            '}',
            '',
            'console.log("Ready to build");',
        ];

        let currentLine = 0;
        let currentChar = 0;
        const codeDisplay = document.getElementById('codeDisplay');

        function typeCode() {
            if (currentLine < codeLines.length) {
                if (currentChar < codeLines[currentLine].length) {
                    codeDisplay.textContent += codeLines[currentLine][currentChar];
                    currentChar++;
                    setTimeout(typeCode, 30);
                } else {
                    codeDisplay.textContent += '\n';
                    currentLine++;
                    currentChar = 0;
                    setTimeout(typeCode, 100);
                }
            } else {
                // Loop animation
                setTimeout(() => {
                    codeDisplay.textContent = '';
                    currentLine = 0;
                    currentChar = 0;
                    typeCode();
                }, 3000);
            }
        }

        typeCode();

        // Header scroll effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
