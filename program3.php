<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Cricket Players</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            text-align: center;
            margin: 20px;
        }
        input, button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Indian Cricket Players</h2>

<form method="post">
    <input type="text" name="player" placeholder="Enter player name" required>
    <button type="submit">Add Player</button>
</form>

<?php
session_start();

// Initialize players array if not set
if (!isset($_SESSION['players'])) {
    $_SESSION['players'] = [];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['player'])) {
    $player_name = trim($_POST['player']);
    if (!empty($player_name)) {
        $_SESSION['players'][] = $player_name; // Store player in session
    }
}

// Display table if there are players
if (!empty($_SESSION['players'])) {
    echo "<table>";
    echo "<tr><th>#</th><th>Player Name</th></tr>";

    foreach ($_SESSION['players'] as $index => $player) {
        echo "<tr><td>" . ($index + 1) . "</td><td>$player</td></tr>";
    }

    echo "</table>";
}
?>

</body>
</html>
