<?php
require_once 'config.php';

// Check access
if (!isset($_SESSION['portfolio_access'])) {
    header('Location: portfolio-access.php');
    exit;
}

$project_id = $_GET['id'] ?? 0;

// Fetch project
$conn = getDBConnection();
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$project_id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$project) {
    header('Location: portfolio-gallery.php');
    exit;
}

// Sample detailed content and images (in production, this would come from database)
$projectDetails = [
    'challenge' => 'The primary challenge was creating an intuitive solution that balances technical complexity with user experience, while maintaining scalability and performance.',
    'solution' => 'Developed a comprehensive system leveraging modern technologies and best practices, with a focus on clean architecture, responsive design, and seamless user interactions.',
    'results' => [
        'Increased user engagement by 250%',
        'Reduced load times by 60%',
        'Successfully deployed to 50K+ users',
        'Achieved 98% satisfaction rating'
    ],
    'tech_stack' => ['PHP', 'JavaScript', 'WordPress', 'React', 'MySQL', 'CSS3'],
    'role' => 'Lead Developer & UX Designer',
    'duration' => '3 months',
    'year' => '2024'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?> - Portfolio</title>
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
            line-height: 1.8;
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

        .back-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: white;
        }

        .hero-project {
            max-width: 1400px;
            margin: 0 auto;
            padding: 5rem 3rem;
        }

        .project-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }

        .meta-value {
            font-weight: 600;
            color: #6366f1;
        }

        .project-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 6vw, 5rem);
            font-weight: 900;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .project-category {
            font-size: 1rem;
            color: #ec4899;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 2rem;
        }

        .project-description {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 900px;
            margin-bottom: 3rem;
            line-height: 1.8;
        }

        .tech-stack-hero {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .tech-badge-hero {
            padding: 0.5rem 1.25rem;
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 8px;
            color: #6366f1;
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .image-gallery {
            max-width: 1400px;
            margin: 4rem auto;
            padding: 0 3rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .gallery-item {
            aspect-ratio: 16/10;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .gallery-item.large {
            grid-column: span 2;
        }

        .gallery-placeholder {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .content-section {
            max-width: 1000px;
            margin: 6rem auto;
            padding: 0 3rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #fff, rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-content {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            line-height: 1.9;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        .result-card {
            background: rgba(99, 102, 241, 0.05);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s;
        }

        .result-card:hover {
            border-color: #6366f1;
            transform: translateY(-5px);
        }

        .result-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .result-text {
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            margin: 6rem 0;
        }

        .next-project {
            max-width: 1400px;
            margin: 6rem auto;
            padding: 0 3rem 6rem;
            text-align: center;
        }

        .next-project-btn {
            display: inline-block;
            padding: 1.25rem 2.5rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .next-project-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.3);
        }

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-item.large {
                grid-column: span 1;
            }

            .results-grid {
                grid-template-columns: 1fr;
            }

            .hero-project, .image-gallery, .content-section, .next-project {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <a href="portfolio-gallery.php" class="back-link">
                <span>←</span>
                <span>Back to Gallery</span>
            </a>
        </div>
    </header>

    <section class="hero-project">
        <div class="project-meta">
            <div class="meta-item">
                <span class="meta-label">Role</span>
                <span class="meta-value"><?php echo htmlspecialchars($projectDetails['role']); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Duration</span>
                <span class="meta-value"><?php echo htmlspecialchars($projectDetails['duration']); ?></span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Year</span>
                <span class="meta-value"><?php echo htmlspecialchars($projectDetails['year']); ?></span>
            </div>
        </div>

        <div class="project-category"><?php echo htmlspecialchars($project['category']); ?></div>
        <h1 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h1>
        <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>

        <div class="tech-stack-hero">
            <?php foreach ($projectDetails['tech_stack'] as $tech): ?>
                <span class="tech-badge-hero"><?php echo htmlspecialchars($tech); ?></span>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="image-gallery">
        <div class="gallery-grid">
            <div class="gallery-item large">
                <div class="gallery-placeholder">Featured Image</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">01</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">02</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">03</div>
            </div>
            <div class="gallery-item">
                <div class="gallery-placeholder">04</div>
            </div>
        </div>
    </section>

    <div class="content-section">
        <h2 class="section-title">The Challenge</h2>
        <div class="section-content">
            <p><?php echo htmlspecialchars($projectDetails['challenge']); ?></p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="content-section">
        <h2 class="section-title">The Solution</h2>
        <div class="section-content">
            <p><?php echo htmlspecialchars($projectDetails['solution']); ?></p>
        </div>
    </div>

    <div class="divider"></div>

    <div class="content-section">
        <h2 class="section-title">Results & Impact</h2>
        <div class="results-grid">
            <?php foreach ($projectDetails['results'] as $result): ?>
                <div class="result-card">
                    <div class="result-icon">✓</div>
                    <div class="result-text"><?php echo htmlspecialchars($result); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="next-project">
        <a href="portfolio-gallery.php" class="next-project-btn">View More Projects</a>
    </div>
</body>
</html>
