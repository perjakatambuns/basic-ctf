<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🖼️ ImageGallery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: #0a0a0a;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 0, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 0, 120, 0.15) 0%, transparent 50%);
            font-family: 'Arial', sans-serif;
            color: #fff;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        header {
            text-align: center;
            padding: 40px 0;
        }
        
        h1 {
            font-size: 3rem;
            background: linear-gradient(135deg, #ff0080, #7928ca, #00d4ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .gallery-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.3s, border-color 0.3s;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            border-color: #7928ca;
        }
        
        .gallery-item a {
            display: block;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #fff;
        }
        
        .gallery-item .icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }
        
        .gallery-item .name {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .download-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .download-section h2 {
            color: #7928ca;
            margin-bottom: 20px;
        }
        
        .file-content {
            background: #1a1a1a;
            border-radius: 10px;
            padding: 20px;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .error {
            background: rgba(255, 0, 80, 0.2);
            border: 1px solid #ff0080;
            padding: 20px;
            border-radius: 10px;
            color: #ff6b9d;
        }
        
        .hint {
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            color: #ffc107;
        }
        
        .hint strong {
            color: #ffeb3b;
        }
        
        code {
            background: rgba(0, 0, 0, 0.5);
            padding: 2px 8px;
            border-radius: 4px;
            color: #00d4ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🖼️ ImageGallery</h1>
            <p class="subtitle">Browse and download your favorite images</p>
        </header>
        
        <div class="gallery">
            <div class="gallery-item">
                <a href="?file=images/sunset.txt">
                    <div class="icon">🌅</div>
                    <div class="name">sunset.txt</div>
                </a>
            </div>
            <div class="gallery-item">
                <a href="?file=images/mountain.txt">
                    <div class="icon">🏔️</div>
                    <div class="name">mountain.txt</div>
                </a>
            </div>
            <div class="gallery-item">
                <a href="?file=images/ocean.txt">
                    <div class="icon">🌊</div>
                    <div class="name">ocean.txt</div>
                </a>
            </div>
            <div class="gallery-item">
                <a href="?file=images/forest.txt">
                    <div class="icon">🌲</div>
                    <div class="name">forest.txt</div>
                </a>
            </div>
        </div>
        
        <?php if (isset($_GET['file'])): ?>
        <div class="download-section">
            <h2>📄 File Contents</h2>
            <?php
            $file = $_GET['file'];
            
            // VULNERABLE: Local File Disclosure - no proper validation!
            if (file_exists($file)) {
                $content = file_get_contents($file);
                echo "<div class='file-content'>" . htmlspecialchars($content) . "</div>";
            } else {
                echo "<div class='error'>❌ File not found: " . htmlspecialchars($file) . "</div>";
            }
            ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
