<!DOCTYPE html>
<html>
<head>
    <title>Library Book Entry and Search</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Enter Book Details</h2>
    <form method="post" action="book_form.php">
        <label>Accession Number:</label><br>
        <input type="number" name="accession_no" required><br>

        <label>Title:</label><br>
        <input type="text" name="title" required><br>

        <label>Authors:</label><br>
        <input type="text" name="authors" required><br>

        <label>Edition:</label><br>
        <input type="text" name="edition" required><br>

        <label>Publisher:</label><br>
        <input type="text" name="publisher" required><br><br>

        <input type="submit" name="submit" value="Add Book">
    </form>

    <hr>

    <h2>Search Book by Title</h2>
    <form method="get" action="book_form.php">
        <label>Enter Title:</label><br>
        <input type="text" name="search_title" required><br><br>
        <input type="submit" name="search" value="Search Book">
    </form>

    <?php
    // MySQL connection setup
    $conn = new mysqli("localhost", "root", "", "library");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Add book to database
    if (isset($_POST['submit'])) {
        $accession_no = $_POST['accession_no'];
        $title = $_POST['title'];
        $authors = $_POST['authors'];
        $edition = $_POST['edition'];
        $publisher = $_POST['publisher'];

        $stmt = $conn->prepare("INSERT INTO books (accession_no, title, authors, edition, publisher) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $accession_no, $title, $authors, $edition, $publisher);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Book added successfully!</p>";
        } else {
            if ($conn->errno == 1062) {
                // Error code 1062 = Duplicate entry for unique key
                echo "<p style='color: red;'>Error: A book with Accession No <strong>$accession_no</strong> already exists.</p>";
            } else {
                echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
            }
        }
        

        $stmt->close();
    }

    // Search book by title
    if (isset($_GET['search'])) {
        $search_title = $conn->real_escape_string($_GET['search_title']);
        $query = "SELECT * FROM books WHERE title LIKE '%$search_title%'";
        $result = $conn->query($query);

        echo "<h3>Search Results:</h3>";

        if ($result->num_rows > 0) {
            echo "<table border='1' cellpadding='10'>
                    <tr>
                        <th>Accession No</th>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Edition</th>
                        <th>Publisher</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['accession_no']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['authors']}</td>
                        <td>{$row['edition']}</td>
                        <td>{$row['publisher']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No book found with the title '$search_title'.</p>";
        }
    }

    $conn->close();
    ?>
</body>
</html>
