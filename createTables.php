<?php

require_once 'db_connection.php';

$conn = databaseConnection();

$query = "
    CREATE TABLE users (
        id INT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        active BOOLEAN DEFAULT 1
    );

    CREATE TABLE posts (
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        active BOOLEAN DEFAULT 1,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
";

// Execute the SQL query
if ($conn->multi_query($query)) {
    echo "Tables created successfully.";
} else {
    echo "Error creating tables: " . $conn->error;
}
