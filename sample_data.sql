-- Sample data for CineLog database
USE CineLog;

-- Insert sample genres
INSERT INTO Genre (G_Name) VALUES 
('Action'), ('Adventure'), ('Animation'), ('Biography'), ('Comedy'), 
('Crime'), ('Documentary'), ('Drama'), ('Family'), ('Fantasy'), 
('History'), ('Horror'), ('Music'), ('Mystery'), ('Romance'), 
('Sci-Fi'), ('Sport'), ('Thriller'), ('War'), ('Western');

-- Insert sample moods
INSERT INTO Moods (Name) VALUES 
('Exciting'), ('Relaxing'), ('Intense'), ('Romantic'), ('Dark'), 
('Uplifting'), ('Mysterious'), ('Funny'), ('Emotional'), ('Thrilling'),
('Inspiring'), ('Nostalgic'), ('Epic'), ('Cozy'), ('Suspenseful');

-- Insert sample languages
INSERT INTO Language (L_Name) VALUES 
('English'), ('Spanish'), ('French'), ('German'), ('Italian'), 
('Japanese'), ('Korean'), ('Mandarin'), ('Hindi'), ('Portuguese'),
('Russian'), ('Arabic'), ('Dutch'), ('Swedish'), ('Norwegian');

-- Insert sample actors
INSERT INTO Actors (A_Name, Birth_year, Nationality) VALUES 
('Leonardo DiCaprio', 1974, 'American'),
('Margot Robbie', 1990, 'Australian'),
('Tom Hanks', 1956, 'American'),
('Scarlett Johansson', 1984, 'American'),
('Ryan Gosling', 1980, 'Canadian'),
('Emma Stone', 1988, 'American'),
('Christian Bale', 1974, 'British'),
('Natalie Portman', 1981, 'Israeli-American'),
('Brad Pitt', 1963, 'American'),
('Cate Blanchett', 1969, 'Australian'),
('Morgan Freeman', 1937, 'American'),
('Meryl Streep', 1949, 'American'),
('Robert De Niro', 1943, 'American'),
('Al Pacino', 1940, 'American'),
('Joaquin Phoenix', 1974, 'American');

-- Insert sample movies
INSERT INTO Movies (Title, Release_year, Description, Poster_URL, Avg_Rating) VALUES 
('The Wolf of Wall Street', 2013, 'The story of Jordan Belfort, from his rise to a wealthy stock-broker living the high life to his fall involving crime, corruption and the federal government.', 'https://image.tmdb.org/t/p/w500/34m2tygAYBGqA9MXKhRDtzYd4MR.jpg', 8.2),
('La La Land', 2016, 'A jazz musician and an aspiring actress meet and fall in love in Los Angeles while pursuing their dreams.', 'https://image.tmdb.org/t/p/w500/uDO8zWDhfWwoFdKS4fzkUJt0Rf0.jpg', 8.0),
('Forrest Gump', 1994, 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate and other historical events unfold from the perspective of an Alabama man with an IQ of 75.', 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg', 8.8),
('Lost in Translation', 2003, 'A faded movie star and a neglected young woman form an unlikely bond after crossing paths in Tokyo.', 'https://image.tmdb.org/t/p/w500/wuUZeUcQiQx7pzHDjeTiIA0tnXy.jpg', 7.7),
('Drive', 2011, 'A mysterious Hollywood stuntman and mechanic moonlights as a getaway driver and finds himself in trouble when he helps out his neighbor.', 'https://image.tmdb.org/t/p/w500/602vevIURmpDfzbnv5Ubi6wIkQm.jpg', 7.8),
('Inception', 2010, 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg', 8.8),
('The Dark Knight', 2008, 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests.', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 9.0),
('Pulp Fiction', 1994, 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg', 8.9),
('The Shawshank Redemption', 1994, 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg', 9.3),
('Black Swan', 2010, 'A committed dancer struggles to maintain her sanity after winning the lead role in a production of Tchaikovsky\'s "Swan Lake".', 'https://image.tmdb.org/t/p/w500/rH19vxjOTcZTdqh9ZACRNyP5hm1.jpg', 8.0),
('Joker', 2019, 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.', 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg', 8.4),
('Fight Club', 1999, 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into an anarchist organization.', 'https://image.tmdb.org/t/p/w500/pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg', 8.8);

-- Link movies with genres
INSERT INTO Movie_Genre (G_GenreID, G_MovieID) VALUES 
-- The Wolf of Wall Street (1) - Biography, Comedy, Crime
(4, 1), (5, 1), (6, 1),
-- La La Land (2) - Comedy, Drama, Music, Romance
(5, 2), (8, 2), (13, 2), (15, 2),
-- Forrest Gump (3) - Drama, Romance
(8, 3), (15, 3),
-- Lost in Translation (4) - Comedy, Drama
(5, 4), (8, 4),
-- Drive (5) - Action, Crime, Drama
(1, 5), (6, 5), (8, 5),
-- Inception (6) - Action, Sci-Fi, Thriller
(1, 6), (16, 6), (18, 6),
-- The Dark Knight (7) - Action, Crime, Drama
(1, 7), (6, 7), (8, 7),
-- Pulp Fiction (8) - Crime, Drama
(6, 8), (8, 8),
-- The Shawshank Redemption (9) - Drama
(8, 9),
-- Black Swan (10) - Drama, Thriller
(8, 10), (18, 10),
-- Joker (11) - Crime, Drama, Thriller
(6, 11), (8, 11), (18, 11),
-- Fight Club (12) - Drama
(8, 12);

-- Link movies with moods
INSERT INTO Movie_Moods (M_MoodID, M_MovieID) VALUES 
-- The Wolf of Wall Street - Exciting, Dark
(1, 1), (5, 1),
-- La La Land - Romantic, Uplifting, Emotional
(4, 2), (6, 2), (9, 2),
-- Forrest Gump - Uplifting, Emotional, Inspiring
(6, 3), (9, 3), (11, 3),
-- Lost in Translation - Relaxing, Emotional, Nostalgic
(2, 4), (9, 4), (12, 4),
-- Drive - Intense, Dark, Thrilling
(3, 5), (5, 5), (10, 5),
-- Inception - Intense, Thrilling, Suspenseful
(3, 6), (10, 6), (15, 6),
-- The Dark Knight - Intense, Dark, Thrilling
(3, 7), (5, 7), (10, 7),
-- Pulp Fiction - Intense, Dark, Exciting
(3, 8), (5, 8), (1, 8),
-- The Shawshank Redemption - Uplifting, Inspiring, Emotional
(6, 9), (11, 9), (9, 9),
-- Black Swan - Intense, Dark, Emotional
(3, 10), (5, 10), (9, 10),
-- Joker - Dark, Intense, Emotional
(5, 11), (3, 11), (9, 11),
-- Fight Club - Dark, Intense, Thrilling
(5, 12), (3, 12), (10, 12);

-- Link movies with languages (most are English, some have multiple)
INSERT INTO Movie_Language (M_LanguageID, L_MovieID) VALUES 
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11), (1, 12),
-- Lost in Translation also has Japanese
(6, 4);

-- Link actors with movies
INSERT INTO Acts_in (A_ActorID, A_MovieID) VALUES 
-- The Wolf of Wall Street
(1, 1), (2, 1),
-- La La Land
(5, 2), (6, 2),
-- Forrest Gump
(3, 3),
-- Lost in Translation
(4, 4),
-- Drive
(5, 5),
-- Inception
(1, 6),
-- The Dark Knight
(7, 7),
-- Black Swan
(8, 10),
-- Joker
(15, 11),
-- The Shawshank Redemption
(11, 9);

-- Insert sample users (passwords would be hashed in real application)
INSERT INTO User (Username, Password, Email) VALUES 
('moviebuff', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'moviebuff@example.com'),
('cinephile', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cinephile@example.com'),
('filmcritic', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'filmcritic@example.com');

-- Insert sample reviews
INSERT INTO Reviews (R_UserID, R_MovieID, Review_txt) VALUES 
(1, 1, 'Absolutely incredible performance by Leonardo DiCaprio. Scorsese at his finest!'),
(2, 2, 'A beautiful love letter to Los Angeles and jazz. The cinematography is stunning.'),
(3, 3, 'Tom Hanks delivers one of his best performances. A truly heartwarming story.'),
(1, 6, 'Mind-bending and visually spectacular. Nolan creates a masterpiece of sci-fi cinema.'),
(2, 7, 'Heath Ledger\'s Joker is absolutely terrifying and captivating. A superhero movie for the ages.'),
(3, 9, 'Hope and friendship have never been portrayed so beautifully on screen.');

-- Insert sample ratings
INSERT INTO Rating (R_UserID, R_MovieID, Score) VALUES 
(1, 1, 8.5), (1, 6, 9.0), (1, 7, 9.2),
(2, 2, 8.0), (2, 7, 8.8), (2, 10, 7.5),
(3, 3, 9.0), (3, 9, 9.5), (3, 11, 8.0);

-- Insert sample user movie tracking
INSERT INTO User_Movies (M_UserID, M_MovieID, Watched_Status) VALUES 
(1, 1, 'watched'), (1, 6, 'watched'), (1, 7, 'watched'), (1, 2, 'to_watch'),
(2, 2, 'watched'), (2, 7, 'watched'), (2, 10, 'watched'), (2, 3, 'watching'),
(3, 3, 'watched'), (3, 9, 'watched'), (3, 11, 'watched'), (3, 1, 'to_watch');

-- Insert sample wishlist items
INSERT INTO Wishlist (W_UserID, W_MovieID, Priority) VALUES 
(1, 2, 'High'), (1, 8, 'Medium'), (1, 12, 'Low'),
(2, 3, 'High'), (2, 5, 'Medium'),
(3, 1, 'High'), (3, 4, 'Medium'), (3, 6, 'High');