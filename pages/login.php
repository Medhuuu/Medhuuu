<?php
session_start();
require_once '../config/database.php';

// Initialize variables
$username = '';
$error = '';
$success = '';

// Check for success message from signup
if (isset($_SESSION['success_message'])) {
    $success = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Process login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validate input
    if (empty($username)) {
        $error = 'Username or email is required.';
    } elseif (empty($password)) {
        $error = 'Password is required.';
    } else {
        // Check user credentials
        $database = new Database();
        $database->query("SELECT * FROM User WHERE Username = :username OR Email = :email");
        $database->bind(':username', $username);
        $database->bind(':email', $username);
        $user = $database->single();
        
        if ($user && password_verify($password, $user->Password)) {
            // Login successful
            $_SESSION['user_id'] = $user->User_ID;
            $_SESSION['username'] = $user->Username;
            $_SESSION['email'] = $user->Email;
            
            // Set remember me cookie if checked
            if ($remember) {
                $remember_token = bin2hex(random_bytes(16));
                setcookie('remember_token', $remember_token, time() + (86400 * 30), '/'); // 30 days
                // You can store this token in database for security if needed
            }
            
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <!-- Header with Back to Home -->
    <nav class="auth-nav">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6">
                    <a href="../index.php" class="brand-link">
                        <h3 class="brand-name">CineLog</h3>
                    </a>
                </div>
                <div class="col-6 text-end">
                    <a href="signup.php" class="auth-switch-link">
                        Don't have an account? <strong>Sign Up</strong>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <div class="auth-header text-center mb-4">
                            <h2 class="auth-title">Welcome Back</h2>
                            <p class="auth-subtitle">Login to continue your movie journey</p>
                        </div>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="auth-form">
                            <!-- Username/Email Field -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username or Email</label>
                                <input 
                                    type="text" 
                                    class="form-control auth-input" 
                                    id="username" 
                                    name="username" 
                                    value="<?php echo htmlspecialchars($username); ?>"
                                    placeholder="Enter your username or email"
                                    required
                                >
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input 
                                    type="password" 
                                    class="form-control auth-input" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter your password"
                                    required
                                >
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-4">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    id="remember" 
                                    name="remember"
                                >
                                <label class="form-check-label" for="remember">
                                    Remember me for 30 days
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth-primary w-100 mb-3">
                                Login
                            </button>

                            <!-- Links -->
                            <div class="text-center">
                                <p class="auth-footer-text mb-2">
                                    Don't have an account? 
                                    <a href="signup.php" class="auth-footer-link">Sign up here</a>
                                </p>
                                <p class="auth-footer-text">
                                    <a href="../index.php" class="auth-footer-link">← Back to Home</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>