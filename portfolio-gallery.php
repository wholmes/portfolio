<?php
require_once 'config.php';

// Check access
if (!isset($_SESSION['portfolio_access'])) {
    header('Location: portfolio-access.php');
    exit;
}

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
    <title>Portfolio Gallery</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0a0a;
            color: white;
            line-height: 1.6;
        }

        .header {
            background: rgba(15, 15, 15, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logout-btn {
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .hero-section {
            padding: 6rem 3rem 4rem;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff, rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
        }

        .gallery-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 3rem 6rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2.5rem;
        }

        .gallery-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s;
            cursor: pointer;
            text-decoration: none;
            color: white;
            display: block;
        }

        .gallery-card:hover {
            transform: translateY(-10px);
            border-color: #6366f1;
            box-shadow: 0 30px 60px rgba(99, 102, 241, 0.3);
        }

        .card-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .card-image::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
            animation: float 10s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(50px, 50px); }
        }

        .card-number {
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-content {
            padding: 2rem;
        }

        .card-category {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6366f1;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .card-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.7;
            margin-bottom: 1.5rem;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .view-case-study {
            color: #6366f1;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .arrow-icon {
            transition: transform 0.3s;
        }

        .gallery-card:hover .arrow-icon {
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .header-content {
                padding: 0 1.5rem;
            }

            .hero-section, .gallery-container {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">Portfolio Showcase</div>
            <a href="portfolio-logout.php" class="logout-btn">Logout</a>
        </div>
    </header>

    <section class="hero-section">
        <h1 class="hero-title">Project Gallery</h1>
        <p class="hero-subtitle">Detailed case studies showcasing the full scope of work, technical challenges, and creative solutions</p>
    </section>

    <div class="gallery-container">
        <div class="gallery-grid">
            <?php $index = 1; foreach ($projects as $project): ?>
                <a href="portfolio-project.php?id=<?php echo $project['id']; ?>" class="gallery-card">
                    <div class="card-image">
                        <div class="card-number"><?php echo str_pad($index++, 2, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    <div class="card-content">
                        <div class="card-category"><?php echo htmlspecialchars($project['category']); ?></div>
                        <h3 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p class="card-description"><?php echo htmlspecialchars($project['description']); ?></p>
                        <div class="card-footer">
                            <span class="view-case-study">
                                View Full Case Study
                                <span class="arrow-icon">→</span>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
