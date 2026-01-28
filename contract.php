<?php
if(isset($_POST['name'])){

    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server,$username,$password);

    if(!$con){
     die("Connection Failed : ".mysqli_connect_error());
    }
    // echo "Success Connection";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO `gym`.`contact` (`name`, `email`, `phone`, `subject`, `message`, `time`) VALUES ('$name', '$email', '$phone', '$subject', '$message', current_timestamp());";
    
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
    <title>Contact Us | FitnessHub Gym</title>
   
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
                    <li><a href="contract.php" class="active">Contact</a></li>
                    <li><a href="./join.php" class="btn">Membership</a></li>
                    <li><a href="login.php" class="btn">Log In</a></li>
                </ul>
            </nav>
        </div>
    </header>

    
    <section class="contact-hero" style="  background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)), url('./contact.jpeg');
    background-size: cover;
    background-position: center;
    height: 60vh;
    display: flex;
    align-items: center;
    text-align: center;
    color: white;

    margin-top: 80px;">
        <div class="container">
            <h1>Contact Us</h1>
            <p>Have questions? Reach out to our team for assistance.</p>
        </div>
    </section>

  
    <section class="contact-content">
        <div class="container">
            <div class="contact-grid">
                
                <div class="contact-form">
                    <h2>Send Us a Message</h2>
                    <form action="./contract.php" method="POST">
                        <div class="form-group">
                            <input type="text" name="name" id="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="phone" id="phone" placeholder="Phone Number">
                        </div>
                        <div class="form-group">
                            <select name="subject" id="subject" required>
                                <option value="" disabled selected>Select Subject</option>
                                <option value="membership">Membership Inquiry</option>
                                <option value="classes">Class Schedule</option>
                                <option value="trainers">Personal Training</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="message" id="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>

            </div>
        </div>
    </section>

   
    
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>FitnessHub</h3>
                    <p>Your premier fitness destination with state-of-the-art facilities and expert trainers.</p>
                   
                </div>
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="./index.html">Home</a></li>
                        
                        <li><a href="./classes.html">Classes</a></li>
                        <li><a href="./trainer.html">Trainers</a></li>
                       <li><a href="./about.html">About Us</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Classes</h3>
                    <ul>
                        <li><a href="#">CrossFit</a></li>
                        <li><a href="#">Yoga</a></li>
                        <li><a href="#">Spin Cycling</a></li>
                        <li><a href="#">HIIT</a></li>
                        
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Contact</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Maijdee,Noakhali</li>
                        <li><i class="fas fa-phone"></i> 01618522284</li>
                        <li><i class="fas fa-envelope"></i> fitnesshub.com</li>
                        <li><i class="fas fa-clock"></i> Open 24/7</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 PowerFit Gym. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>