<?php include "conn.php";

$user = $_POST['user'];
$id = $_POST['id'];

    $query  = "DELETE FROM roomorder WHERE id = $id";
    
    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();
    //$result->bind_result($id, $img, $dsc, $name);
    
    
    $query  = "SELECT * FROM roomorder;";
    
    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();
    $result->bind_result($id, $rnum, $time, $staff, $food, $name);
    
    //echo "<p style='display:none;' id='username'>".$_SESSION['username']."</p>";
    
    //echo "<div id='test'>";
    echo "<tr><th style='text-align: center;' colspan='2'>Select an Order to fulfill</th></tr><tr><th style='text-align: center;' colspan='2'></th></tr>";
    while($result->fetch()){
        if(!$staff){
            echo "
                    <tr><td>$food to room number $rnum</td><td><button class='get' value='$id'>I'll get it</button></td></tr>
            ";
        }else{
            if($staff == $user){
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
    //echo "</div>";
?>