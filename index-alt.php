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
    <title>Creative Portfolio - Unique Design</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #0a0a0a;
            color: #00ff00;
            overflow-x: hidden;
        }

        /* Terminal-style header */
        .terminal-header {
            background: #1a1a1a;
            border-bottom: 2px solid #00ff00;
            padding: 0.5rem 2rem;
            font-family: 'Courier New', monospace;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .terminal-prompt {
            color: #00ff00;
        }

        .terminal-prompt::before {
            content: '> ';
            color: #ff0000;
        }

        .cursor {
            display: inline-block;
            width: 8px;
            height: 16px;
            background: #00ff00;
            animation: blink 1s infinite;
            margin-left: 5px;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-menu a {
            color: #00ff00;
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-menu a:hover {
            color: #00ffff;
            text-shadow: 0 0 10px #00ffff;
        }

        /* Split screen hero */
        .split-hero {
            margin-top: 50px;
            height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .hero-left {
            background: linear-gradient(135deg, #1a1a1a 0%, #0a0a0a 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
            overflow: hidden;
        }

        .hero-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                repeating-linear-gradient(
                    0deg,
                    transparent,
                    transparent 2px,
                    rgba(0, 255, 0, 0.03) 2px,
                    rgba(0, 255, 0, 0.03) 4px
                );
            pointer-events: none;
        }

        .glitch-text {
            font-size: 4rem;
            font-weight: bold;
            position: relative;
            color: #fff;
            letter-spacing: 0.5rem;
            animation: glitch 3s infinite;
        }

        @keyframes glitch {
            0% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
            100% { transform: translate(0); }
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: #00ff00;
            margin: 2rem 0;
            font-family: 'Courier New', monospace;
        }

        .hero-description {
            color: #888;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .hero-right {
            background: #000;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .code-animation {
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: #00ff00;
            line-height: 1.6;
            opacity: 0.6;
            white-space: pre;
            overflow: hidden;
        }

        /* Masonry grid for projects */
        .projects-wrapper {
            padding: 4rem 2rem;
            background: #0a0a0a;
        }

        .section-title-alt {
            text-align: center;
            font-size: 3rem;
            color: #fff;
            margin-bottom: 3rem;
            text-transform: uppercase;
            letter-spacing: 1rem;
            position: relative;
        }

        .section-title-alt::after {
            content: '';
            display: block;
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            margin: 1rem auto;
        }

        .masonry-grid {
            column-count: 3;
            column-gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .masonry-item {
            break-inside: avoid;
            margin-bottom: 2rem;
            background: #1a1a1a;
            border: 1px solid #333;
            padding: 0;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .masonry-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff00, transparent);
            transition: left 0.5s;
        }

        .masonry-item:hover {
            border-color: #00ff00;
            box-shadow: 0 0 30px rgba(0, 255, 0, 0.3);
            transform: scale(1.02);
        }

        .masonry-item:hover::before {
            left: 100%;
        }

        .project-header-alt {
            background: #000;
            padding: 1.5rem;
            border-bottom: 1px solid #00ff00;
        }

        .project-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .project-number-alt {
            color: #ff0000;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .project-category-alt {
            color: #00ffff;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .project-title-alt {
            color: #fff;
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .project-body-alt {
            padding: 1.5rem;
        }

        .project-description-alt {
            color: #aaa;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .project-link-alt {
            display: inline-block;
            color: #00ff00;
            text-decoration: none;
            border: 1px solid #00ff00;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .project-link-alt:hover {
            background: #00ff00;
            color: #000;
        }

        /* Sidebar info panel */
        .info-sidebar {
            position: fixed;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid #00ff00;
            padding: 2rem;
            z-index: 100;
            display: none;
        }

        .info-sidebar.active {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                right: -300px;
                opacity: 0;
            }
            to {
                right: 0;
                opacity: 1;
            }
        }

        .info-toggle {
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            background: #00ff00;
            color: #000;
            border: none;
            padding: 1rem;
            cursor: pointer;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            z-index: 101;
            transition: all 0.3s;
        }

        .info-toggle:hover {
            background: #00ffff;
            box-shadow: 0 0 20px #00ffff;
        }

        /* Stats counter */
        .stats-bar {
            background: #1a1a1a;
            border-top: 1px solid #00ff00;
            border-bottom: 1px solid #00ff00;
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            border-right: 1px solid #333;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-size: 3rem;
            color: #00ff00;
            font-weight: bold;
            display: block;
        }

        .stat-label {
            color: #888;
            text-transform: uppercase;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .split-hero {
                grid-template-columns: 1fr;
            }

            .hero-right {
                display: none;
            }

            .masonry-grid {
                column-count: 1;
            }

            .stats-bar {
                grid-template-columns: 1fr;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid #333;
                padding-bottom: 1rem;
            }

            .glitch-text {
                font-size: 2rem;
            }
        }

        @media (max-width: 1024px) and (min-width: 769px) {
            .masonry-grid {
                column-count: 2;
            }
        }

        /* Footer */
        .terminal-footer {
            background: #1a1a1a;
            border-top: 2px solid #00ff00;
            padding: 2rem;
            text-align: center;
        }

        .terminal-footer p {
            color: #888;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 1rem;
        }

        .footer-links a {
            color: #00ff00;
            text-decoration: none;
        }

        .footer-links a:hover {
            color: #00ffff;
        }
    </style>
</head>
<body>
    <header class="terminal-header">
        <div class="terminal-prompt">portfolio.exe<span class="cursor"></span></div>
        <ul class="nav-menu">
            <li><a href="#home">[HOME]</a></li>
            <li><a href="#projects">[PROJECTS]</a></li>
            <li><a href="index.php">[CLASSIC]</a></li>
            <li><a href="login.php">[ADMIN]</a></li>
        </ul>
    </header>

    <section id="home" class="split-hero">
        <div class="hero-left">
            <h1 class="glitch-text">PORTFOLIO</h1>
            <p class="hero-subtitle">// WordPress | SaaS | Analytics //</p>
            <p class="hero-description">
                Building digital experiences through code, creativity, and innovation. 
                Specializing in WordPress ecosystems, scalable SaaS platforms, and 
                sophisticated tag management solutions. Every project is a new challenge, 
                every solution is crafted with precision.
            </p>
        </div>
        <div class="hero-right">
            <div class="code-animation" id="codeDisplay"></div>
        </div>
    </section>

    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number"><?php echo count($projects); ?></span>
            <span class="stat-label">Projects Delivered</span>
        </div>
        <div class="stat-item">
            <span class="stat-number"><?php echo count(array_unique(array_column($projects, 'category'))); ?></span>
            <span class="stat-label">Expertise Areas</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">100%</span>
            <span class="stat-label">Client Satisfaction</span>
        </div>
        <div class="stat-item">
            <span class="stat-number">∞</span>
            <span class="stat-label">Innovation</span>
        </div>
    </div>

    <section id="projects" class="projects-wrapper">
        <h2 class="section-title-alt">Projects</h2>
        
        <div class="masonry-grid">
            <?php $index = 1; foreach ($projects as $project): ?>
                <div class="masonry-item">
                    <div class="project-header-alt">
                        <div class="project-meta">
                            <span class="project-number-alt">[<?php echo str_pad($index++, 2, '0', STR_PAD_LEFT); ?>]</span>
                            <span class="project-category-alt">{<?php echo htmlspecialchars($project['category']); ?>}</span>
                        </div>
                        <h3 class="project-title-alt"><?php echo htmlspecialchars($project['title']); ?></h3>
                    </div>
                    <div class="project-body-alt">
                        <p class="project-description-alt"><?php echo htmlspecialchars($project['description']); ?></p>
                        <?php if ($project['url']): ?>
                            <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" class="project-link-alt">
                                VIEW PROJECT →
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="terminal-footer">
        <div class="footer-links">
            <a href="mailto:contact@example.com">[EMAIL]</a>
            <a href="#">[LINKEDIN]</a>
            <a href="#">[GITHUB]</a>
            <a href="index.php">[CLASSIC VIEW]</a>
        </div>
        <p>&copy; <?php echo date('Y'); ?> - All Rights Reserved - System Online</p>
    </footer>

    <button class="info-toggle" onclick="toggleInfo()">INFO</button>
    <div class="info-sidebar" id="infoSidebar">
        <h3 style="color: #00ff00; margin-bottom: 1rem;">SYSTEM INFO</h3>
        <p style="color: #888; line-height: 1.8;">
            <strong style="color: #00ff00;">STATUS:</strong> Online<br>
            <strong style="color: #00ff00;">PROJECTS:</strong> <?php echo count($projects); ?><br>
            <strong style="color: #00ff00;">VERSION:</strong> 2.0<br>
            <strong style="color: #00ff00;">UPTIME:</strong> 100%
        </p>
    </div>

    <script>
        // Animated code display
        const codeLines = [
            'function createAwesome() {',
            '  const ideas = [];',
            '  while(true) {',
            '    ideas.push(innovate());',
            '    if(ideas.isBreakthrough()) {',
            '      return ideas.build();',
            '    }',
            '  }',
            '}',
            '',
            'const portfolio = {',
            '  wordpress: true,',
            '  saas: true,',
            '  analytics: true,',
            '  creativity: Infinity',
            '};',
            '',
            'console.log("Building the future...");',
        ];

        let currentLine = 0;
        let currentChar = 0;
        const codeDisplay = document.getElementById('codeDisplay');

        function typeCode() {
            if (currentLine < codeLines.length) {
                if (currentChar < codeLines[currentLine].length) {
                    codeDisplay.textContent += codeLines[currentLine][currentChar];
                    currentChar++;
                    setTimeout(typeCode, 50);
                } else {
                    codeDisplay.textContent += '\n';
                    currentLine++;
                    currentChar = 0;
                    setTimeout(typeCode, 200);
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

        // Info sidebar toggle
        function toggleInfo() {
            const sidebar = document.getElementById('infoSidebar');
            sidebar.classList.toggle('active');
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
