<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 View Feedback - FeedbackHub</title>
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
            padding: 40px 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .feedback-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(0, 217, 255, 0.2);
        }
        
        .feedback-box h1 {
            color: #00d9ff;
            margin-bottom: 20px;
        }
        
        .author {
            color: #00d9ff;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        
        .content {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #00d9ff;
            text-decoration: none;
        }
        
        .error {
            color: #ff6464;
            text-align: center;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="feedback-box">
            <?php
            $id = $_GET['id'] ?? '';
            $feedbackFile = '/var/www/html/data/feedback.json';
            
            if ($id && file_exists($feedbackFile)) {
                $feedbacks = json_decode(file_get_contents($feedbackFile), true) ?? [];
                $found = null;
                
                foreach ($feedbacks as $fb) {
                    if ($fb['id'] === $id) {
                        $found = $fb;
                        break;
                    }
                }
                
                if ($found) {
                    echo '<h1>📝 Feedback Details</h1>';
                    // VULNERABLE: XSS - No sanitization!
                    echo '<div class="author">👤 From: ' . $found['name'] . '</div>';
                    echo '<div class="content">' . $found['feedback'] . '</div>';
                } else {
                    echo '<div class="error">Feedback not found</div>';
                }
            } else {
                echo '<div class="error">Invalid request</div>';
            }
            ?>
            <a href="/" class="back-link">← Back to Home</a>
        </div>
    </div>
</body>
</html>
