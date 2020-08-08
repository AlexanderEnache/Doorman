<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        echo "You are not logged in";
    }else{
        $username = $_SESSION['username'];
    }
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body style="background-color: #e8e8e8">
        <?php require "navbar.php"; ?>
        
        <form action="checkout.php" method="post">
        <?php require "conn.php";
        
            $username = $_SESSION['username'];
        
            if(isset($_POST['checkout'])){
                $room_num = $_POST['checkout'];
                $query  = "UPDATE room SET booked=NULL WHERE rnum=$room_num;";
                $res = $conn->query($query);
                
                $query  = "DELETE FROM roomorder WHERE rnum=$room_num;";
                $res = $conn->query($query);
                
                header('Location: ./review.php');
            }
        
            $username = $_SESSION['username'];
            $query  = "SELECT * FROM room WHERE booked='$username';";
            
            $result = $conn->prepare($query);
            if (!$result) die ("Database access failed: " . $conn->error);
            
            $result->execute();
            $result->bind_result($rnum, $smk, $view, $pass);
            
            $check = 0;
            
            echo "<table class='mt-5 mx-auto'>";
            while($result->fetch()){
                echo "<tr><td>You're room number is $rnum, $view side view </td><td><button name='checkout' value='$rnum'>checkout</button></td></tr>";
                $check++;
            }
            echo "</table>";
            
            if(!$check){
                echo "<script>alert('You are not checked into any room');location.replace('index.php');</script>";
            }
        
        ?>
        </form>
    </body>
</html>