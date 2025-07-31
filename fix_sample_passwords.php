<?php
// Script to fix sample user passwords with proper hashing
require_once 'config/database.php';

$database = new Database();

// Hash the password 'password' for demo users
$hashedPassword = password_hash('password', PASSWORD_DEFAULT);

// Update all sample users with the hashed password
$database->query("UPDATE User SET Password = :password WHERE Username IN ('moviebuff', 'cinephile', 'filmcritic')");
$database->bind(':password', $hashedPassword);
$database->execute();

echo "Sample user passwords have been updated with proper hashing.\n";
echo "You can now login with:\n";
echo "Username: moviebuff, Password: password\n";
echo "Username: cinephile, Password: password\n";
echo "Username: filmcritic, Password: password\n";
echo "Or use their respective emails with password: password\n";
?>