<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 SecureBank Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .logo h1 {
            color: #e94560;
            font-size: 2rem;
            margin-bottom: 5px;
        }
        
        .logo p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #e94560;
        }
        
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #e94560, #ff6b6b);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(233, 69, 96, 0.4);
        }
        
        .message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: #ff6b6b;
        }
        
        .success {
            background: rgba(0, 255, 0, 0.2);
            border: 1px solid rgba(0, 255, 0, 0.3);
            color: #6bff6b;
        }
        
        .hint {
            margin-top: 30px;
            padding: 15px;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 10px;
            color: rgba(255, 193, 7, 0.8);
            font-size: 0.85rem;
        }
        
        .hint strong {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>🏦 SecureBank</h1>
            <p>Your trusted banking partner</p>
        </div>
        
        <?php
        $message = '';
        $messageType = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            try {
                $db = new PDO('sqlite:/var/www/html/database.db');
                
                // VULNERABLE: SQL Injection here!
                $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $result = $db->query($query);
                
                if ($result && $row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $message = "Welcome back, {$row['username']}! Role: {$row['role']}";
                    $messageType = 'success';
                    
                    if ($row['role'] === 'admin') {
                        // Show flag for admin
                        $flagQuery = $db->query("SELECT flag FROM secrets LIMIT 1");
                        $flag = $flagQuery->fetch(PDO::FETCH_ASSOC);
                        $message .= "<br><br>🎉 Admin Access Granted!<br><strong>{$flag['flag']}</strong>";
                    }
                } else {
                    $message = "Invalid username or password!";
                    $messageType = 'error';
                }
            } catch (Exception $e) {
                $message = "Database error: " . $e->getMessage();
                $messageType = 'error';
            }
        }
        ?>
        
        <?php if ($message): ?>
            <div class="message <?= $messageType ?>">
                <?= $message ?>
            </div>
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
    </div>
</body>
</html>
