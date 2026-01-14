<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏢 CorpPortal - Employee Hub</title>
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
        
        .navbar a {
            color: #ffd700;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 15px;
            border: 1px solid #ffd700;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .navbar a:hover {
            background: #ffd700;
            color: #1a1a2e;
        }
        
        .hero {
            text-align: center;
            padding: 80px 20px;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, transparent 100%);
        }
        
        .hero h2 {
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 20px;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }
        
        .hero p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            padding: 60px 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 215, 0, 0.2);
            transition: transform 0.3s, border-color 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            border-color: #ffd700;
        }
        
        .feature-card .icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .feature-card h3 {
            color: #ffd700;
            margin-bottom: 15px;
        }
        
        .feature-card p {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.6;
        }
        
        footer {
            text-align: center;
            padding: 30px;
            color: rgba(255, 255, 255, 0.4);
            border-top: 1px solid #333;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>🏢 CorpPortal</h1>
        <div>
            <a href="/login.php">Login</a>
            <a href="/register.php">Register</a>
        </div>
    </nav>
    
    <div class="hero">
        <h2>Welcome to CorpPortal</h2>
        <p>Your centralized employee management system. Register now to access company resources.</p>
    </div>
    
    <div class="features">
        <div class="feature-card">
            <div class="icon">👤</div>
            <h3>User Dashboard</h3>
            <p>Access your personal dashboard and manage your profile settings.</p>
        </div>
        <div class="feature-card">
            <div class="icon">🔐</div>
            <h3>Secure Access</h3>
            <p>Role-based access control ensures data security.</p>
        </div>
        <div class="feature-card">
            <div class="icon">👑</div>
            <h3>Admin Panel</h3>
            <p>Administrators have access to special features and the flag!</p>
        </div>
    </div>
    
    <footer>
        &copy; 2024 CorpPortal - All rights reserved
    </footer>
</body>
</html>
