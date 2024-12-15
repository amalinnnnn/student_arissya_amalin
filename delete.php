<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the matric number of the user to be deleted
$matric = $_GET['matric'];

// Check if matric is set (for security reasons)
if (isset($matric)) {
    // Prepare SQL query to delete the user from the database
    $sql = "DELETE FROM users WHERE matric = ?";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    
    // Execute the query
    if ($stmt->execute()) {
        // Redirect to users page after successful deletion
        header("Location: users.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Redirect to users page if matric is not set
    header("Location: users.php");
    exit();
}

// Close connection
$conn->close();
?>
