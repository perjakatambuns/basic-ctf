<?php
session_start();

$db = new PDO('sqlite:/var/www/html/database.db');
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // VULNERABLE: Mass Assignment - directly using all POST data!
    $data = $_POST;
    
    $username = $data['username'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $role = $data['role'] ?? 'user'; // Hidden field can be manipulated!
    
    if ($username && $email && $password) {
        // Check if username exists
        $check = $db->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);
        
        if ($check->fetch()) {
            $message = "Username already exists!";
            $messageType = 'error';
        } else {
            // Insert new user with whatever role was provided
            $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password, $role]);
            
            $message = "Registration successful! You can now login.";
            $messageType = 'success';
        }
    } else {
        $message = "Please fill all required fields!";
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Register - CorpPortal</title>
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
            max-width: 450px;
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
        input[type="email"],
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
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .success {
            background: rgba(0, 255, 100, 0.2);
            border: 1px solid rgba(0, 255, 100, 0.3);
            color: #00ff64;
        }
        
        .error {
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
        
        /* Debug info - developers left this in production! */
        .debug-info {
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
        }
        
        .debug-info code {
            color: #ffd700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>📝 Register</h1>
            <p class="subtitle">Create your account</p>
            
            <?php if ($message): ?>
                <div class="message <?= $messageType ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>
                
                <input type="hidden" name="role" value="user">
                
                <button type="submit">Create Account</button>
            </form>
            
            <div class="links">
                Already have an account? <a href="/login.php">Login here</a>
            </div>
        </div>
    </div>
</body>
</html>
