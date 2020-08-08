<?php require "conn.php";
        require "navbar.php";
         
    if(isset($_GET['logout']) && $_GET['logout'] == "true"){
        session_destroy();
        session_unset();
        echo "<script>location.replace('login.php');</script>";
    }
    
    if(isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])){
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query  = "SELECT * FROM guest WHERE username='$username' AND password='$password'";
        
        $result = $conn->prepare($query);
        if (!$result) die ("Database access failed: " . $conn->error);
        
        $result->execute();
        $result->bind_result($gid, $name, $user, $pass, $staff);
        
        if(!$result->fetch()){
            echo "You must have typed your username or password incorrectly";
        }else{
            session_start();
            
            $_SESSION["username"] = $user;
            $_SESSION["name"] = $name;
            
            if($staff){
                $_SESSION["type"] = "staff";
            }else{
                $_SESSION["type"] = "guest";
            }
            header("Location: index.php");
        }
    }
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body style="background-color: #e8e8e8">
        <div class="row">
            <form class="rounded mt-5 p-3 rounded bg-secondary mx-auto text-center" method="post" action="login.php">
                <h3 class="text-white">Login</h3>
                <input style="border:none;" class="rounded my-1" type="text" name="username" placeholder="Username"/><br>
                <input style="border:none;" class="rounded my-1" type="password" name="password" placeholder="Password"/><br>
                <input class="mt-1 btn btn-primary" type="submit" name="submit"/>
            </form>
        </div>
    </body>
</html>