<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .error { color: red; }
    </style>
</head>
<body>
    <?php
    $name = $email = $password = "";
    $nameErr = $emailErr = $passwordErr = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate Name (Only letters allowed)
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
            $nameErr = "Only letters and spaces are allowed";
        } else {
            $name = htmlspecialchars($_POST["name"]);
        }

        // Validate Email
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = htmlspecialchars($_POST["email"]);
        }

        // Validate Password
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } elseif (strlen($_POST["password"]) < 6) {
            $passwordErr = "Password must be at least 6 characters long";
        } else {
            $password = htmlspecialchars($_POST["password"]);
        }

        // If no errors, process the registration and clear fields
        if (empty($nameErr) && empty($emailErr) && empty($passwordErr)) {
            echo "<p>Registration Successful!</p>";
            $name = $email = $password = ""; // Clear the form fields
        }
    }
    ?>

    <h2>Registration Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $name; ?>">
        <span class="error"><?php echo $nameErr; ?></span><br><br>

        <label>Email:</label>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $emailErr; ?></span><br><br>

        <label>Password:</label>
        <input type="password" name="password">
        <span class="error"><?php echo $passwordErr; ?></span><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
