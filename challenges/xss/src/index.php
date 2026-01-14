<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 FeedbackHub</title>
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
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(0, 217, 255, 0.2);
        }
        
        .card h2 {
            color: #00d9ff;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 217, 255, 0.2);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
        }
        
        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(0, 217, 255, 0.3);
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-family: inherit;
            font-size: 1rem;
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #00d9ff;
        }
        
        button {
            background: linear-gradient(135deg, #00d9ff, #0099cc);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            color: #1a1a2e;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .feedback-item {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 3px solid #00d9ff;
        }
        
        .feedback-item .author {
            color: #00d9ff;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .feedback-item .content {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
        }
        
        .feedback-item .time {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.85rem;
            margin-top: 10px;
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
        
        .alert-info {
            background: rgba(0, 217, 255, 0.2);
            border: 1px solid rgba(0, 217, 255, 0.3);
            color: #00d9ff;
        }
        
        .no-feedback {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            padding: 40px;
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
        $feedbackFile = '/var/www/html/data/feedback.json';
        
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['feedback'])) {
            $name = $_POST['name'];
            $feedback = $_POST['feedback'];
            
            // Load existing feedback
            $feedbacks = [];
            if (file_exists($feedbackFile)) {
                $feedbacks = json_decode(file_get_contents($feedbackFile), true) ?? [];
            }
            
            // Add new feedback
            $feedbacks[] = [
                'id' => uniqid(),
                'name' => $name,
                'feedback' => $feedback,
                'time' => date('Y-m-d H:i:s')
            ];
            
            // Save feedback
            file_put_contents($feedbackFile, json_encode($feedbacks));
            
            echo '<div class="alert alert-success">✅ Feedback submitted successfully!</div>';
        }
        ?>
        
        <div class="card">
            <h2>💬 Submit Feedback</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="feedback">Your Feedback:</label>
                    <textarea id="feedback" name="feedback" placeholder="Share your thoughts..." required></textarea>
                </div>
                <button type="submit">Submit Feedback</button>
            </form>
        </div>
        
        <div class="card">
            <h2>📋 Recent Feedbacks</h2>
            <?php
            if (file_exists($feedbackFile)) {
                $feedbacks = json_decode(file_get_contents($feedbackFile), true) ?? [];
                $feedbacks = array_reverse($feedbacks); // Show newest first
                
                if (count($feedbacks) > 0) {
                    foreach (array_slice($feedbacks, 0, 10) as $fb) {
                        // VULNERABLE: XSS - No sanitization!
                        echo '<div class="feedback-item">';
                        echo '<div class="author">👤 ' . $fb['name'] . '</div>';
                        echo '<div class="content">' . $fb['feedback'] . '</div>';
                        echo '<div class="time">🕐 ' . htmlspecialchars($fb['time']) . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="no-feedback">No feedback yet. Be the first to share!</div>';
                }
            } else {
                echo '<div class="no-feedback">No feedback yet. Be the first to share!</div>';
            }
            ?>
        </div>
        
        <div class="card">
            <h2>ℹ️ Information</h2>
            <div class="alert alert-info">
                <strong>Note:</strong> Our admin reviews all feedback regularly. 
                If you find any issues, please <a href="/report.php" style="color: #fff;">report them to admin</a>.
                The admin will visit the reported page to investigate.
            </div>
        </div>
    </div>
</body>
</html>
