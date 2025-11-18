<?php
require_once 'config.php';

// Fetch all projects
$conn = getDBConnection();
$stmt = $conn->query("SELECT * FROM projects ORDER BY display_order ASC, id ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group by category
$categories = [];
foreach ($projects as $project) {
    $categories[$project['category']][] = $project;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Portfolio - Alternative Layout</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent: #ff6b6b;
            --accent-dark: #ee5a52;
            --dark: #1a1a2e;
            --darker: #16213e;
            --light: #eaeaea;
            --white: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--dark);
            color: var(--light);
            overflow-x: hidden;
        }

        /* Animated Background */
        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: linear-gradient(45deg, var(--dark) 0%, var(--darker) 100%);
        }

        .background-animation::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 107, 107, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 107, 107, 0.1) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(50px, 50px) rotate(180deg); }
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 0;
            background: rgba(26, 26, 46, 0.95);
            backdrop-filter: blur(10px);
            z-index: 100;
            border-bottom: 2px solid var(--accent);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--accent) 0%, #feca57 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            margin-top: 80px;
            min-height: 90vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .hero-content {
            max-width: 900px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 900;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--white) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            color: var(--light);
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .hero-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: rgba(234, 234, 234, 0.8);
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease 0.6s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            color: var(--white);
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--accent);
        }

        .btn-secondary:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        /* Projects Section */
        .projects-section {
            padding: 6rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--white) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: rgba(234, 234, 234, 0.7);
        }

        /* Category Tabs */
        .category-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .category-tab {
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid transparent;
            border-radius: 30px;
            color: var(--light);
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }

        .category-tab:hover,
        .category-tab.active {
            background: rgba(255, 107, 107, 0.1);
            border-color: var(--accent);
            color: var(--accent);
        }

        /* Projects Grid */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2.5rem;
            opacity: 1;
            transition: opacity 0.3s;
        }

        .projects-grid.filtering {
            opacity: 0.3;
        }

        .project-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .project-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent) 0%, #feca57 100%);
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .project-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent);
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.2);
        }

        .project-card:hover::before {
            transform: scaleX(1);
        }

        .project-number {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 3rem;
            font-weight: 900;
            color: rgba(255, 107, 107, 0.1);
        }

        .project-category {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(255, 107, 107, 0.2);
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .project-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1rem;
        }

        .project-description {
            color: rgba(234, 234, 234, 0.8);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .project-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: gap 0.3s;
        }

        .project-link:hover {
            gap: 1rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(0, 0, 0, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-link {
            color: var(--light);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: var(--accent);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-links {
                gap: 1rem;
                font-size: 0.9rem;
            }

            .hero {
                min-height: 70vh;
                margin-top: 60px;
            }

            .projects-grid {
                grid-template-columns: 1fr;
            }

            .cta-buttons {
                flex-direction: column;
            }

            .category-tabs {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 1rem;
            }
        }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
            40% { transform: translateX(-50%) translateY(-20px); }
            60% { transform: translateX(-50%) translateY(-10px); }
        }

        .scroll-indicator svg {
            width: 30px;
            height: 30px;
            fill: var(--accent);
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>

    <header class="header">
        <div class="nav-container">
            <div class="logo">PORTFOLIO</div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="index.php">Classic View</a></li>
                    <li><a href="login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Creative Developer</h1>
            <p class="hero-subtitle">WordPress Expert • SaaS Innovator • Tag Management Specialist</p>
            <p class="hero-description">
                Crafting innovative digital solutions with a focus on WordPress ecosystems, 
                scalable SaaS platforms, and advanced analytics implementations. Turning complex 
                technical challenges into elegant, user-friendly experiences.
            </p>
            <div class="cta-buttons">
                <a href="#projects" class="btn btn-primary">View My Work</a>
                <a href="#contact" class="btn btn-secondary">Get In Touch</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <svg viewBox="0 0 24 24">
                <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/>
            </svg>
        </div>
    </section>

    <section id="projects" class="projects-section">
        <div class="section-header">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">A showcase of innovation across multiple domains</p>
        </div>

        <div class="category-tabs">
            <button class="category-tab active" data-category="all">All Projects</button>
            <?php foreach (array_keys($categories) as $category): ?>
                <button class="category-tab" data-category="<?php echo htmlspecialchars($category); ?>">
                    <?php echo htmlspecialchars($category); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="projects-grid">
            <?php $index = 1; foreach ($projects as $project): ?>
                <div class="project-card" data-category="<?php echo htmlspecialchars($project['category']); ?>">
                    <span class="project-number"><?php echo str_pad($index++, 2, '0', STR_PAD_LEFT); ?></span>
                    <span class="project-category"><?php echo htmlspecialchars($project['category']); ?></span>
                    <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>
                    <?php if ($project['url']): ?>
                        <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" class="project-link">
                            Explore Project →
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer id="contact" class="footer">
        <div class="footer-links">
            <a href="mailto:contact@example.com" class="footer-link">Email</a>
            <a href="#" class="footer-link">LinkedIn</a>
            <a href="#" class="footer-link">GitHub</a>
            <a href="index.php" class="footer-link">Classic View</a>
        </div>
        <p>&copy; <?php echo date('Y'); ?> Professional Portfolio. All rights reserved.</p>
    </footer>

    <script>
        // Category filtering
        const tabs = document.querySelectorAll('.category-tab');
        const cards = document.querySelectorAll('.project-card');
        const grid = document.querySelector('.projects-grid');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const category = tab.dataset.category;
                
                // Update active tab
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                // Filter cards with animation
                grid.classList.add('filtering');
                
                setTimeout(() => {
                    cards.forEach(card => {
                        if (category === 'all' || card.dataset.category === category) {
                            card.style.display = 'block';
                            setTimeout(() => {
                                card.style.opacity = '1';
                                card.style.transform = 'translateY(0)';
                            }, 50);
                        } else {
                            card.style.opacity = '0';
                            card.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                card.style.display = 'none';
                            }, 300);
                        }
                    });
                    
                    setTimeout(() => {
                        grid.classList.remove('filtering');
                    }, 300);
                }, 100);
            });
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Parallax effect on scroll
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.background-animation::before');
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>
</body>
</html>
