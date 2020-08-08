<?php require "conn.php";
         require "navbar.php";
         
    // if(isset($_GET['logout']) && $_GET['logout'] == "true"){
    //     session_destroy();
    //     //unset($_SESSION);
    // }
         
    if(isset($_POST['submit']) && isset($_POST['username']) && $_POST['username'] !== "" && isset($_POST['password']) && $_POST['password'] !== "" && isset($_POST['repassword']) && $_POST['repassword'] !== "" && isset($_POST['name']) && $_POST['name'] !== ""){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $name = $_POST['name'];
        
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['repassword']);
        unset($_POST['name']);
        unset($_POST['submit']);
        
        if($password == $repassword){
            $query  = "SELECT * FROM guest WHERE username='$username'";
            $result = $conn->prepare($query);
            if (!$result) die ("Database access failed: " . $conn->error);
            
            $result->execute();
            $result->bind_result($gid, $nme, $user, $pass);
            
            if(!$result->fetch()){
                session_start();
                
                if(isset($_POST['staff']) && $_POST['staff'] == "on"){
                    $query  = "INSERT INTO guest(name, username, password, staff) values('$name', '$username', '$password', 1);";
                }else{
                    $query  = "INSERT INTO guest(name, username, password) values('$name', '$username', '$password');";
                }
                
                $result = $conn->prepare($query);
                if (!$result) die ("Database access failed: " . $conn->error);
                
                $result->execute();
                
                $_SESSION["username"] = $username;
                $_SESSION["name"] = $name;
                header("Location: index.php");
            }else{
                echo "<script>alert('I think that username exists already');</script>";
            }
        }else{
            echo "<script>alert('Your passwords do not match');</script>";
        }
        
    }else{
        if(isset($_POST['submit'])){
            echo "<script>alert('You must fill all required fields');</script>";   
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
            <form class="mt-5 p-3 rounded bg-secondary mx-auto text-center" method="post" action="signup.php">
                <h3 style="color:white;">Sign Up</h3>
                <input class="my-1 rounded" type="text" name="username" placeholder="Username" style="border:none;"/><br>
                <input class="my-1 rounded" type="text" name="name" placeholder="Name" style="border:none;"/><br>
                <input class="my-1 rounded" type="password" name="password" placeholder="Password" style="border:none;"/><br>
                <input class="my-1 rounded" type="password" name="repassword" placeholder="Retype Password" style="border:none;"/><br>
                <input class="mt-2 btn btn-primary" type="submit" name="submit"/>
            </form>
        </div>
    </body>
</html>