<?php
session_start();
$user_logged_in = isset($_SESSION['user']);
?>
<html>
<head>
 
  <title>Lumos - Professional Editing Services</title>
  <link rel="stylesheet" href="user interface csss.css"> 
</head>
<body >


  <header>
    <div class="header-content">
        <video autoplay muted loop id="bgVideo">
            <source src="files/render video.mp4" type="video/mp4">
            
          </video>
        <img src="files/png.png" alt="Lumos Logo" class="logo"> 
      <h1>Welcome to Lumos</h1>
      <p>We Know..! Why You Are Here...!</p>

    </div>  
  </header>
  

 
  <nav>
    <ul>
      <li><a href="#home">Home</a></li>
      <li><a href="#about">About Us</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="contact us page.html">Contact Us</a></li>
      <li><a href="auth.php">Sign In</a></li>
      <li><a href="categories_page.php">Categories</a></li>
      
    </ul>
    
  </nav>
  

  

  <main>
    
   
    <!-- About Section -->
    <section id="about">
      <div class="about-content">
        <img src="files/lumos 1.jpeg" alt="About Us Image" class="about-image">
       
        <div class="text-content">
          <h2>About Us</h2>
          <p>
            Welcome to Lumos – where innovation illuminates progress!</br>
            
          </br>LUMOS is a  web-based platform designed to  editorial services. 
          The platform aims to provide a seamless experience for clients seeking professional editing services .</br>
          By  Lumos will simplify the process of Editing. Also We Can Do any Type of Editing services As your need..!
          
        </p>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section id="services">
      <h2>Our Services</h2>
      <div class="service-cards">
        <div class="service-card">
          <img src="files/service (2).jpg" alt="Editing Icon" class="service-icon">
          <h3>Multiple Editing Services </h3>
          <p>Clients can easily get our services and reduce their time spent searching for quality services..</p>
        </div>
        <div class="service-card">
          <img src="files/service (1).jpg"alt="Proofreading Icon" class="service-icon">
          <h3>Advanced Video Editing</h3>
          <p>We also doing editing tyes related to our current scienarios.</p>
        </div>
        <div class="service-card">
          <img src="files/service (3).jpg" alt="Proofreading Icon" class="service-icon">
          <h3>Audio Editing</h3>
          <p>We also here to Enhance your audio clips and doing some audio related editing.</p>
        </div>
        <div class="service-card">
          <img src="files/service (4).jpg" alt="Proofreading Icon" class="service-icon">
          <h3>Up to date customizations and user friendly services</h3>
          <p>users can easily access the current market tred editing services and uptodate services</p>
        </div>

       

      </div>
    </section>

    
    <section id="testimonials">
      <h2>What Our Clients Say</h2>
      <div class="testimonial">
        <img src="files/work-office.gif" alt="Client Photo" class="client-photo"> 
        <blockquote>"Lumos is the Best ! Their editors are Just amazing and detail-oriented."</blockquote>
        <p>- Jegan Digee, Content Creator</p>
      </div>

      
      <div class="testimonial">
        <img src="files/123.gif" alt="Client Photo" class="client-photo">
        <blockquote>"Highly recommend Lumos for any editing needs. Quick, professional, and reliable."</blockquote>
        <p>- Thirugnam Venujan, Youtuber</p>
      </div>
    </section>
  </main>

  <section id="footer">
    <div class="section-box">
      <div class="footer-grid">

        <div>
          <h3>Quick Links</h3>

          
          <a href="#home" class="footer-items f1">Home</a></br>
          <a href="#about" class="footer-items f2">About Us</a></br>
          <a href="#services" class="footer-items f3">Services</a></br>
          <a href="contact us page.html" class="footer-items f4">Contact Us</a></br>

      
          

        </div>

        <div>
          <h3>Contacts</h3>

          <a class="footer-items f1">(076) 2 353 312</a></br>
          <a class="footer-items f2">(072) 5 143 301</a></br>
          <a class="footer-items f3">info@Lumos.org</a></br>
          <a class="footer-items f4">1234 Nallur Junction, Jaffna</a>
        </div>

        <div>
          <h3>Socials</h3>
        
          <a href="https://www.facebook.com" target="_blank" class="footer-items f1">
            <img src="files/fb.png" alt="Facebook Icon" class="social-icon">
          </a>
          <a href="https://www.youtube.com" target="_blank" class="footer-items f2">
            <img src="files/yt.png" alt="YouTube Icon" class="social-icon">
          </a>
          <a href="https://www.instagram.com" target="_blank" class="footer-items f3">
            <img src="files/insta.png" alt="Instagram Icon" class="social-icon">
          </a>
          <a href="https://www.linkedin.com" target="_blank" class="footer-items f4">
            <img src="files/link.png" alt="LinkedIn Icon" class="social-icon">
          </a>
          <a href="https://www.twitter.com" target="_blank" class="footer-items f5">
            <img src="files/twitter.png" alt="Twitter Icon" class="social-icon">
          </a>
        </div>
        

      </div>

      <p class="copyrights">© Lumos | all rights reserved</p>
    </div>
  </section>

</body>

</html>