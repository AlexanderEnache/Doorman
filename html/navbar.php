<script src="../js/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
        ?>
            <nav style="background-color:#6c757d" class="navbar navbar-expand-lg navbar-light">
              <a style='pointer-events: none;cursor: default;' class="text-white navbar-brand" href="#">Doorman</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a class="text-white nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="text-white nav-link" href="login.php">Log In</a>
                  </li>
                  <li class="nav-item">
                    <a class="text-white nav-link" href="signup.php">Sign Up</a>
                  </li>
                </ul>
              </div>
            </nav>
        <?php
    }else{
        if($_SESSION['type'] == "staff"){
        ?>
        <nav style="background-color:#6c757d" class="navbar navbar-expand-lg navbar-light">
          <a style='pointer-events: none;cursor: default;' class="text-white navbar-brand" href="#">Doorman</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="text-white nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="service-request.php">Service Request</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="login.php?logout=true">Log Out</a>
              </li>
            </ul>
          </div>
        </nav>
        <?php
        }else{
        ?>
        <nav style="background-color:#6c757d" class="navbar navbar-expand-lg navbar-light">
          <a style='pointer-events: none;cursor: default;' class="text-white navbar-brand" href="#">Doorman</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="text-white nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="book-a-room.php">Book a Room</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="roomservice.php">Room Service</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="tour-booking.php">Tours</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="checkout.php">Check Out</a>
              </li>
              <li class="nav-item">
                <a class="text-white nav-link" href="login.php?logout=true">Log Out</a>
              </li>
            </ul>
          </div>
        </nav>
        <?php
        }
    }
?>