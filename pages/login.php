<?php
session_start();
require_once '../config/database.php';

$error = '';
$success = '';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validate input
    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // Check user credentials
        $database = new Database();
        $database->query("SELECT * FROM USERS WHERE Username = :username OR Email = :email");
        $database->bind(':username', $username);
        $database->bind(':email', $username);
        $user = $database->single();
        
        if ($user && password_verify($password, $user->Password)) {
            // Login successful
            $_SESSION['user_id'] = $user->UserID;
            $_SESSION['username'] = $user->Username;
            $_SESSION['email'] = $user->Email;
            
            // Redirect to dashboard or intended page
            $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard.php';
            header('Location: ' . $redirect);
            exit();
        } else {
            $error = 'Invalid username/email or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CineLog</title>
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
                        <p class="brand-subtitle mb-4">Welcome back, film enthusiast!</p>
                        <div class="brand-features">
                            <p class="feature-item">🎭 Access your movie collection</p>
                            <p class="feature-item">📊 View your watching statistics</p>
                            <p class="feature-item">🔍 Discover personalized recommendations</p>
                            <p class="feature-item">💬 Connect with fellow movie lovers</p>
                        </div>
                    </div>
                </div>
                
                <!-- Right side - Login Form -->
                <div class="col-lg-6 d-flex align-items-center justify-content-center p-5">
                    <div class="auth-form-container">
                        <div class="auth-form">
                            <div class="text-center mb-4">
                                <h2 class="auth-title h3 fw-bold mb-2">Welcome Back</h2>
                                <p class="auth-subtitle text-muted">Sign in to continue your movie journey</p>
                            </div>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($success): ?>
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label fw-semibold">Username or Email</label>
                                    <input type="text" class="form-control auth-input" id="username" name="username" 
                                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" 
                                           required placeholder="Enter your username or email">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">Password</label>
                                    <input type="password" class="form-control auth-input" id="password" name="password" 
                                           required placeholder="Enter your password">
                                </div>
                                
                                <button type="submit" class="btn btn-auth btn-lg w-100 mb-3">
                                    Sign In
                                </button>
                            </form>
                            
                            <div class="text-center">
                                <p class="mb-0">Don't have an account? 
                                    <a href="signup.php" class="auth-link fw-semibold">Create Account</a>
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