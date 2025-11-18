<?php
require_once 'config.php';

// Fetch all projects ordered by display_order
$conn = getDBConnection();
$stmt = $conn->query("SELECT * FROM projects ORDER BY display_order ASC, id ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group projects by category
$projectsByCategory = [];
foreach ($projects as $project) {
    $projectsByCategory[$project['category']][] = $project;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Portfolio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <nav class="main-nav">
                <div class="logo">
                    <h1>My Portfolio</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="#projects">Projects</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php" class="btn-login">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h2 class="hero-title">Building Digital Solutions</h2>
                <p class="hero-subtitle">WordPress Expert • SaaS Developer • Tag Management Consultant</p>
                <p class="hero-description">Specializing in WordPress plugins, themes, and full-stack web development with expertise in analytics and tag management solutions.</p>
                <a href="#projects" class="btn btn-primary btn-large">View My Work</a>
            </div>
        </div>
    </section>

    <section id="projects" class="projects-section">
        <div class="container">
            <h2 class="section-title">Featured Projects</h2>
            <p class="section-subtitle">A showcase of my work across WordPress, SaaS, and web development</p>
            
            <div class="projects-grid">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <div class="project-card-header">
                            <span class="project-category"><?php echo htmlspecialchars($project['category']); ?></span>
                        </div>
                        <div class="project-card-body">
                            <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                            <p class="project-description"><?php echo htmlspecialchars($project['description']); ?></p>
                        </div>
                        <?php if ($project['url']): ?>
                            <div class="project-card-footer">
                                <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" class="btn btn-secondary btn-small">View Project →</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <div class="about-content">
                <p>I'm a full-stack developer with deep expertise in WordPress development, SaaS applications, and tag management solutions. My work spans across creating innovative WordPress plugins and themes, building scalable SaaS platforms, and providing expert consulting services.</p>
                
                <div class="expertise-grid">
                    <div class="expertise-item">
                        <h3>WordPress Development</h3>
                        <p>Custom plugins, Gutenberg blocks, and themes</p>
                    </div>
                    <div class="expertise-item">
                        <h3>SaaS Applications</h3>
                        <p>Full-stack development and deployment</p>
                    </div>
                    <div class="expertise-item">
                        <h3>Tag Management</h3>
                        <p>Analytics implementation and consulting</p>
                    </div>
                    <div class="expertise-item">
                        <h3>Web Development</h3>
                        <p>Modern, responsive, and performant sites</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container">
            <h2 class="section-title">Let's Work Together</h2>
            <p class="section-subtitle">Interested in collaborating? Get in touch!</p>
            <div class="contact-cta">
                <a href="mailto:contact@example.com" class="btn btn-primary btn-large">Send Me an Email</a>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Professional Portfolio. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
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
