<?php
// Initialize SQLite database for Mass Assignment challenge

$db = new PDO('sqlite:/var/www/html/database.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Insert admin user
$db->exec("INSERT INTO users (username, email, password, role) VALUES ('admin', 'admin@company.local', 'superSecretAdminPass123!', 'admin')");

echo "Database initialized successfully!\n";
?>
