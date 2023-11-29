CREATE TABLE users (
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    rcsid VARCHAR(10) PRIMARY KEY,
    FOREIGN KEY (rcsid) REFERENCES account_details(rcsid)
);