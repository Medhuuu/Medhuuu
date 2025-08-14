<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $database = new Database();
            
            // Check if username already exists
            $database->query("SELECT UserID FROM USERS WHERE Username = :username");
            $database->bind(':username', $username);
            if ($database->single()) {
                $error = 'Username already exists. Please choose a different one.';
            } else {
                // Check if email already exists
                $database->query("SELECT UserID FROM USERS WHERE Email = :email");
                $database->bind(':email', $email);
                if ($database->single()) {
                    $error = 'Email already registered. Please use a different email.';
                } else {
                    // Hash password and create user
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $database->query("INSERT INTO USERS (Username, Password, Email) VALUES (:username, :password, :email)");
                    $database->bind(':username', $username);
                    $database->bind(':password', $hashed_password);
                    $database->bind(':email', $email);
                    
                    if ($database->execute()) {
                        $success = 'Account created successfully! You can now login.';
                    } else {
                        $error = 'Failed to create account. Please try again.';
                    }
                }
            }
        } catch (Exception $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CineLog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-background">
            <div class="clouds-overlay"></div>
        </div>
        
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Left side - Branding -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center p-5">
                    <div class="auth-branding text-center">
                        <h1 class="brand-title mb-4">
                            <a href="../index.php" class="text-decoration-none text-white">CineLog</a>
                        </h1>
                        <p class="brand-subtitle mb-4">Join the community of film enthusiasts</p>
                        <div class="brand-features">
                            <p class="feature-item">📽️ Track your watched movies</p>
                            <p class="feature-item">⭐ Rate and review films</p>
                            <p class="feature-item">📚 Create your watchlist</p>
                            <p class="feature-item">🎬 Discover new favorites</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - Signup Form -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center p-5">
                    <div class="auth-form-container">
                        <div class="auth-form">
                            <div class="text-center mb-4">
                                <h2 class="auth-title h3 fw-bold mb-2">Create Account</h2>
                                <p class="auth-subtitle text-muted">Start your movie journey today</p>
                            </div>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($success): ?>
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                                    <div class="mt-2">
                                        <a href="login.php" class="btn btn-success btn-sm">Go to Login</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control auth-input" id="username" name="username" 
                                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" 
                                           required placeholder="Choose a unique username">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control auth-input" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                                           required placeholder="your.email@example.com">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control auth-input" id="password" name="password" 
                                           required placeholder="Minimum 6 characters">
                                    <div class="form-text">Password must be at least 6 characters long</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                                    <input type="password" class="form-control auth-input" id="confirm_password" name="confirm_password" 
                                           required placeholder="Re-enter your password">
                                </div>
                                
                                <button type="submit" class="btn btn-auth btn-lg w-100 mb-3">
                                    Create Account
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <p class="mb-0">Already have an account? 
                                    <a href="login.php" class="auth-link fw-semibold">Sign In</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>