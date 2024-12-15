<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['matric'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];
            header("Location: users.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid matric number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Login</h2>
    <form method="post">
        Matric: <input type="text" name="matric" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>
</body>
</html>
