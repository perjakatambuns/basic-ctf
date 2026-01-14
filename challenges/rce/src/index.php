<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 ServerPing Tool</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            min-height: 100vh;
            background: #000;
            font-family: 'Fira Code', 'Consolas', monospace;
            color: #00ff00;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .terminal {
            width: 100%;
            max-width: 800px;
            background: #0d0d0d;
            border-radius: 10px;
            border: 1px solid #333;
            box-shadow: 0 0 50px rgba(0, 255, 0, 0.1);
            overflow: hidden;
        }
        
        .terminal-header {
            background: linear-gradient(180deg, #3d3d3d 0%, #2d2d2d 100%);
            padding: 12px 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #333;
        }
        
        .terminal-btn {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }
        
        .btn-close { background: #ff5f56; }
        .btn-min { background: #ffbd2e; }
        .btn-max { background: #27ca3f; }
        
        .terminal-title {
            flex: 1;
            text-align: center;
            color: #888;
            font-size: 0.85rem;
        }
        
        .terminal-body {
            padding: 25px;
        }
        
        .ascii-art {
            color: #00ff00;
            font-size: 0.65rem;
            line-height: 1.2;
            margin-bottom: 20px;
            text-align: center;
        }
        
        h1 {
            color: #00ff00;
            font-size: 1.5rem;
            margin-bottom: 5px;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: #00cc00;
            margin-bottom: 8px;
        }
        
        .input-line {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .prompt {
            color: #00ff00;
        }
        
        input[type="text"] {
            flex: 1;
            background: transparent;
            border: none;
            border-bottom: 1px solid #333;
            color: #00ff00;
            font-family: inherit;
            font-size: 1rem;
            padding: 10px 0;
            outline: none;
        }
        
        input[type="text"]:focus {
            border-bottom-color: #00ff00;
        }
        
        button {
            background: transparent;
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 10px 25px;
            font-family: inherit;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        button:hover {
            background: #00ff00;
            color: #000;
        }
        
        .output {
            margin-top: 25px;
            padding: 20px;
            background: #0a0a0a;
            border: 1px solid #222;
            border-radius: 5px;
            font-size: 0.9rem;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .output-header {
            color: #888;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #222;
        }
        
        .error {
            color: #ff4444;
        }
        
        .hint {
            margin-top: 20px;
            padding: 15px;
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 5px;
            color: #ffc107;
            font-size: 0.85rem;
        }
        
        .hint strong {
            color: #ffeb3b;
        }
        
        code {
            background: rgba(0, 0, 0, 0.5);
            padding: 2px 6px;
            border-radius: 3px;
            color: #00ff00;
        }
    </style>
</head>
<body>
    <div class="terminal">
        <div class="terminal-header">
            <div class="terminal-btn btn-close"></div>
            <div class="terminal-btn btn-min"></div>
            <div class="terminal-btn btn-max"></div>
            <div class="terminal-title">root@server:~</div>
        </div>
        
        <div class="terminal-body">
            <pre class="ascii-art">
  ____  _             _____           _ 
 |  _ \(_)_ __   __ _|_   _|__   ___ | |
 | |_) | | '_ \ / _` | | |/ _ \ / _ \| |
 |  __/| | | | | (_| | | | (_) | (_) | |
 |_|   |_|_| |_|\__, | |_|\___/ \___/|_|
                |___/                    
            </pre>
            
            <h1>🔧 ServerPing Tool</h1>
            <p class="subtitle">Network diagnostics utility v1.0</p>
            
            <form method="POST">
                <div class="form-group">
                    <label>Enter IP address or hostname to ping:</label>
                    <div class="input-line">
                        <span class="prompt">$</span>
                        <input type="text" name="host" placeholder="8.8.8.8" value="<?= htmlspecialchars($_POST['host'] ?? '') ?>">
                        <button type="submit">PING</button>
                    </div>
                </div>
            </form>
            
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['host'])): ?>
            <div class="output">
                <div class="output-header">// Ping Results:</div>
                <?php
                $host = $_POST['host'];
                
                // VULNERABLE: Remote Code Execution!
                // User input is directly passed to shell command
                $command = "ping -c 3 " . $host;
                $output = shell_exec($command);
                
                if ($output) {
                    echo htmlspecialchars($output);
                } else {
                    echo "<span class='error'>Error: No output or command failed</span>";
                }
                ?>
            </div>
            <?php endif; ?>
            
            <div class="hint">
                <strong>💡 Hint:</strong> 
                This tool executes the <code>ping</code> command on the server.
                What if you could inject additional commands? 
                Try using command separators like <code>;</code> or <code>|</code> or <code>&&</code>
                <br><br>
                Example: <code>8.8.8.8; cat /var/flag.txt</code>
            </div>
        </div>
    </div>
</body>
</html>
