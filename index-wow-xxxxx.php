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

        .capability-showcase {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 30px 80px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            min-height: 400px;
            display: flex;
            flex-direction: column;
        }

        .showcase-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .capability-label {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .showcase-visual {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background: #f8fafc;
            border-radius: 16px;
            margin-bottom: 2rem;
            min-height: 250px;
            transition: all 0.5s ease;
        }

        .showcase-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
            color: var(--primary);
            animation: fadeInScale 0.5s ease;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .showcase-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            width: 100%;
            margin-top: 1.5rem;
        }

        .stat-box {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-box-number {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-box-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 600;
        }

        .showcase-description {
            text-align: center;
            color: #64748b;
            line-height: 1.8;
            font-size: 1rem;
            margin-top: 1rem;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .showcase-tabs {
            display: flex;
            gap: 0.5rem;
            background: #e2e8f0;
            padding: 0.5rem;
            border-radius: 50px;
        }

        .tab-btn {
            flex: 1;
            padding: 0.75rem 1.5rem;
            background: transparent;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .tab-btn:hover {
            color: var(--dark);
        }

        .tab-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            width: 100%;
            animation: fadeInUp 0.5s ease;
        }

        .skill-tag {
            background: white;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--dark);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
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

        /* Three Pillars Section */
        .three-pillars {
            background: white;
            padding: 6rem 3rem;
            position: relative;
            overflow: hidden;
        }

        .three-pillars::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), var(--secondary), transparent);
        }

        .pillars-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .pillars-header {
            text-align: center;
            margin-bottom: 5rem;
        }

        .pillars-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .pillars-subtitle {
            font-size: 1.2rem;
            color: #64748b;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .pillars-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            margin-bottom: 4rem;
            position: relative;
        }

        .pillars-grid::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 33.33%;
            right: 33.33%;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: translateY(-50%);
            z-index: 0;
        }

        .pillar {
            background: #f8fafc;
            padding: 3rem 2rem;
            border-radius: 24px;
            border: 2px solid #e2e8f0;
            transition: all 0.4s;
            position: relative;
            z-index: 1;
        }

        .pillar:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            box-shadow: 0 20px 60px rgba(99, 102, 241, 0.15);
        }

        .pillar-center {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(236, 72, 153, 0.05));
            border: 2px solid var(--primary);
            position: relative;
        }

        .intersection-badge {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
            white-space: nowrap;
        }

        .intersection-icon {
            font-size: 1.2rem;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.2) rotate(180deg); }
        }

        .pillar-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            color: var(--primary);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .pillar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .pillar-description {
            color: #64748b;
            line-height: 1.8;
            margin-bottom: 2rem;
            font-size: 1.05rem;
        }

        .pillar-skills {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .pillar-skills li {
            color: var(--primary);
            font-weight: 500;
            padding-left: 1.5rem;
            position: relative;
        }

        .pillar-skills li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--secondary);
            font-weight: bold;
        }

        .unique-value {
            display: flex;
            justify-content: center;
        }

        .value-card {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            color: white;
            padding: 3rem 4rem;
            border-radius: 24px;
            max-width: 900px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .value-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .value-card h4 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .value-card p {
            line-height: 1.9;
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
        }

        /* Responsive for pillars */
        @media (max-width: 1024px) {
            .hero-content-magazine {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .capability-showcase {
                padding: 1.5rem;
            }

            .showcase-stats {
                grid-template-columns: 1fr;
            }

            .pillars-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .pillars-grid::before {
                display: none;
            }

            .intersection-badge {
                position: static;
                transform: none;
                margin: 0 auto 1rem;
                width: fit-content;
            }

            .value-card {
                padding: 2rem;
            }
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
                    UX designer meets developer meets marketing strategist. Three distinct perspectives 
                    converging to create digital experiences that are beautiful, functional, and drive measurable results.
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
                <div class="capability-showcase">
                    <div class="showcase-header">
                        <div class="capability-label" id="capabilityLabel">UX Design</div>
                    </div>
                    <div class="showcase-visual" id="showcaseVisual">
                        <!-- Visual content will be dynamically inserted -->
                    </div>
                    <div class="showcase-tabs">
                        <button class="tab-btn active" data-capability="ux">UX</button>
                        <button class="tab-btn" data-capability="code">Code</button>
                        <button class="tab-btn" data-capability="marketing">Marketing</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Three Pillars Section -->
    <section class="three-pillars">
        <div class="pillars-container">
            <div class="pillars-header">
                <h2 class="pillars-title">Three Minds. One Vision.</h2>
                <p class="pillars-subtitle">Where UX design, development expertise, and marketing strategy converge to create exceptional digital experiences</p>
            </div>

            <div class="pillars-grid">
                <div class="pillar">
                    <div class="pillar-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M9 3v18"/>
                        </svg>
                    </div>
                    <h3 class="pillar-title">UX Designer</h3>
                    <p class="pillar-description">Crafting intuitive interfaces that users love. Every pixel has purpose, every interaction tells a story.</p>
                    <ul class="pillar-skills">
                        <li>User Research</li>
                        <li>Interface Design</li>
                        <li>Prototyping</li>
                        <li>User Testing</li>
                    </ul>
                </div>

                <div class="pillar pillar-center">
                    <div class="intersection-badge">
                        <span class="intersection-text">The Magic Happens Here</span>
                        <div class="intersection-icon">✨</div>
                    </div>
                    <div class="pillar-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"/>
                            <polyline points="8 6 2 12 8 18"/>
                        </svg>
                    </div>
                    <h3 class="pillar-title">Developer</h3>
                    <p class="pillar-description">Building robust, scalable solutions. Clean code meets powerful functionality in every project.</p>
                    <ul class="pillar-skills">
                        <li>WordPress Expert</li>
                        <li>Full-Stack Dev</li>
                        <li>SaaS Architecture</li>
                        <li>Plugin Development</li>
                    </ul>
                </div>

                <div class="pillar">
                    <div class="pillar-icon">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <h3 class="pillar-title">Marketing Strategist</h3>
                    <p class="pillar-description">Data-driven campaigns that convert. Analytics and creativity working in perfect harmony.</p>
                    <ul class="pillar-skills">
                        <li>Tag Management</li>
                        <li>Analytics Setup</li>
                        <li>Conversion Optimization</li>
                        <li>Digital Strategy</li>
                    </ul>
                </div>
            </div>

            <div class="unique-value">
                <div class="value-card">
                    <h4>The Competitive Edge</h4>
                    <p>Most specialists operate in silos. I bridge all three domains - designing beautiful experiences, building them flawlessly, and ensuring they drive measurable results. This rare combination means projects that are not just functional or beautiful, but strategically optimized for success.</p>
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
        // Interactive Capability Showcase
        const capabilities = {
            ux: {
                label: 'UX Design',
                icon: `<svg class="showcase-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"/>
                    <rect x="14" y="3" width="7" height="7"/>
                    <rect x="14" y="14" width="7" height="7"/>
                    <rect x="3" y="14" width="7" height="7"/>
                </svg>`,
                description: 'Designing intuitive interfaces that users love. Every interaction is crafted for maximum impact.',
                stats: [
                    { number: '100+', label: 'Interfaces Designed' },
                    { number: '50K+', label: 'Users Reached' }
                ]
            },
            code: {
                label: 'Development',
                icon: `<svg class="showcase-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="16 18 22 12 16 6"/>
                    <polyline points="8 6 2 12 8 18"/>
                </svg>`,
                description: 'Building robust, scalable solutions with WordPress, SaaS architecture, and full-stack expertise.',
                stats: [
                    { number: '<?php echo count($projects); ?>+', label: 'Projects Delivered' },
                    { number: '10+', label: 'Plugins Created' }
                ]
            },
            marketing: {
                label: 'Digital Marketing',
                icon: `<svg class="showcase-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="20" x2="12" y2="10"/>
                    <line x1="18" y1="20" x2="18" y2="4"/>
                    <line x1="6" y1="20" x2="6" y2="16"/>
                </svg>`,
                description: 'Data-driven strategies powered by analytics expertise. Tag management and conversion optimization at scale.',
                stats: [
                    { number: '500%', label: 'Avg ROI Increase' },
                    { number: '1M+', label: 'Events Tracked' }
                ]
            }
        };

        let currentCapability = 'ux';
        let autoRotate = true;
        let rotateInterval;

        function updateShowcase(capability) {
            currentCapability = capability;
            const data = capabilities[capability];
            
            // Update label
            document.getElementById('capabilityLabel').textContent = data.label;
            
            // Update visual content
            const visual = document.getElementById('showcaseVisual');
            visual.innerHTML = `
                ${data.icon}
                <div class="showcase-stats">
                    ${data.stats.map(stat => `
                        <div class="stat-box">
                            <span class="stat-box-number">${stat.number}</span>
                            <span class="stat-box-label">${stat.label}</span>
                        </div>
                    `).join('')}
                </div>
                <p class="showcase-description">${data.description}</p>
            `;
            
            // Update active tab
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.capability === capability) {
                    btn.classList.add('active');
                }
            });
        }

        function startAutoRotate() {
            rotateInterval = setInterval(() => {
                if (autoRotate) {
                    const capabilities = ['ux', 'code', 'marketing'];
                    const currentIndex = capabilities.indexOf(currentCapability);
                    const nextIndex = (currentIndex + 1) % capabilities.length;
                    updateShowcase(capabilities[nextIndex]);
                }
            }, 4000);
        }

        // Initialize
        updateShowcase('ux');
        startAutoRotate();

        // Tab click handlers
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                autoRotate = false;
                clearInterval(rotateInterval);
                updateShowcase(btn.dataset.capability);
                
                // Resume auto-rotate after 10 seconds of inactivity
                setTimeout(() => {
                    autoRotate = true;
                    startAutoRotate();
                }, 10000);
            });
        });

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
