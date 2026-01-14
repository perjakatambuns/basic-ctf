<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📚 DocReader Pro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2d1b69 0%, #11998e 100%);
            font-family: 'Courier New', monospace;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            margin-bottom: 40px;
            padding: 30px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            border: 2px solid #11998e;
        }
        
        h1 {
            color: #38ef7d;
            font-size: 2.5rem;
            text-shadow: 0 0 20px rgba(56, 239, 125, 0.5);
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .nav {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .nav a {
            padding: 12px 25px;
            background: rgba(56, 239, 125, 0.2);
            border: 1px solid #38ef7d;
            border-radius: 8px;
            color: #38ef7d;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .nav a:hover, .nav a.active {
            background: #38ef7d;
            color: #1a1a2e;
        }
        
        .content-box {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(56, 239, 125, 0.3);
        }
        
        .content-box h2 {
            color: #38ef7d;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(56, 239, 125, 0.3);
        }
        
        .content {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            white-space: pre-wrap;
            font-family: 'Courier New', monospace;
        }
        
        .error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid #ff6b6b;
            padding: 20px;
            border-radius: 10px;
            color: #ff6b6b;
        }
        
        .hint {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.4);
            border-radius: 10px;
            color: #ffc107;
        }
        
        .hint strong {
            display: block;
            margin-bottom: 10px;
        }
        
        code {
            background: rgba(0, 0, 0, 0.5);
            padding: 2px 8px;
            border-radius: 4px;
            color: #38ef7d;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 DocReader Pro</h1>
            <p class="subtitle">Your trusted documentation viewer</p>
        </header>
        
        <nav class="nav">
            <a href="?page=home" <?= (!isset($_GET['page']) || $_GET['page'] === 'home') ? 'class="active"' : '' ?>>🏠 Home</a>
            <a href="?page=about" <?= (isset($_GET['page']) && $_GET['page'] === 'about') ? 'class="active"' : '' ?>>ℹ️ About</a>
            <a href="?page=contact" <?= (isset($_GET['page']) && $_GET['page'] === 'contact') ? 'class="active"' : '' ?>>📧 Contact</a>
            <a href="?page=help" <?= (isset($_GET['page']) && $_GET['page'] === 'help') ? 'class="active"' : '' ?>>❓ Help</a>
        </nav>
        
        <div class="content-box">
            <?php
            $page = $_GET['page'] ?? 'home';
            
            // VULNERABLE: Local File Inclusion!
            $file = "pages/" . $page . ".php";
            
            if (file_exists($file)) {
                echo "<h2>📄 " . ucfirst($page) . "</h2>";
                echo "<div class='content'>";
                include($file);
                echo "</div>";
            } else {
                // Still vulnerable - allows path traversal
                if (isset($_GET['page']) && strpos($_GET['page'], '..') !== false) {
                    $traversal_file = $_GET['page'];
                    if (file_exists($traversal_file)) {
                        echo "<h2>📄 File Contents</h2>";
                        echo "<div class='content'>";
                        include($traversal_file);
                        echo "</div>";
                    } else {
                        echo "<div class='error'>❌ File not found: " . htmlspecialchars($traversal_file) . "</div>";
                    }
                } else {
                    echo "<div class='error'>❌ Page not found: " . htmlspecialchars($page) . "</div>";
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
