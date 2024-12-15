<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

$matric = $_GET['matric'];

$sql = "SELECT * FROM users WHERE matric = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET name = ?, role = ? WHERE matric = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $name, $role, $matric);
    $update_stmt->execute();

    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Update User</h2>
    <form method="post">
        Matric: <input type="text" name="matric" value="<?php echo $user['matric']; ?>" disabled><br>
        Name: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        Access Level: 
        <select name="role">
            <option value="lecturer" <?php if ($user['role'] == 'lecturer') echo 'selected'; ?>>Lecturer</option>
            <option value="student" <?php if ($user['role'] == 'student') echo 'selected'; ?>>Student</option>
        </select><br>
        <button type="submit">Update</button>
    </form>
    <a href="users.php">Cancel</a>
</body>
</html>
