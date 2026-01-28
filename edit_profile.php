<?php
session_start();
include("./db.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.html");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch current user info
$sql = "SELECT first_name, last_name, email, phone, profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $email, $phone, $profilePic);
$stmt->fetch();
$stmt->close();

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newFirstName = trim($_POST["first_name"]);
    $newLastName  = trim($_POST["last_name"]);
    $newPhone     = trim($_POST["phone"]);
    $newPassword  = trim($_POST["password"]);

    if (empty($newFirstName) || empty($newLastName) || empty($newPhone)) {
        $message = "All fields except password are required.";
    } else {
        // Upload image
        $uploadDir = __DIR__ . "/uploads/";
        $profilePicPath = $profilePic; // keep old one if not updated

        // Make upload folder if missing
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES["profile_pic"]["tmp_name"];
            $fileName = basename($_FILES["profile_pic"]["name"]);
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowed = ["jpg", "jpeg", "png", "gif"];
            if (in_array($ext, $allowed)) {
                $newFileName = "user_" . $userId . "_" . time() . "." . $ext;
                $targetPath = $uploadDir . $newFileName;
                $dbPath = "uploads/" . $newFileName;

                if (move_uploaded_file($fileTmp, $targetPath)) {
                    $profilePicPath = $dbPath;
                } else {
                    $message = "❌ File move failed. Check PHP permissions for 'uploads' folder.";
                }
            } else {
                $message = "❌ Invalid file type. Only JPG, JPEG, PNG, GIF allowed.";
            }
        }

        // Update DB
        if (empty($message)) {
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE users SET first_name=?, last_name=?, phone=?, password=?, profile_pic=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $newFirstName, $newLastName, $newPhone, $hashedPassword, $profilePicPath, $userId);
            } else {
                $sql = "UPDATE users SET first_name=?, last_name=?, phone=?, profile_pic=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $newFirstName, $newLastName, $newPhone, $profilePicPath, $userId);
            }

            if ($stmt->execute()) {
                $_SESSION['user_name'] = $newFirstName . " " . $newLastName;
                $stmt->close();
                $conn->close();

                header("Location: ./dashboard1.php?updated=1");
                exit();
            } else {
                $message = "❌ Database update failed. Please try again.";
            }
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile | FitnessHub Gym</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./dashboard.css">
    <style>
        .form-container {
            max-width: 550px;
            margin: 50px auto;
            padding: 25px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        form label { display: block; margin: 10px 0 5px; font-weight: bold; }
        form input { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; }
        button {
            margin-top: 15px; padding: 10px 15px;
            border: none; border-radius: 6px;
            background: #2c7ef7; color: #fff; font-size: 16px; cursor: pointer;
        }
        .message { text-align: center; margin: 10px 0; color: red; font-weight: bold; }
        .profile-pic {
            display: block;
            margin: 15px auto;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<header class="dashboard-header">
    <div class="logo">FitnessHub</div>
    <div class="user-info">
        <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <img src="<?php echo htmlspecialchars($profilePic ? $profilePic : './profile_image.jpg'); ?>" class="user-pic">
    </div>
</header>

<div class="form-container">
    <h2>Edit Profile</h2>
    <?php if (!empty($message)) echo "<p class='message'>" . htmlspecialchars($message) . "</p>"; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required>

        <label>Email:</label>
        <input type="email" value="<?php echo htmlspecialchars($email); ?>" readonly>

        <label>Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <label>Profile Picture:</label>
        <img src="<?php echo htmlspecialchars($profilePic ? $profilePic : './profile_image.jpg'); ?>" class="profile-pic">
        <input type="file" name="profile_pic" accept="image/*">

        <label>New Password (leave blank to keep current):</label>
        <input type="password" name="password" placeholder="Enter new password">

        <button type="submit">Update Profile</button>
    </form>
</div>

<footer class="dashboard-footer">
    <p>&copy; 2025 FitnessHub Gym. All rights reserved.</p>
</footer>
</body>
</html>
