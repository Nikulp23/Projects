CREATE TABLE Tweets (
    tweet_id INT AUTO_INCREMENT PRIMARY KEY,
    rcsid VARCHAR(10),
    tweet_text VARCHAR(280) NOT NULL,
    image_url VARCHAR(255), -- Optional field for image URL
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rcsid) REFERENCES users(rcsid)
);