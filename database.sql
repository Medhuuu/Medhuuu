-- Create database
CREATE DATABASE IF NOT EXISTS cinelog;
USE cinelog;

-- User table
CREATE TABLE IF NOT EXISTS USER (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Language table
CREATE TABLE IF NOT EXISTS Language (
    LanguageID INT AUTO_INCREMENT PRIMARY KEY,
    L_Name VARCHAR(50) NOT NULL
);

-- Genre table
CREATE TABLE IF NOT EXISTS Genre (
    GenreID INT AUTO_INCREMENT PRIMARY KEY,
    G_Name VARCHAR(50) NOT NULL
);

-- Actors table
CREATE TABLE IF NOT EXISTS Actors (
    ActorID INT AUTO_INCREMENT PRIMARY KEY,
    A_Name VARCHAR(100) NOT NULL,
    Birth_year YEAR,
    Nationality VARCHAR(50)
);

-- Movies table
CREATE TABLE IF NOT EXISTS Movies (
    MovieID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(200) NOT NULL,
    Release_year YEAR,
    Description TEXT,
    Poster_URL VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Movie_Language junction table
CREATE TABLE IF NOT EXISTS Movie_Language (
    M_LanguageID INT,
    L_MovieID INT,
    PRIMARY KEY (M_LanguageID, L_MovieID),
    FOREIGN KEY (M_LanguageID) REFERENCES Language(LanguageID),
    FOREIGN KEY (L_MovieID) REFERENCES Movies(MovieID)
);

-- Movie_Genre junction table
CREATE TABLE IF NOT EXISTS Movie_Genre (
    G_GenreID INT,
    G_MovieID INT,
    PRIMARY KEY (G_GenreID, G_MovieID),
    FOREIGN KEY (G_GenreID) REFERENCES Genre(GenreID),
    FOREIGN KEY (G_MovieID) REFERENCES Movies(MovieID)
);

-- Acts_in junction table
CREATE TABLE IF NOT EXISTS Acts_in (
    A_ActorID INT,
    A_MovieID INT,
    PRIMARY KEY (A_ActorID, A_MovieID),
    FOREIGN KEY (A_ActorID) REFERENCES Actors(ActorID),
    FOREIGN KEY (A_MovieID) REFERENCES Movies(MovieID)
);

-- Moods table
CREATE TABLE IF NOT EXISTS Moods (
    MoodID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(50) NOT NULL
);

-- Movie_Moods junction table
CREATE TABLE IF NOT EXISTS Movie_Moods (
    M_MoodID INT,
    M_MovieID INT,
    PRIMARY KEY (M_MoodID, M_MovieID),
    FOREIGN KEY (M_MoodID) REFERENCES Moods(MoodID),
    FOREIGN KEY (M_MovieID) REFERENCES Movies(MovieID)
);

-- Reviews table
CREATE TABLE IF NOT EXISTS Reviews (
    Review_ID INT AUTO_INCREMENT PRIMARY KEY,
    R_UserID INT,
    R_MovieID INT,
    Review_txt TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (R_UserID) REFERENCES USER(UserID),
    FOREIGN KEY (R_MovieID) REFERENCES Movies(MovieID)
);

-- Rating table
CREATE TABLE IF NOT EXISTS Rating (
    Rating_ID INT AUTO_INCREMENT PRIMARY KEY,
    R_UserID INT,
    R_MovieID INT,
    Score DECIMAL(2,1) CHECK (Score >= 0 AND Score <= 10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (R_UserID) REFERENCES USER(UserID),
    FOREIGN KEY (R_MovieID) REFERENCES Movies(MovieID)
);

-- Wishlist table
CREATE TABLE IF NOT EXISTS Wishlist (
    List_ID INT AUTO_INCREMENT PRIMARY KEY,
    W_UserID INT,
    W_MovieID INT,
    Priority INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (W_UserID) REFERENCES USER(UserID),
    FOREIGN KEY (W_MovieID) REFERENCES Movies(MovieID)
);

-- User_Movies table (watched status)
CREATE TABLE IF NOT EXISTS User_Movies (
    M_UserID INT,
    M_MovieID INT,
    Watched_Status ENUM('watched', 'watching', 'to_watch') DEFAULT 'to_watch',
    Date_watched DATE,
    PRIMARY KEY (M_UserID, M_MovieID),
    FOREIGN KEY (M_UserID) REFERENCES USER(UserID),
    FOREIGN KEY (M_MovieID) REFERENCES Movies(MovieID)
);

-- To_be_watched table
CREATE TABLE IF NOT EXISTS To_be_watched (
    Movie_MovieID INT,
    List_ListID INT,
    User_UserID INT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (Movie_MovieID, List_ListID, User_UserID),
    FOREIGN KEY (Movie_MovieID) REFERENCES Movies(MovieID),
    FOREIGN KEY (List_ListID) REFERENCES Wishlist(List_ID),
    FOREIGN KEY (User_UserID) REFERENCES USER(UserID)
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