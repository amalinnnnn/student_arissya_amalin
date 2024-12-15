<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for database connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    

    // Check if the matric ID already exists in the database (except for IDs 1 and 2)
    if ($matric == 1 || $matric == 2) {
        $error = "The matric ID 1 and 2 are reserved and cannot be used.";
    } else {
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Matric number already exists.";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO users (matric, name, role, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $matric, $name, $role, $hashedPassword);

            if ($stmt->execute()) {
                $success = "User registered successfully!";
            } else {
                $error = "Error registering user. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <!-- Display success or error message -->
    <?php
    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <!-- Registration Form -->
    <form method="post">
        Matric: <input type="text" name="matric" required><br>
        Name: <input type="text" name="name" required><br>
        Password: <input type="password" name="password" required><br>
        Role: 
        <select name="role" required>
            <option value="Student">Student</option>
            <option value="Lecturer">Lecturer</option>
        </select><br>
        <button type="submit">Register</button>
    </form>

    <p><a href="login.php">Already have an account? Login here</a></p>
</body>
</html>
