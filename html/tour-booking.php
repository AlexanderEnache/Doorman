<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    
    $username = $_SESSION['username'];
    
    echo "<p style='display:none;' id='username'>$username</p>";
    
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="../js/jquery-3.5.1.min.js"></script>
    </head>
    <body style="background-color: #e8e8e8">
        <?php   require "navbar.php"; 
                require "conn.php";
            
            $username = $_SESSION['username'];
        
            $query  = "SELECT * FROM tour;";
    
            $result = $conn->prepare($query);
            if (!$result) die ("Database access failed: " . $conn->error);
            
            $result->execute();
            $result->bind_result($id, $img, $dsc, $name, $cap, $pop);
            
            echo "<div class='d-flex flex-wrap' id='test'>";
            while($result->fetch()){
                $max = (int)$cap - (int)$pop;
                if($max == 0){
                     echo <<<END
                        <div style='text-align:center;width:400px;' class="container py-5">
                            <h3 id='name-$id'>$name</h3>
                            <img style='max-height:275px;' class="w-100" src='../images/$img'>
                            <p>$dsc</p>
                            <p>Capacity: $pop/$cap
                            <p id='cap-$id' style='display:none;'>$cap</p>
                            <p id='pop-$id' style='display:none;'>$pop</p>
                        </div>
END;
                }else{
                     echo <<<END
                        <div style='text-align:center;width:400px;' class="container py-5">
                            <h3 id='name-$id'>$name</h3>
                            <img style='max-height:275px;' class="w-100" src='../images/$img'>
                            <p>$dsc</p>
                            <p>Capacity: $pop/$cap
                            <p id='cap-$id' style='display:none;'>$cap</p>
                            <p id='pop-$id' style='display:none;'>$pop</p>
                            <input onKeyDown="return false" id='amount-$id' type='number' value='1' min='1' max='$max'>
                            <button class="get w-25" name="item" value="$id">Book</button>
                        </div>
END;
                }
               
            }
            echo "</div>";
        ?>
        <script>
            $(document).ready(function(){
                
                $('#test').on('click' , '.get', function(e) {
                    console.log(e.target.value);
                    $('#test').load("tour-booked.php", {id: e.target.value, 
                                                        user: document.getElementById('username').innerText, 
                                                        amt: document.getElementById('amount-'+e.target.value).value,
                                                        pop: document.getElementById('pop-'+e.target.value).innerText, 
                                                        cap: document.getElementById('cap-'+e.target.value).innerText,
                                                        name: document.getElementById('name-'+e.target.value).innerText
                    });
                });
            });
        </script>
    </body>
</html>