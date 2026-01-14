<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header('Location: /dashboard.php');
    exit;
}

$db = new PDO('sqlite:/var/www/html/database.db');
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: /dashboard.php');
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Login - CorpPortal</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 50%, #16213e 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 420px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 215, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .card h1 {
            text-align: center;
            color: #ffd700;
            margin-bottom: 10px;
            font-size: 2rem;
        }
        
        .card .subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 30px;
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
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            font-size: 1rem;
        }
        
        input:focus {
            outline: none;
            border-color: #ffd700;
        }
        
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            border: none;
            border-radius: 10px;
            color: #1a1a2e;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .error {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6464;
        }
        
        .links {
            text-align: center;
            margin-top: 20px;
        }
        
        .links a {
            color: #ffd700;
            text-decoration: none;
        }
        
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔐 Login</h1>
            <p class="subtitle">Access your account</p>
            
            <?php if ($message): ?>
                <div class="error"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit">Login</button>
            </form>
            
            <div class="links">
                Don't have an account? <a href="/register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>
