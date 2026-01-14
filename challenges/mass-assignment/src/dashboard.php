<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit;
}

$user = $_SESSION['user'];
$isAdmin = ($user['role'] === 'admin');

// Flag for admin users
$flag = 'FLAG{SIMULASI}';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Dashboard - CorpPortal</title>
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
            color: #fff;
        }
        
        .navbar {
            background: rgba(0, 0, 0, 0.5);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #333;
        }
        
        .navbar h1 {
            color: #ffd700;
            font-size: 1.5rem;
        }
        
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .navbar .user-info span {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .navbar .role-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
        }
        
        .role-admin {
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            color: #1a1a2e;
        }
        
        .role-user {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        
        .navbar a {
            color: #ff6464;
            text-decoration: none;
            padding: 8px 15px;
            border: 1px solid #ff6464;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .navbar a:hover {
            background: #ff6464;
            color: #fff;
        }
        
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        .welcome-card h2 {
            color: #ffd700;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        .card h3 {
            color: #ffd700;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }
        
        .card .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card .info-row:last-child {
            border-bottom: none;
        }
        
        .card .info-row .label {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .card .info-row .value {
            color: #fff;
        }
        
        .admin-panel {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 170, 0, 0.05));
            border: 2px solid #ffd700;
        }
        
        .admin-panel h3 {
            color: #ffd700;
        }
        
        .flag-box {
            background: rgba(0, 255, 100, 0.1);
            border: 2px solid #00ff64;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-top: 15px;
        }
        
        .flag-box .flag {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            color: #00ff64;
            word-break: break-all;
        }
        
        .locked-message {
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            padding: 30px;
        }
        
        .locked-message .icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏢 CorpPortal</h1>
        <div class="user-info">
            <span>👤 <?= htmlspecialchars($user['username']) ?></span>
            <span class="role-badge <?= $isAdmin ? 'role-admin' : 'role-user' ?>">
                <?= $isAdmin ? '👑 Admin' : '👤 User' ?>
            </span>
            <a href="/logout.php">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="welcome-card">
            <h2>Welcome back, <?= htmlspecialchars($user['username']) ?>! 👋</h2>
            <p>You are logged in as <strong><?= $isAdmin ? 'Administrator' : 'User' ?></strong></p>
        </div>
        
        <div class="cards-grid">
            <div class="card">
                <h3>👤 Profile Information</h3>
                <div class="info-row">
                    <span class="label">Username</span>
                    <span class="value"><?= htmlspecialchars($user['username']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Role</span>
                    <span class="value"><?= htmlspecialchars($user['role']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Member Since</span>
                    <span class="value"><?= htmlspecialchars($user['created_at'] ?? 'N/A') ?></span>
                </div>
            </div>
            
            <div class="card admin-panel">
                <h3>👑 Admin Panel</h3>
                <?php if ($isAdmin): ?>
                    <p style="color: rgba(255,255,255,0.7); margin-bottom: 15px;">
                        Welcome, Administrator! Here's your secret flag:
                    </p>
                    <div class="flag-box">
                        <div class="flag"><?= $flag ?></div>
                    </div>
                <?php else: ?>
                    <div class="locked-message">
                        <div class="icon">🔒</div>
                        <p>This section is only available for administrators.</p>
                        <p style="margin-top: 10px; font-size: 0.9rem;">
                            Your current role: <strong><?= htmlspecialchars($user['role']) ?></strong>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
