<?php
session_start();
$pageTitle = "Dashboard - CineLog";
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$database = new Database();
$user_id = $_SESSION['user_id'];

// Get user stats
$database->query("SELECT COUNT(*) as total FROM User_Movies WHERE M_UserID = :user_id AND Watched_Status = 'watched'");
$database->bind(':user_id', $user_id);
$watchedMovies = $database->single()->total ?? 0;

$database->query("SELECT COUNT(*) as total FROM User_Movies WHERE M_UserID = :user_id AND Watched_Status = 'to_watch'");
$database->bind(':user_id', $user_id);
$toWatchMovies = $database->single()->total ?? 0;

$database->query("SELECT COUNT(*) as total FROM Reviews WHERE R_UserID = :user_id");
$database->bind(':user_id', $user_id);
$totalReviews = $database->single()->total ?? 0;

$database->query("SELECT COUNT(*) as total FROM Wishlist WHERE W_UserID = :user_id");
$database->bind(':user_id', $user_id);
$wishlistCount = $database->single()->total ?? 0;

// Get recent movies
$database->query("
    SELECT m.*, um.Watched_Status, um.Updated_At 
    FROM Movies m 
    JOIN User_Movies um ON m.Movie_ID = um.M_MovieID 
    WHERE um.M_UserID = :user_id 
    ORDER BY um.Updated_At DESC 
    LIMIT 6
");
$database->bind(':user_id', $user_id);
$recentMovies = $database->resultset();

// Get recent reviews
$database->query("
    SELECT r.*, m.Title, m.Poster_URL 
    FROM Reviews r 
    JOIN Movies m ON r.R_MovieID = m.Movie_ID 
    WHERE r.R_UserID = :user_id 
    ORDER BY r.Review_Date DESC 
    LIMIT 3
");
$database->bind(':user_id', $user_id);
$recentReviews = $database->resultset();

include '../includes/header.php';
?>

<div class="dashboard-container">
    <div class="container py-5">
        <!-- Welcome Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="welcome-title">
                                <i class="fas fa-film me-3"></i>Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </h1>
                            <p class="welcome-subtitle">Ready to discover your next favorite movie?</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a href="movies.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Add Movie
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-5">
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon watched">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $watchedMovies; ?></h3>
                        <p class="stat-label">Movies Watched</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon to-watch">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $toWatchMovies; ?></h3>
                        <p class="stat-label">To Watch</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon reviews">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $totalReviews; ?></h3>
                        <p class="stat-label">Reviews Written</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon wishlist">
                        <i class="fas fa-bookmark"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number"><?php echo $wishlistCount; ?></h3>
                        <p class="stat-label">Wishlist Items</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Movies -->
            <div class="col-lg-8 mb-5">
                <div class="section-card">
                    <div class="section-header">
                        <h3><i class="fas fa-history me-2"></i>Recent Activity</h3>
                        <a href="movies.php" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                    
                    <?php if (!empty($recentMovies)): ?>
                        <div class="recent-movies">
                            <?php foreach ($recentMovies as $movie): ?>
                                <div class="recent-movie-item">
                                    <div class="movie-poster-small" style="background-image: url('<?php echo $movie->Poster_URL ?: 'https://via.placeholder.com/100x150/333/fff?text=No+Image'; ?>');">
                                    </div>
                                    <div class="movie-info">
                                        <h5><?php echo htmlspecialchars($movie->Title); ?></h5>
                                        <p class="text-muted"><?php echo $movie->Release_year; ?></p>
                                        <span class="status-badge status-<?php echo $movie->Watched_Status; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $movie->Watched_Status)); ?>
                                        </span>
                                    </div>
                                    <div class="movie-actions">
                                        <a href="movie-details.php?id=<?php echo $movie->Movie_ID; ?>" class="btn btn-sm btn-outline-light">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-film"></i>
                            <h5>No movies yet</h5>
                            <p>Start by adding your first movie!</p>
                            <a href="movies.php" class="btn btn-primary">Browse Movies</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="col-lg-4 mb-5">
                <div class="section-card">
                    <div class="section-header">
                        <h3><i class="fas fa-comment me-2"></i>Recent Reviews</h3>
                        <a href="reviews.php" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                    
                    <?php if (!empty($recentReviews)): ?>
                        <div class="recent-reviews">
                            <?php foreach ($recentReviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-movie">
                                        <img src="<?php echo $review->Poster_URL ?: 'https://via.placeholder.com/50x75/333/fff?text=No+Image'; ?>" alt="<?php echo htmlspecialchars($review->Title); ?>">
                                        <div>
                                            <h6><?php echo htmlspecialchars($review->Title); ?></h6>
                                            <small class="text-muted"><?php echo date('M j, Y', strtotime($review->Review_Date)); ?></small>
                                        </div>
                                    </div>
                                    <p class="review-text"><?php echo htmlspecialchars(substr($review->Review_txt, 0, 100)) . '...'; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-star"></i>
                            <h6>No reviews yet</h6>
                            <p>Share your thoughts on movies!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="quick-actions">
                    <h4 class="mb-4"><i class="fas fa-bolt me-2"></i>Quick Actions</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="movies.php" class="action-card">
                                <i class="fas fa-video"></i>
                                <span>Browse Movies</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="watchlist.php" class="action-card">
                                <i class="fas fa-bookmark"></i>
                                <span>My Watchlist</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="reviews.php" class="action-card">
                                <i class="fas fa-star"></i>
                                <span>My Reviews</span>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="profile.php" class="action-card">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-container {
    background-color: var(--dark-bg);
    min-height: 100vh;
    color: var(--text-light);
}

.welcome-card {
    background: linear-gradient(135deg, var(--primary-color), #ff4757);
    padding: 2rem;
    border-radius: 20px;
    color: white;
    box-shadow: 0 10px 30px rgba(229, 9, 20, 0.3);
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin: 0;
}

.stat-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
}

.stat-icon.watched { background-color: rgba(40, 167, 69, 0.2); color: #28a745; }
.stat-icon.to-watch { background-color: rgba(255, 193, 7, 0.2); color: #ffc107; }
.stat-icon.reviews { background-color: rgba(229, 9, 20, 0.2); color: var(--primary-color); }
.stat-icon.wishlist { background-color: rgba(108, 117, 125, 0.2); color: #6c757d; }

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-light);
    margin: 0;
}

.stat-label {
    color: var(--text-muted);
    margin: 0;
    font-size: 0.9rem;
}

.section-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    padding: 1.5rem;
    height: 100%;
}

.section-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.section-header h3 {
    margin: 0;
    color: var(--text-light);
}

.recent-movie-item {
    display: flex;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.recent-movie-item:last-child {
    border-bottom: none;
}

.movie-poster-small {
    width: 60px;
    height: 90px;
    background-size: cover;
    background-position: center;
    border-radius: 8px;
    margin-right: 1rem;
    flex-shrink: 0;
}

.movie-info {
    flex-grow: 1;
}

.movie-info h5 {
    margin: 0 0 0.25rem 0;
    color: var(--text-light);
    font-size: 1rem;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    text-transform: uppercase;
    font-weight: 600;
}

.status-watched { background-color: rgba(40, 167, 69, 0.2); color: #28a745; }
.status-to_watch { background-color: rgba(255, 193, 7, 0.2); color: #ffc107; }
.status-watching { background-color: rgba(0, 123, 255, 0.2); color: #007bff; }

.review-item {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.review-item:last-child {
    border-bottom: none;
}

.review-movie {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.review-movie img {
    width: 40px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
    margin-right: 0.75rem;
}

.review-movie h6 {
    margin: 0;
    color: var(--text-light);
    font-size: 0.9rem;
}

.review-text {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.4;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.quick-actions {
    margin-top: 2rem;
}

.action-card {
    display: block;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    text-decoration: none;
    color: var(--text-light);
    transition: all 0.3s ease;
}

.action-card:hover {
    color: var(--text-light);
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

.action-card i {
    font-size: 2rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    display: block;
}

.action-card span {
    font-weight: 500;
}

@media (max-width: 768px) {
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .section-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>

<?php include '../includes/footer.php'; ?>