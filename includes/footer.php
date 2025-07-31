    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold">
                        <i class="fas fa-film me-2"></i>CineLog
                    </h5>
                    <p class="text-muted">Your personal movie journal. Track, rate, and review your favorite films.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted text-decoration-none">Home</a></li>
                        <li><a href="pages/movies.php" class="text-muted text-decoration-none">Movies</a></li>
                        <li><a href="pages/watchlist.php" class="text-muted text-decoration-none">Watchlist</a></li>
                        <li><a href="pages/reviews.php" class="text-muted text-decoration-none">Reviews</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Categories</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Action</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Comedy</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Drama</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Sci-Fi</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold">Newsletter</h6>
                    <p class="text-muted small">Subscribe to get updates on new features and movie recommendations.</p>
                    <form method="POST" action="">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email" name="newsletter_email" required>
                            <button class="btn btn-primary" type="submit" name="newsletter_submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <?php if (isset($_POST['newsletter_submit'])): ?>
                            <small class="text-success mt-2 d-block">
                                <i class="fas fa-check me-1"></i>Thank you for subscribing!
                            </small>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted small mb-0">
                        &copy; <?php echo date('Y'); ?> CineLog. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-muted text-decoration-none small me-3">Privacy Policy</a>
                    <a href="#" class="text-muted text-decoration-none small">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS for basic functionality only (dropdowns, mobile menu) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>