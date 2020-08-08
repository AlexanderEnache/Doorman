<?php include "conn.php";

session_start();

$user = $_POST['user'];
$id = $_POST['id'];
$amt = $_POST['amt'];
$pop = $_POST['pop'];
$cap = $_POST['cap'];
$name = $_POST['name'];

// echo $id . " " . $user . " " . $amt . " " . $cap . " " . $pop;

    $newPop = $pop + $amt;

    $query  = "UPDATE tour SET pop = $newPop where id = $id;";

    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();
    
    
    
    $query  = 'INSERT INTO tourbooked(guest, name, party) VALUES("'.$user.'", "'.$name.'", '.$amt.')';
    
    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();



    if($amt == 1){
        echo '<script type="text/javascript">alert("You have successfully booked a '.$name.' tour for '.$amt.' person");</script>';
    }else{
        echo '<script type="text/javascript">alert("You have successfully booked a '.$name.' tour for '.$amt.' people");</script>';
    }
    
    

    $query  = "SELECT * FROM tour;";
    
    $result = $conn->prepare($query);
    if (!$result) die ("Database access failed: " . $conn->error);
    
    $result->execute();
    $result->bind_result($id, $img, $dsc, $name, $cap, $pop);
    
   // echo "<div id='test'>";
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
   // echo "</div>";

?>