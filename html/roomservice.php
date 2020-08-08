<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    
    $username = $_SESSION['username'];
    $query  = "SELECT * FROM room WHERE booked='$username';";
    
    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();
    $result->bind_result($rnum, $smk, $view, $pass);
    
    $check = 0;
    
    while($result->fetch()){
        $check++;
    }
    
    if(!$check){
        echo "<script type='text/javascript'>alert('You must have a room to request room service');</script>";
    }
    
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body style="background-color: #e8e8e8">
        <?php   require "navbar.php"; 
                require "conn.php";
        
            $query  = "SELECT * FROM roomservice;";
    
            $result = $conn->prepare($query);
            if (!$result) die ("Database access failed: " . $conn->error);
            
            $result->execute();
            $result->bind_result($id, $img, $dsc, $name);
            
            echo "<form class='d-flex flex-wrap' action='serviceroom.php' method='post'>";
            while($result->fetch()){
                echo <<<END
                        <div style='text-align:center;width:400px;' class="container py-5">
                            <h3>$name</h3><br>
                            <img style='max-height:275px;' class="w-100" src='../images/$img'><br>
                            <p>$dsc</p>
                            <button class="w-25" name="item" value="$name">Order</button>
                        </div>
END;
            }
            echo "</form>";
        ?>
    </body>
</html>