-- Create 'users' table with profile picture field
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    pfp VARCHAR(255),                               -- Profile picture filename or path
    rank ENUM('user', 'admin') DEFAULT 'user',      -- User rank
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'tbl_product' table
CREATE TABLE tbl_product (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each product
    name VARCHAR(255) NOT NULL,              -- Name of the product
    image VARCHAR(255) NOT NULL,             -- Image filename or path
    price DECIMAL(10, 2) NOT NULL,           -- Price of the product
    sizes VARCHAR(255),                      -- Sizes available
    description TEXT,                        -- Product description (optional)
    stock INT DEFAULT 0,                     -- Number of items in stock
    category VARCHAR(100)                    -- Category of the product (optional)
);

-- Create 'issues' table
CREATE TABLE issues (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each issue
    username VARCHAR(255) NOT NULL,         -- Username of the user who created the issue
    title VARCHAR(255) NOT NULL,             -- Title of the issue
    description TEXT NOT NULL,               -- Description of the issue
    image VARCHAR(255),                       -- Image associated with the issue
    date DATE NOT NULL,                       -- Date the issue was created
    solved TINYINT(1) DEFAULT 0,             -- Status of the issue (0 for open, 1 for solved)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Automatically set creation timestamp
);

-- Create 'reviews' table
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    stars INT CHECK (stars >= 1 AND stars <= 5) -- Stars must be between 1 and 5
);

-- Create 'comments' table
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,      -- Unique identifier for each comment
    username VARCHAR(255) NOT NULL,         -- Username of the commenter
    solution TEXT NOT NULL,                  -- Content of the comment
    date DATE NOT NULL,                      -- Date the comment was made
    issueid INT NOT NULL,                   -- Foreign key referencing the issue
    FOREIGN KEY (issueid) REFERENCES issues(id) ON DELETE CASCADE -- Ensures referential integrity
);

