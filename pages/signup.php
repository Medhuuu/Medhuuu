<?php
session_start();
require_once '../config/database.php';

// Initialize variables
$username = $email = '';
$errors = array();

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Please confirm your password';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    // Check if username or email already exists
    if (empty($errors)) {
        $database = new Database();
        
        // Check username
        $database->query("SELECT User_ID FROM User WHERE Username = :username");
        $database->bind(':username', $username);
        if ($database->single()) {
            $errors['username'] = 'Username already exists';
        }
        
        // Check email
        $database->query("SELECT User_ID FROM User WHERE Email = :email");
        $database->bind(':email', $email);
        if ($database->single()) {
            $errors['email'] = 'Email already registered';
        }
        
        // If no errors, insert user
        if (empty($errors)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $database->query("INSERT INTO User (Username, Password, Email) VALUES (:username, :password, :email)");
            $database->bind(':username', $username);
            $database->bind(':password', $hashed_password);
            $database->bind(':email', $email);
            
            if ($database->execute()) {
                $_SESSION['success_message'] = 'Account created successfully! Please login.';
                header('Location: login.php');
                exit();
            } else {
                $errors['general'] = 'Something went wrong. Please try again.';
            }
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
                    <a href="login.php" class="auth-switch-link">
                        Already have an account? <strong>Login</strong>
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
                            <h2 class="auth-title">Join CineLog</h2>
                            <p class="auth-subtitle">Start tracking your movie journey</p>
                        </div>

                        <?php if (!empty($errors['general'])): ?>
                            <div class="alert alert-danger">
                                <?php echo $errors['general']; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="auth-form">
                            <!-- Username Field -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input 
                                    type="text" 
                                    class="form-control auth-input <?php echo isset($errors['username']) ? 'is-invalid' : ''; ?>" 
                                    id="username" 
                                    name="username" 
                                    value="<?php echo htmlspecialchars($username); ?>"
                                    placeholder="Choose a unique username"
                                    required
                                >
                                <?php if (isset($errors['username'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['username']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input 
                                    type="email" 
                                    class="form-control auth-input <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                    id="email" 
                                    name="email" 
                                    value="<?php echo htmlspecialchars($email); ?>"
                                    placeholder="your@email.com"
                                    required
                                >
                                <?php if (isset($errors['email'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['email']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input 
                                    type="password" 
                                    class="form-control auth-input <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Choose a strong password"
                                    required
                                >
                                <?php if (isset($errors['password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="form-group mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input 
                                    type="password" 
                                    class="form-control auth-input <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                    id="confirm_password" 
                                    name="confirm_password" 
                                    placeholder="Confirm your password"
                                    required
                                >
                                <?php if (isset($errors['confirm_password'])): ?>
                                    <div class="invalid-feedback">
                                        <?php echo $errors['confirm_password']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth-primary w-100 mb-3">
                                Create Account
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="auth-footer-text">
                                    Already have an account? 
                                    <a href="login.php" class="auth-footer-link">Login here</a>
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