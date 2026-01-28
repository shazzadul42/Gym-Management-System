<?php
include("./db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        header("Location: ./login.html?error=" . urlencode("Email and password are required."));
        exit();
    }

    // Prepare and execute SQL
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['user_email'] = $user['email'];

            // Redirect to dashboard
            header("Location: ./dashboard1.php");
            exit();
        } else {
            header("Location: ./login.html?error=" . urlencode("Invalid password."));
            exit();
        }
    } else {
        header("Location: ./login.html?error=" . urlencode("No account found with that email."));
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if not POST
    header("Location: ./login.html");
    exit();
}
?>
