<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        echo "You are not logged in";
    }else{
        $username = $_SESSION['username'];
        if(isset($_POST['submit'])){
    
            $smk = $_POST['smoking'];
            $vew = $_POST['view'];
            
            
            $query  = "SELECT * FROM room WHERE smoking='$smk' AND side='$vew' AND booked IS NULL LIMIT 1;";
            
            $res = $conn->query($query);
            $row = $res->fetch_assoc();
            
            if(!$row){
                echo "<script>alert('Unfortunately all rooms in that category have been booked')</script>";
            }else{
                $query  = "UPDATE room SET booked='$username' WHERE smoking='$smk' AND side='$vew' AND booked IS NULL LIMIT 1;";
                if(!($conn->query($query) === TRUE)){
                     echo "<script>alert('Failed to process your request')</script>";
                }
                $msg = "Succesfully Submitted. Enjoy Your Stay. Your room number is " . $row['rnum'];
                echo "<script>alert('$msg');location.replace('./index.php');</script>";
            }
        }
    }
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body style="background-color: #e8e8e8">
        <?php require "navbar.php"; ?>
        
        <!--<div class="container">-->
            <!--<div class="row">-->
                
                    <?php require "conn.php";
                        $username = $_SESSION['username'];
                        $query  = "SELECT * FROM room WHERE booked='$username';";
                        $msg = "";
                        
                        $result = $conn->prepare($query);
                        if (!$result) die ("Database access failed: " . $conn->error);
                        
                        $result->execute();
                        $result->bind_result($rnum, $smk, $view, $pass);
                        
                        while($result->fetch()){
                            $msg = $msg . "You're room number is $rnum, $view side view\\n";
                        }
                        
//                         echo <<<END
//                                 <script type='text/javascript'>alert("$msg");</script>
// END;
                    ?>
            <!--</div>-->
                
            <div class="row">
                    <form class="mt-5 p-3 rounded bg-secondary mx-auto text-center" method="post" action="book-a-room.php">
                        <h3 class="text-white">Select A Room</h3>
                        <select class="my-2 form-control" id="smoking" name="smoking">
                          <option value="y">Smoking</option>
                          <option value="n">Non-Smoking</option>
                        </select>
                        <select class="my-2 form-control" id="view" name="view">
                          <option value="beach">Beach</option>
                          <option value="city">City</option>
                          <option value="rainforest">Rain Forest</option>
                        </select>
                        <input class="btn btn-primary" type="submit" name="submit"/>
                    </form>
            </div>
        <!--</div>-->
    </body>
</html>