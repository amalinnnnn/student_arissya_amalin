<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">User List</h2>
    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
        </tr>
        <?php
        // Database connection
        $servername = "localhost";
        $username = "root"; // Default username for XAMPP
        $password = ""; // Default password for XAMPP
        $dbname = "Lab_5b"; // Replace with your database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to fetch data from the users table
        $sql = "SELECT matric, name, role AS accessLevel FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['matric']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['accessLevel']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='3' style='text-align:center;'>No records found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
