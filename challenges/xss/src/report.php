<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Report to Admin - FeedbackHub</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: #1a1a2e;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        
        .navbar h1 {
            color: #00d9ff;
            font-size: 1.5rem;
        }
        
        .navbar a {
            color: #00d9ff;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s;
        }
        
        .navbar a:hover {
            color: #fff;
        }
        
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 100, 100, 0.3);
        }
        
        .card h2 {
            color: #ff6464;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 100, 100, 0.2);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(255, 100, 100, 0.3);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-family: inherit;
            font-size: 1rem;
        }
        
        input:focus {
            outline: none;
            border-color: #ff6464;
        }
        
        button {
            background: linear-gradient(135deg, #ff6464, #cc4444);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: #fff;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: rgba(0, 255, 100, 0.2);
            border: 1px solid rgba(0, 255, 100, 0.3);
            color: #00ff64;
        }
        
        .alert-warning {
            background: rgba(255, 193, 7, 0.2);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: #ffc107;
        }
        
        .info-box {
            background: rgba(0, 217, 255, 0.1);
            border: 1px solid rgba(0, 217, 255, 0.2);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .info-box h3 {
            color: #00d9ff;
            margin-bottom: 10px;
        }
        
        .info-box p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }
        
        code {
            background: rgba(0, 0, 0, 0.5);
            padding: 2px 8px;
            border-radius: 4px;
            color: #00d9ff;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>📝 FeedbackHub</h1>
        <div>
            <a href="/">Home</a>
            <a href="/report.php">Report to Admin</a>
        </div>
    </nav>
    
    <div class="container">
        <?php
        $reportsFile = '/var/www/html/data/reports.json';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
            $url = $_POST['url'];
            
            // Only allow local URLs
            if (strpos($url, 'http://localhost') === 0 || strpos($url, 'http://127.0.0.1') === 0) {
                // Load existing reports
                $reports = [];
                if (file_exists($reportsFile)) {
                    $reports = json_decode(file_get_contents($reportsFile), true) ?? [];
                }
                
                // Add new report
                $reports[] = [
                    'id' => uniqid(),
                    'url' => $url,
                    'status' => 'pending',
                    'time' => date('Y-m-d H:i:s')
                ];
                
                // Save reports
                file_put_contents($reportsFile, json_encode($reports));
                
                echo '<div class="alert alert-success">✅ Report submitted! Admin will visit this page shortly.</div>';
            } else {
                echo '<div class="alert alert-warning">⚠️ Only local URLs (http://localhost/...) are allowed!</div>';
            }
        }
        ?>
        
        <div class="card">
            <h2>🚨 Report URL to Admin</h2>
            <p style="color: rgba(255,255,255,0.7); margin-bottom: 20px;">
                Found something suspicious? Report the URL and our admin will investigate.
            </p>
            
            <form method="POST">
                <div class="form-group">
                    <label for="url">URL to Report:</label>
                    <input type="text" id="url" name="url" placeholder="http://localhost/..." required>
                </div>
                <button type="submit">🔍 Submit Report</button>
            </form>
            
            <div class="info-box">
                <h3>ℹ️ How it works:</h3>
                <p>
                    1. Submit a URL that you want the admin to check<br>
                    2. Our admin bot will visit the URL within a few seconds<br>
                    3. The admin has a special cookie: <code>admin_session</code><br>
                    4. Only URLs starting with <code>http://localhost</code> are allowed
                </p>
            </div>
        </div>
    </div>
</body>
</html>
