<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    
    if(isset($_POST['send'])){
        $room = $_POST['send'];
        $food = $_POST['food'];
        $user = $_SESSION['username'];
        
        $query  = "INSERT INTO roomorder(rnum, food_name, name) values($room, '$food', '$user');";
        
        $result = $conn->prepare($query);
        if (!$result) die ("Database access failed: " . $conn->error);
        
        $result->execute();
        
        header('Location: ./index.php');
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
        
            if(isset($_POST['item'])){
                
                session_start();
                if(!isset($_SESSION['username'])){
                    header("Location: login.php");
                }
                
                $username = $_SESSION['username'];
                $query  = "SELECT * FROM room WHERE booked='$username';";
                
                $result = $conn->prepare($query);
                if (!$result) die ("Database access failed: here" . $conn->error);
                
                $result->execute();
                $result->bind_result($rnum, $smk, $view, $pass);
                
                $rooms = array();
                
                while($result->fetch()){
                    array_push($rooms, ['rnum' => $rnum, 'smk' => $smk, 'view' => $view]);
                }
                
                if(!count($rooms)){
                    echo "<script type='text/javascript'>alert('You must have a room to request room service');location.replace('./book-a-room.php');</script>";
                }else{
                    if(count($rooms) !== 1){
                        echo "<table class='mt-5 mx-auto'><tr><th style='text-align: center;' colspan='2'>Which room</th></tr><tr><th style='text-align: center;' colspan='2'></th></tr>";
                        echo "<form action='serviceroom.php' method='post'>";
                        foreach($rooms as $r){
                            
                            $rnum = $r['rnum'];
                            $side = $r['view'];
                            $smk = $r['smk'];
                            
                            $item = $_POST['item'];
                            
                            echo <<<END
                            <div>
                                <tr><td>Room number $rnum, $side side</td><td><button name="send" value="$rnum">Deliver</button></td></tr>
                                <input style="display:none" name="food" value="$item">
                            </div>
END;
                        }
                        echo "</form>";   
                        echo "</table>";
                    }else{
                        $room = $rooms[0]['rnum'];
                        $food = $_POST['item'];
                        $query  = "INSERT INTO roomorder(rnum, food_name, name) values($room, '$food', '$username')";
                        
                        $result = $conn->prepare($query);
                        if (!$result) die ("Database access failed: " . $conn->error);
                        
                        $result->execute();
                        echo "<script type='text/javascript'>alert('Your request will be delivered to your room');location.replace('./index.php');</script>";
                    }
                    
                }
                
            }
        
        ?>
        
    </body>
</html>