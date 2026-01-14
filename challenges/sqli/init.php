<?php
// Initialize SQLite database for SQL Injection challenge

$db = new PDO('sqlite:/var/www/html/database.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'user'
)");

// Insert sample users
$db->exec("INSERT INTO users (username, password, role) VALUES ('admin', 'sup3rs3cr3tp4ss', 'admin')");
$db->exec("INSERT INTO users (username, password, role) VALUES ('guest', 'guest123', 'user')");
$db->exec("INSERT INTO users (username, password, role) VALUES ('john', 'password123', 'user')");

// Create secrets table with flag
$db->exec("CREATE TABLE IF NOT EXISTS secrets (
    id INTEGER PRIMARY KEY,
    flag TEXT NOT NULL
)");

$db->exec("INSERT INTO secrets (flag) VALUES ('FLAG{SIMULASI}')");

echo "Database initialized successfully!\n";
?>
