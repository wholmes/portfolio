<?php
require_once 'config.php';

$error = '';

// Check if already logged in
if (isset($_SESSION['portfolio_access'])) {
    header('Location: portfolio-gallery.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $access_code = trim($_POST['access_code'] ?? '');
    
    // Simple access code system (you can change this code)
    $valid_codes = [
        'RECRUITER2025',
        'PORTFOLIO2025',
        'VIEWWORK'
    ];
    
    if (in_array($access_code, $valid_codes)) {
        $_SESSION['portfolio_access'] = true;
        $_SESSION['access_time'] = time();
        header('Location: portfolio-gallery.php');
        exit;
    } else {
        $error = 'Invalid access code';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Access</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 2rem;
        }

        .access-container {
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
        }

        .lock-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff, rgba(255, 255, 255, 0.7));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        input[type="text"] {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: 'Courier New', monospace;
            letter-spacing: 0.1em;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #6366f1;
            background: rgba(255, 255, 255, 0.15);
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #6366f1, #ec4899);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);
        }

        .error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .info-box {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }

        .back-link {
            text-align: center;
            margin-top: 2rem;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: white;
        }
    </style>
</head>
<body>
    <div class="access-container">
        <div class="lock-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
        </div>

        <h1>Portfolio Access</h1>
        <p class="subtitle">Enter your access code to view the detailed portfolio showcase</p>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="access_code">Access Code</label>
                <input type="text" id="access_code" name="access_code" placeholder="ENTER CODE" required autofocus>
            </div>

            <button type="submit" class="btn-submit">Access Portfolio</button>
        </form>

        <div class="info-box">
            <strong>For Recruiters & Collaborators:</strong><br>
            This portfolio contains detailed case studies, project artifacts, and behind-the-scenes work. Please use the access code provided to you.
        </div>

        <div class="back-link">
            <a href="index-wow.php">← Back to Public Portfolio</a>
        </div>
    </div>
</body>
</html>
