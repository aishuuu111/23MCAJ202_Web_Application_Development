<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .error { color: red; }
        pre { text-align: left; background: #f4f4f4; padding: 10px; display: inline-block; }
    </style>
</head>
<body>
    <h2>Enter Student Names</h2>
    
    <form method="post">
        <label>Student Name:</label>
        <input type="text" name="student_name">
        <input type="submit" name="submit" value="Add Student">
    </form>

    <?php
    session_start(); // Start session to persist data across reloads

    // Initialize or retrieve student list
    if (!isset($_SESSION["students"])) {
        $_SESSION["students"] = [];
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $student_name = trim($_POST["student_name"]);

        if (!empty($student_name)) {
            $_SESSION["students"][] = htmlspecialchars($student_name);
        } else {
            echo "<p class='error'>Please enter a valid student name.</p>";
        }
    }

    // Display student list if available
    if (!empty($_SESSION["students"])) {
        echo "<h3>Original Student List:</h3>";
        echo "<pre>";
        print_r($_SESSION["students"]);
        echo "</pre>";

        // Sort in ascending order
        $asc_students = $_SESSION["students"];
        asort($asc_students);
        echo "<h3>Sorted in Ascending Order:</h3>";
        echo "<pre>";
        print_r($asc_students);
        echo "</pre>";

        // Sort in descending order
        $desc_students = $_SESSION["students"];
        arsort($desc_students);
        echo "<h3>Sorted in Descending Order:</h3>";
        echo "<pre>";
        print_r($desc_students);
        echo "</pre>";
    }
    ?>

    <form method="post">
        <input type="submit" name="reset" value="Reset List">
    </form>

    <?php
    // Reset session when "Reset List" button is clicked
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset"])) {
        session_destroy();
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit();
    }
    ?>
</body>
</html>
