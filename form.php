<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Test</title>
</head>
<body>
    <h2>Student Form</h2>

    <form method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="roll">Roll Number:</label><br>
        <input type="text" id="roll" name="roll" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $roll = htmlspecialchars($_POST['roll']);

        echo "<h3>Form Submitted Successfully</h3>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Roll Number:</strong> $roll</p>";
    }
    ?>
</body>
</html>