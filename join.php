<?php
if(isset($_POST['firstname'])){

    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server,$username,$password);

    if(!$con){
     die("Connection Failed : ".mysqli_connect_error());
    }
    // echo "Success Connection";

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $membership = $_POST['membership'];

    $sql = "INSERT INTO `gym`.`membership` (`firstname`, `lastname`, `email`, `phone`, `membership`, `time`) VALUES ('$firstname', '$lastname', '$email', '$phone', '$membership', current_timestamp());";
    
    echo $sql;

    if($con->query($sql) == true)
        { echo "Successfully inserted"; }
    else
        {echo "ERROR: $sql <br> $con->error";}

    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Our Gym | FitnessHub Gym</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">FitnessHub</div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="classes.html">Classes</a></li>
                    <li><a href="trainer.html">Trainers</a></li>
                    <li><a href="service.html">Services</a></li>
                    <li><a href="contract.php">Contact</a></li>
                    <li><a href="./join.php" class="btn">Membership</a></li>
                    <li><a href="login.php" class="btn">Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    

        <section class="membership-plans container">
            <h3>Choose Your Plan</h3>
            <div class="plans-grid">
                <div class="plan">
                    <h4>Basic</h4>
                    <p class="price">$29<span>/month</span></p>
                    <ul>
                        <li>Gym access</li>
                        <li>Cardio equipment</li>
                        <li>Free weights</li>
                        <li>Locker room</li>
                    </ul>
                    <a href="#signup-form" class="btn">Select Plan</a>
                </div>

                <div class="plan featured">
                    <div class="popular-badge">Popular</div>
                    <h4>Premium</h4>
                    <p class="price">$49<span>/month</span></p>
                    <ul>
                        <li>24/7 access</li>
                        <li>All equipment</li>
                        <li>Group classes</li>
                        <li>Towels included</li>
                    </ul>
                    <a href="#signup-form" class="btn">Select Plan</a>
                </div>
            </div>
        </section>

        <section id="signup-form" class="signup-form container">
            <h3>Book A Membership</h3>
            <form action="join.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" id="firstname" 
                        required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" name="lastname" id="lastname"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email"  required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" id="phone" >
                </div>

                <div class="form-group">
                    <label for="plan">Membership Plan</label>
                    <select id="plan" name="membership" required>
                        <option value="">Select a plan</option>
                        <option value="basic">Basic ($29/month)</option>
                        <option value="premium">Premium ($49/month)</option>
                    </select>
                </div>

                <button type="submit" class="btn">Join Now</button>
            </form>
        </section>
   

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 FitnessHub Gym. All rights reserved.</p>
        </div>
    </footer>

    <!--  -->
</body>
</html>