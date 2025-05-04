<?php
// Database connection parameters
$servername = "localhost";
$username = "root";      // default username for XAMPP
$password = "";          // default password is empty
$database = "college";   // name of the database

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select data
$sql = "SELECT id, name, email, course FROM students";
$result = $conn->query($sql);

// Display results
echo "<h2>Student Details</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['course']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No records found.";
}

// Close connection
$conn->close();
?>
