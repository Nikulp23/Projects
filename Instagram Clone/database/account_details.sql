CREATE TABLE account_details (
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(30) NOT NULL,
    rcsid VARCHAR(10) PRIMARY KEY,
    passcode VARCHAR(15) NOT NULL,
    bio VARCHAR(255),
    profile_picture VARCHAR(1000)
);