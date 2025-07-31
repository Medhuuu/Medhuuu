-- 1. Create database & use it
CREATE DATABASE IF NOT EXISTS CineLog;
USE CineLog;

-- 2. USER Table
CREATE TABLE User (
    User_ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE
);

-- 3. Movies Table
CREATE TABLE Movies (
    Movie_ID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Release_year INT,
    Description TEXT,
    Poster_URL VARCHAR(255),
    Avg_Rating DECIMAL(3,2) NOT NULL DEFAULT 0.00
);

-- 4. Genre Table
CREATE TABLE Genre (
    Genre_ID INT AUTO_INCREMENT PRIMARY KEY,
    G_Name VARCHAR(100) NOT NULL UNIQUE
);

-- 5. Moods Table
CREATE TABLE Moods (
    Mood_ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL UNIQUE
);

-- 6. Language Table
CREATE TABLE Language (
    LanguageID INT AUTO_INCREMENT PRIMARY KEY,
    L_Name VARCHAR(50) NOT NULL UNIQUE
);

-- 7. Actors Table
CREATE TABLE Actors (
    Actor_ID INT AUTO_INCREMENT PRIMARY KEY,
    A_Name VARCHAR(100) NOT NULL,
    Birth_year YEAR,
    Nationality VARCHAR(50)
);

-- 8. Reviews Table
CREATE TABLE Reviews (
    Review_ID INT AUTO_INCREMENT PRIMARY KEY,
    R_UserID INT NOT NULL,
    R_MovieID INT NOT NULL,
    Review_txt TEXT,
    Review_Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (R_UserID) REFERENCES User(User_ID) ON DELETE CASCADE,
    FOREIGN KEY (R_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 9. Rating Table
CREATE TABLE Rating (
    Rating_ID INT AUTO_INCREMENT PRIMARY KEY,
    R_UserID INT NOT NULL,
    R_MovieID INT NOT NULL,
    Score DECIMAL(2,1) CHECK (Score >= 0 AND Score <= 10),
    FOREIGN KEY (R_UserID) REFERENCES User(User_ID) ON DELETE CASCADE,
    FOREIGN KEY (R_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 10. User_Movies Table
CREATE TABLE User_Movies (
    M_UserID INT NOT NULL,
    M_MovieID INT NOT NULL,
    Watched_Status VARCHAR(20),
    Updated_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (M_UserID, M_MovieID),
    FOREIGN KEY (M_UserID) REFERENCES User(User_ID) ON DELETE CASCADE,
    FOREIGN KEY (M_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 11. Wishlist Table
CREATE TABLE Wishlist (
    List_ID INT AUTO_INCREMENT PRIMARY KEY,
    W_UserID INT NOT NULL,
    W_MovieID INT NOT NULL,
    Priority VARCHAR(20),
    FOREIGN KEY (W_UserID) REFERENCES User(User_ID) ON DELETE CASCADE,
    FOREIGN KEY (W_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 12. To_be_watched Table
CREATE TABLE To_be_watched (
    MovieID INT NOT NULL,
    ListID INT NOT NULL,
    UserID INT NOT NULL,
    PRIMARY KEY (MovieID, ListID, UserID),
    FOREIGN KEY (MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE,
    FOREIGN KEY (ListID) REFERENCES Wishlist(List_ID) ON DELETE CASCADE,
    FOREIGN KEY (UserID) REFERENCES User(User_ID) ON DELETE CASCADE
);

-- 13. Movie_Genre Table (M:N)
CREATE TABLE Movie_Genre (
    G_GenreID INT NOT NULL,
    G_MovieID INT NOT NULL,
    PRIMARY KEY (G_GenreID, G_MovieID),
    FOREIGN KEY (G_GenreID) REFERENCES Genre(Genre_ID) ON DELETE CASCADE,
    FOREIGN KEY (G_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 14. Movie_Moods Table (M:N)
CREATE TABLE Movie_Moods (
    M_MoodID INT NOT NULL,
    M_MovieID INT NOT NULL,
    PRIMARY KEY (M_MoodID, M_MovieID),
    FOREIGN KEY (M_MoodID) REFERENCES Moods(Mood_ID) ON DELETE CASCADE,
    FOREIGN KEY (M_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 15. Movie_Language Table (M:N)
CREATE TABLE Movie_Language (
    M_LanguageID INT NOT NULL,
    L_MovieID INT NOT NULL,
    PRIMARY KEY (M_LanguageID, L_MovieID),
    FOREIGN KEY (M_LanguageID) REFERENCES Language(LanguageID) ON DELETE CASCADE,
    FOREIGN KEY (L_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- 16. Acts_in Table (Actors in Movies)
CREATE TABLE Acts_in (
    A_ActorID INT NOT NULL,
    A_MovieID INT NOT NULL,
    PRIMARY KEY (A_ActorID, A_MovieID),
    FOREIGN KEY (A_ActorID) REFERENCES Actors(Actor_ID) ON DELETE CASCADE,
    FOREIGN KEY (A_MovieID) REFERENCES Movies(Movie_ID) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO Language (L_Name) VALUES 
('English'), ('Spanish'), ('French'), ('German'), ('Italian'), ('Japanese'), ('Korean'), ('Mandarin');

INSERT INTO Genre (G_Name) VALUES 
('Action'), ('Comedy'), ('Drama'), ('Horror'), ('Romance'), ('Sci-Fi'), ('Thriller'), ('Adventure'), ('Animation'), ('Documentary');

INSERT INTO Moods (Name) VALUES 
('Exciting'), ('Relaxing'), ('Intense'), ('Romantic'), ('Dark'), ('Uplifting'), ('Mysterious'), ('Funny');

INSERT INTO Actors (A_Name, Birth_year, Nationality) VALUES 
('Leonardo DiCaprio', 1974, 'American'),
('Margot Robbie', 1990, 'Australian'),
('Tom Hanks', 1956, 'American'),
('Scarlett Johansson', 1984, 'American'),
('Ryan Gosling', 1980, 'Canadian');

INSERT INTO Movies (Title, Release_year, Description, Poster_URL) VALUES 
('The Wolf of Wall Street', 2013, 'The story of Jordan Belfort, from his rise to a wealthy stock-broker living the high life to his fall involving crime, corruption and the federal government.', 'https://image.tmdb.org/t/p/w500/34m2tygAYBGqA9MXKhRDtzYd4MR.jpg'),
('La La Land', 2016, 'A jazz musician and an aspiring actress meet and fall in love in Los Angeles while pursuing their dreams.', 'https://image.tmdb.org/t/p/w500/uDO8zWDhfWwoFdKS4fzkUJt0Rf0.jpg'),
('Forrest Gump', 1994, 'The presidencies of Kennedy and Johnson, the events of Vietnam, Watergate and other historical events unfold from the perspective of an Alabama man.', 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg'),
('Lost in Translation', 2003, 'A faded movie star and a neglected young woman form an unlikely bond after crossing paths in Tokyo.', 'https://image.tmdb.org/t/p/w500/wuUZeUcQiQx7pzHDjeTiIA0tnXy.jpg'),
('Drive', 2011, 'A mysterious Hollywood stuntman and mechanic moonlights as a getaway driver and finds himself in trouble when he helps out his neighbor.', 'https://image.tmdb.org/t/p/w500/602vevIURmpDfzbnv5Ubi6wIkQm.jpg');