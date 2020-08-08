<!DOCTYPE html>
<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="../js/jquery-3.5.1.min.js"></script>
    </head>
    <body style="background-color: #e8e8e8">
        <?php   require "navbar.php"; 
                require "conn.php";
                
            session_start();
            if(!isset($_SESSION['username'])){
                header("Location: login.php");
            }
            if($_SESSION['type'] != "staff"){
                header("Location: index.php");
            }
        
            $query  = "SELECT * FROM roomorder;";
    
            $result = $conn->prepare($query);
            if (!$result) die ("Database access failed: " . $conn->error);
            
            $result->execute();
            $result->bind_result($id, $rnum, $time, $staff, $food, $name);
            
            echo "<p style='display:none;' id='username'>".$_SESSION['username']."</p>";
            
            echo "<table id='test' class='mt-5 mx-auto'>";
            echo "<tr><th style='text-align: center;' colspan='2'>Select an Order to fulfill</th></tr><tr><th style='text-align: center;' colspan='2'></th></tr>";
            while($result->fetch()){
                if(!$staff){
                    echo "
                            <tr><td>$food to room number $rnum</td><td><button class='get' value='$id'>I'll get it</button></td></tr>
                    ";
                }else{
                    if($staff == $_SESSION['username']){
                        echo "
                                <tr><td>$food to room number $rnum</td><td><button class='done' value='$id'>Job is done</button></td></tr>
                        ";
                    }else{
                        echo "
                                <tr><td>$food to room number $rnum</td></tr>
                        ";
                    }
                }
            }
            echo "</table>";
        ?>
        
        <script>
            $(document).ready(function(){
                
                $('#test').on('click' , '.get', function(e) {
                    console.log(e.target.value);
                    $('#test').load("staff-get-order.php", {id: e.target.value, user: document.getElementById('username').innerText});
                });
                $('#test').on('click' , '.done', function(e) {
                    console.log(e.target.value);
                    $('#test').load("staff-done-order.php", {id: e.target.value, user: document.getElementById('username').innerText});
                });
            });
        </script>
    </body>
</html>