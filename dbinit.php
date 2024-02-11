<?php
// Define database connection constants
define('DB_USER', 'root');
define('DB_PASSWORD', 'Nonaphu2');
define('DB_HOST', 'localhost');
define('DB_NAME', 'shoes_ecommerce');

// Establish database connection
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');

// Check if prepare_string() function is not already defined
if (!function_exists('prepare_string')) {
    // Function to prepare string
    function prepare_string($dbc, $string) {
        $string_trimmed = trim($string);
        $string = mysqli_real_escape_string($dbc, $string_trimmed);
        return $string;
    }
}

// Create the database if it doesn't exist
$sql_create_db = "CREATE DATABASE IF NOT EXISTS shoes_ecommerce";
if (!mysqli_query($dbc, $sql_create_db)) {
    echo "Error creating database: " . mysqli_error($dbc);
}


mysqli_select_db($dbc, DB_NAME);


$sql_create_table = "
CREATE TABLE IF NOT EXISTS shoes (
  shoeID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  shoeName VARCHAR(100) NOT NULL,
  Description VARCHAR(255) NOT NULL,
  Brand varchar(50) NOT NULL,
  QuantityAvailable INT NOT NULL,
  Price DECIMAL(10, 2) NOT NULL,
  ProductAddedBy VARCHAR(100) NOT NULL DEFAULT 'Rachna Shukla',
  PRIMARY KEY (shoeID)
)";

?>
