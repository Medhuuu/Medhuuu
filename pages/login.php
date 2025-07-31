<?php
session_start();
$pageTitle = "Login - CineLog";
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
        $database->query("SELECT * FROM User WHERE Username = :username OR Email = :email");
        $database->bind(':username', $username);
        $database->bind(':email', $username);
        $user = $database->single();
        
        if ($user && password_verify($password, $user->Password)) {
            // Login successful
            $_SESSION['user_id'] = $user->User_ID;
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

include '../includes/header.php';
?>

<div class="login-container">
    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Left side - Login Form -->
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="login-form-container">
                    <div class="text-center mb-5">
                        <h1 class="login-title">
                            <i class="fas fa-film text-primary me-3"></i>Welcome Back
                        </h1>
                        <p class="text-muted">Sign in to your CineLog account</p>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="" class="login-form">
                        <div class="form-group mb-4">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Username or Email
                            </label>
                            <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                   placeholder="Enter your username or email" 
                                   value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password
                            </label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                   placeholder="Enter your password" required>
                        </div>
                        
                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </button>
                        
                        <div class="text-center">
                            <a href="forgot-password.php" class="text-decoration-none">
                                <i class="fas fa-key me-1"></i>Forgot your password?
                            </a>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-0">Don't have an account? 
                                <a href="register.php" class="text-primary text-decoration-none fw-bold">
                                    Create one here
                                </a>
                            </p>
                        </div>
                    </form>
                    
                    <!-- Demo credentials -->
                    <div class="demo-credentials mt-4">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-info-circle me-2"></i>Demo Credentials
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">
                                    <strong>Username:</strong> moviebuff<br>
                                    <strong>Password:</strong> password
                                </small>
                            </div>
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">
                                    <strong>Email:</strong> cinephile@example.com<br>
                                    <strong>Password:</strong> password
                                </small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-info">
                                <i class="fas fa-lightbulb me-1"></i>
                                Copy and paste the credentials above to test the login
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Hero Image -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="login-hero">
                    <div class="hero-overlay">
                        <div class="hero-content">
                            <h2 class="hero-title">Your Movie Journey Awaits</h2>
                            <p class="hero-subtitle">Track, rate, and discover amazing films with CineLog</p>
                            <div class="hero-features">
                                <div class="feature-item">
                                    <i class="fas fa-star"></i>
                                    <span>Rate & Review Movies</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-bookmark"></i>
                                    <span>Create Watchlists</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-chart-line"></i>
                                    <span>Track Your Progress</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Login Page Specific Styles */
.login-container {
    min-height: 100vh;
    background-color: var(--dark-bg);
}

.login-form-container {
    max-width: 450px;
    width: 100%;
    padding: 2rem;
}

.login-title {
    font-size: 2.5rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.login-form {
    background-color: var(--card-bg);
    padding: 2.5rem;
    border-radius: 20px;
    border: 1px solid var(--border-color);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.form-label {
    color: var(--text-light);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    background-color: var(--dark-bg);
    border: 2px solid var(--border-color);
    color: var(--text-light);
    border-radius: 12px;
    padding: 12px 20px;
    transition: all 0.3s ease;
}

.form-control:focus {
    background-color: var(--dark-bg);
    border-color: var(--primary-color);
    color: var(--text-light);
    box-shadow: 0 0 0 0.2rem rgba(229, 9, 20, 0.25);
}

.form-control::placeholder {
    color: var(--text-muted);
}



.form-check-input {
    background-color: var(--dark-bg);
    border-color: var(--border-color);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-label {
    color: var(--text-light);
}

.btn-primary {
    background: linear-gradient(45deg, var(--primary-color), #ff4757);
    border: none;
    border-radius: 12px;
    padding: 15px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(229, 9, 20, 0.4);
}

.login-hero {
    height: 100vh;
    background: linear-gradient(45deg, rgba(0,0,0,0.6), rgba(229, 9, 20, 0.3)), 
                url('https://images.unsplash.com/photo-1489599162942-c1b4f1b99b21?ixlib=rb-4.0.3') center/cover;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-overlay {
    text-align: center;
    color: white;
    padding: 2rem;
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.hero-features {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 300px;
    margin: 0 auto;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.feature-item i {
    font-size: 1.5rem;
    color: var(--accent-color);
}

.demo-credentials {
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
}

.alert {
    border-radius: 12px;
    border: none;
}

.alert-danger {
    background-color: rgba(220, 53, 69, 0.2);
    color: #f8d7da;
    border-left: 4px solid #dc3545;
}

.alert-success {
    background-color: rgba(40, 167, 69, 0.2);
    color: #d4edda;
    border-left: 4px solid #28a745;
}

@media (max-width: 768px) {
    .login-form-container {
        padding: 1rem;
    }
    
    .login-form {
        padding: 2rem 1.5rem;
    }
    
    .login-title {
        font-size: 2rem;
    }
}
</style>



<?php include '../includes/footer.php'; ?>