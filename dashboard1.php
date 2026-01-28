<?php
session_start();
include("./db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ./login.html");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user info
$sql = "SELECT first_name, last_name, email, phone, profile_pic FROM users WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$userFullName = htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
$profilePic = !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : './profile_image.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | FitnessHub Gym</title>

<style>
:root {
    --primary: rgb(255, 107, 53);
    --bg: white;
    --card-bg: rgba(255,255,255,0.8);
    --dark-bg: #121212;
    --dark-card: rgba(30,30,30,0.8);
    --text-dark: #222;
    --text-light: #f3f3f3;
}
body {
    font-family: "Poppins", sans-serif;
    margin: 0;
    background: var(--bg);
    color: var(--text-dark);
    transition: background 0.3s, color 0.3s;
}
.dark-mode {
    background: var(--dark-bg);
    color: var(--text-light);
}
.sidebar {
    width: 230px;
    background: var(--card-bg);
    backdrop-filter: blur(15px);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-right: 1px solid rgba(0,0,0,0.1);
    transition: width 0.3s;
}
.sidebar h2 {
    text-align: center;
    margin: 20px 0;
    color: var(--primary);
}
.sidebar ul {
    list-style: none;
    padding: 0;
}
.sidebar ul li {
    margin: 15px 0;
}
.sidebar ul li a {
    color: inherit;
    text-decoration: none;
    padding: 10px 20px;
    display: block;
    border-radius: 8px;
    transition: 0.2s;
}
.sidebar ul li a:hover {
    background: var(--primary);
    color: #fff;
}
.main-content {
    margin-left: 230px;
    padding: 30px;
}
.header {
    
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.header h1 {
    font-size: 24px;
    color: var(--primary);
}
.user-box {
    display: flex;
    align-items: center;
    gap: 10px;
}
.user-box img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 200px;
}
.card {
    background: var(--card-bg);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: center;
}
.card h3 {
    margin-bottom: 10px;
    color: var(--primary);
}
button {
    padding: 10px 15px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
   
}
button:hover { background: #1f5ecf; }

.search-box input {
    padding: 8px 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
}
footer {
    text-align: center;
    margin-top: 40px;
    color: #777;
}

/* Dark Mode Tweaks */
.dark-mode .sidebar,
.dark-mode .card {
    background: var(--dark-card);
}
.dark-mode a:hover {
    background: #1f5ecf;
}




/* Motivation Banner */
.motivation-banner {
  background: linear-gradient(135deg, #ff5e00, #ff9f00);
  color: #fff;
  text-align: center;
  padding: 2rem;
  border-radius: 10px;
  margin: 2rem 0;
  margin-top: 0px;
}

.motivation-banner h2 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.btn {
  background: #fff;
  color: #ff5e00;
  padding: 0.8rem 1.5rem;
  border-radius: 6px;
  text-decoration: none;
  font-weight: 600;
  transition: 0.3s;
}

.btn:hover {
  background: #111;
  color: #fff;
}

/* Classes */
.upcoming-classes {
  margin-top: 2rem;
}

.class-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1rem;
  margin-top: 1rem;
}

.class-card {
  background: #fff;
  padding: 1.5rem;
  border-radius: 10px;
  text-align: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.class-card h3 {
  color: #ff5e00;
}

</style>
</head>
<body>

<div class="sidebar">
    <h2> FitnessHub</h2>
    <ul>
        <li><a href="./dashboard1.php" style="background-color: rgb(255, 107, 53); color:white;">🏠 Dashboard</a></li>
        <li><a href="./edit_profile.php">👤 Edit Profile</a></li>
        <li><a href="./payment.html">💳 Payments</a></li>
        <li><a href="./dashboard_class.html">📅 Classes</a></li>
        <li><a href="./progress.html">📈 Progress</a></li>
        <li><a href="./dashboard_trainers.html">🏋‍♀ Trainers</a></li>
        <li><a href="./dashboard_srvices.html">⚙️ Services</a></li>
        <li><a href="./dashboard_contact.html">➤ Contact</a></li>
        <li><a href="./dashboard_about.html">ℹ️ About</a></li>
        <li><a href="./logout.php">🚪 Logout</a></li>
    </ul>
</div>

<div class="main-content" style="background-image: url(./dashboard1.jpg);">
    <div class="header">
        <h1>Welcome, <?php echo $userFullName; ?> 💪</h1>
        <div class="user-box">
            <div class="search-box">
                <input type="text" placeholder="Search...">
            </div>
            <button onclick="toggleDarkMode()">🌙</button>
            <img src="<?php echo $profilePic; ?>" alt="Profile">
        </div>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Total Members</h3>
            <p><strong>240</strong></p>
        </div>
        <div class="card">
            <h3>Active Classes</h3>
            <p><strong>18</strong></p>
        </div>
        <div class="card">
            <h3>Payments This Month</h3>
            <p><strong>৳1000</strong></p>
        </div>
        <div class="card">
            <h3>Trainers</h3>
            <p><strong>12</strong></p>
        </div>
    </div>

    <div style="margin-top:40px; margin-bottom:400px ; text-align:center;">
        <a href="./edit_profile.php"><button>Edit Profile</button></a>
        <a href="./logout.php"><button style="background:#e63946;">Logout</button></a>
    </div>




    <!-- MOTIVATION SECTION -->
      <section class="motivation-banner">
        <div class="banner-text">
          <h2>“Push harder than yesterday if you want a different tomorrow.”</h2>
          <a href="./dashboard_class.html" class="btn">View Classes</a>
        </div>
      </section>

      <!-- UPCOMING CLASSES -->
      <section class="upcoming-classes">
        <h2>Upcoming Classes</h2>
        <div class="class-grid">
          <div class="class-card">
            <h3>🔥 HIIT Blast</h3>
            <p>Time: 7:00 AM</p>
            <p>Trainer: Anoy Roy</p>
          </div>
          <div class="class-card">
            <h3>🧘 Yoga Flow</h3>
            <p>Time: 9:30 AM</p>
            <p>Trainer: Sofia Neyaj</p>
          </div>
          <div class="class-card">
            <h3>💪 Strength Zone</h3>
            <p>Time: 6:00 PM</p>
            <p>Trainer: Dolon Mia</p>
          </div>
        </div>
      </section>



    <footer>
        <p>&copy; 2025 FitnessHub Gym. All rights reserved.</p>
    </footer>
</div>

<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");
    localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
}
if (localStorage.getItem("darkMode") === "true") {
    document.body.classList.add("dark-mode");
}
</script>
</body>
</html>
