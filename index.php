<?php
$pageTitle = "CineLog - Your Movie Journal";
require_once 'config/database.php';

// Initialize database connection
$database = new Database();

// Get some sample movies from database (if any exist)
$database->query("SELECT * FROM Movies LIMIT 6");
$movies = $database->resultset();

// Get some statistics
$database->query("SELECT COUNT(*) as total FROM Movies");
$totalMovies = $database->single()->total ?? 0;

$database->query("SELECT COUNT(*) as total FROM User");
$totalUsers = $database->single()->total ?? 0;

$database->query("SELECT COUNT(*) as total FROM Reviews");
$totalReviews = $database->single()->total ?? 0;

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <div class="hero-content fade-in-up">
                    <h1>Welcome to CineLog</h1>
                    <p class="lead">Your personal movie journal. Track, rate, and review your favorite films. Discover new movies based on your mood and preferences.</p>
                    
                    <div class="hero-buttons">
                        <a href="pages/register.php" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-user-plus me-2"></i>Get Started
                        </a>
                        <a href="pages/movies.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-video me-2"></i>Browse Movies
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <i class="fas fa-film" style="font-size: 20rem; color: var(--primary-color); opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Find Your Next Movie</h2>
                    <p class="text-muted">Search through thousands of movies by title, genre, or mood</p>
                </div>
                
                <div class="search-container">
                    <form class="d-flex" action="pages/movies.php" method="GET">
                        <input class="form-control search-input me-3" type="search" name="search" placeholder="Search for movies..." aria-label="Search">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Movies Section -->
<?php if (!empty($movies)): ?>
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Featured Movies</h2>
                <p class="text-muted">Discover popular and trending movies</p>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($movies as $movie): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="movie-card">
                    <div class="movie-poster" style="background-image: url('<?php echo $movie->Poster_URL ?: 'https://via.placeholder.com/400x600/333/fff?text=No+Image'; ?>');">
                        <div class="movie-rating"><?php echo number_format($movie->Avg_Rating, 1); ?></div>
                        <div class="movie-year"><?php echo $movie->Release_year; ?></div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movie->Title); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars(substr($movie->Description, 0, 100)) . '...'; ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="pages/movie-details.php?id=<?php echo $movie->Movie_ID; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-plus me-1"></i>Add to Watchlist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="pages/movies.php" class="btn btn-outline-primary">
                <i class="fas fa-video me-2"></i>View All Movies
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalMovies; ?></div>
                    <div class="stat-label">Movies</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalUsers; ?></div>
                    <div class="stat-label">Users</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $totalReviews; ?></div>
                    <div class="stat-label">Reviews</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold">Why Choose CineLog?</h2>
                <p class="text-muted">Powerful features to enhance your movie experience</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h4 class="feature-title">Rate & Review</h4>
                    <p class="feature-description">Rate movies on a scale of 1-10 and write detailed reviews to share your thoughts with the community.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <h4 class="feature-title">Personal Watchlist</h4>
                    <p class="feature-description">Keep track of movies you want to watch and organize them by priority and mood.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="feature-title">Track Progress</h4>
                    <p class="feature-description">Monitor your movie watching habits with detailed statistics and personalized insights.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-filter"></i>
                    </div>
                    <h4 class="feature-title">Smart Filtering</h4>
                    <p class="feature-description">Filter movies by genre, mood, rating, and watch status to find exactly what you're looking for.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-sort"></i>
                    </div>
                    <h4 class="feature-title">Advanced Sorting</h4>
                    <p class="feature-description">Sort your movies alphabetically, by rating, release year, or date added to your collection.</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4 class="feature-title">Responsive Design</h4>
                    <p class="feature-description">Access your movie journal from any device with our fully responsive and mobile-friendly design.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="search-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-4">Ready to Start Your Movie Journey?</h2>
                <p class="text-muted mb-4">Join thousands of movie enthusiasts who trust CineLog to manage their movie experience.</p>
                <div class="cta-buttons">
                    <a href="pages/register.php" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-user-plus me-2"></i>Create Account
                    </a>
                    <a href="pages/login.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>