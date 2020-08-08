<?php

session_start();

if(isset($_SESSION['username'])){
    if($_SESSION['type'] == "staff"){
    ?>
    <html>
        <head>
            <title>Doorman Hotels</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        </head>
        <body style='background-color:#e8e8e8'>
            <?php require "navbar.php"; 
                    require "conn.php";
                $query  = "SELECT * FROM room";
        
                $result = $conn->prepare($query);
                if (!$result) die ("Database access failed: " . $conn->error);
                
                $result->execute();
                $result->bind_result($rnum, $smk, $side, $book);
                
                $rooms = 0;
                $booked = 0;
                $smoke = 0;
                $nonsmk = 0;
                
                $beach = 0;
                $city = 0;
                $rainforest = 0;
                
                while($result->fetch()){
                    $rooms++;
                    if($book){
                        $booked++;
                        if($smk == 'y'){
                            $smoke++;
                        }else{
                            $nonsmk++;
                        }
                        switch($side){
                            case "beach":
                            $beach++;
                            break;
                            case "rainforest":
                            $rainforest++;
                            break;
                            case "city":
                            $city++;
                            break;
                        }
                    }
                }
                
                echo <<<END
                    <p id='rooms' style='display:none;'>$rooms</p>
                    <p id='booked' style='display:none;'>$booked</p>
                    <p id='smoke' style='display:none;'>$smoke</p>
                    <p id='nonsmk' style='display:none;'>$nonsmk</p>
                    <p id='beach' style='display:none;'>$beach</p>
                    <p id='city' style='display:none;'>$city</p>
                    <p id='rainforest' style='display:none;'>$rainforest</p>
END
            ?>
            
            
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-4" id="piechart"></div>
                    <div class="col-lg-4" id="piechart2"></div>
                    <div class="col-lg-4" id="piechart3"></div>
                </div>
            </div>
            
            
            <script type="text/javascript">
                let rooms = parseInt(document.getElementById('rooms').innerText);
                let booked = parseInt(document.getElementById('booked').innerText);
                let smoke = parseInt(document.getElementById('smoke').innerText);
                let nonsmk = parseInt(document.getElementById('nonsmk').innerText);
                let beach = parseInt(document.getElementById('beach').innerText);
                let city = parseInt(document.getElementById('city').innerText);
                let rainforest = parseInt(document.getElementById('rainforest').innerText);
            
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                google.charts.setOnLoadCallback(drawChart2);
                google.charts.setOnLoadCallback(drawChart3);
                
                function drawChart() {
                
                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['Booked',     booked],
                      ['Not Booked',      rooms - booked]
                    ]);
                    
                    var options = {
                      title: 'Rooms',
                      backgroundColor: '#e8e8e8'
                    };
                    
                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    
                    chart.draw(data, options);
                
                }
                
                function drawChart2() {
                
                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['Beach', beach],
                      ['City', city],
                      ['Rain Forest', rainforest]
                    ]);
                    
                    var options = {
                      title: 'Booked Rooms on Category',
                      backgroundColor: '#e8e8e8'
                    };
                    
                    var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));
                    
                    chart2.draw(data, options);
                    
                }
                
                function drawChart3() {
                
                    var data = google.visualization.arrayToDataTable([
                      ['Task', 'Hours per Day'],
                      ['Smoke', smoke],
                      ['Non Smoking', nonsmk]
                    ]);
                    
                    var options = {
                      title: 'Booked Rooms on Smoking',
                      backgroundColor: '#e8e8e8'
                    };
                    
                    var chart3 = new google.visualization.PieChart(document.getElementById('piechart3'));
                    
                    chart3.draw(data, options);
                    
                }
            </script>
        </body>
    </html>
    <?php
    }else{
    ?>
    <html>
        <head>
            <title>Doorman Hotels</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        </head>
        <body style='background-color:#e8e8e8'>
            <?php require "navbar.php";
                    require "conn.php";
                
                session_start();
                
                $username = $_SESSION['username'];
                $query  = "SELECT * FROM room WHERE booked='$username';";
                
                $result = $conn->prepare($query);
                if (!$result) die ("Database access failed: " . $conn->error);
                
                $result->execute();
                $result->bind_result($rnum, $smk, $view, $pass);
                
                $arr = [];                
                while($result->fetch()){
                    array_push($arr, ['rnum' => $rnum, 'smk' => $smk, 'view' => $view]);
                }
                
                $count = count($arr);
                
                // echo "<div>";
                // if(!$count){
                //     echo "You are not yet checked into any rooms";
                // }else{
                //     echo "Your room numbers are<br>";
                //     foreach($arr as $i){
                //         echo $i['rnum']." on the ".$i['side']." side<br>";   
                //     }
                // }
                // echo "</div>";
                
                
                
                
                
                $quer  = "SELECT * FROM roomorder WHERE name='$username' AND day(time)=day(now()) and month(time)=month(now()) and year(time)=year(now());";
                
                $resul = $conn->prepare($quer);
                if (!$resul) die ("Database access failed: " . $conn->error);
                
                $resul->execute();
                $resul->bind_result($id, $rnum, $time, $staff, $food, $name);
                
                $ar = [];                
                while($resul->fetch()){
                    array_push($ar, ['rnum' => $rnum, 'time' => $time, 'food' => $food]);
                }
                //print_r($ar);
                $coun = count($ar);
                
                // echo "<div>";
                // if(!$coun){
                //     echo "You have not ordered anything today";
                // }else{
                //     echo "You have ordered<br>";
                //     foreach($ar as $i){
                //         echo $i['food']." at room number ".$i['rnum']."<br>";   
                //     }
                // }
                // echo "</div>";
                
                
                
                
                
                $que  = "SELECT * FROM tourbooked WHERE guest='$username' AND day(time)=day(now()) and month(time)=month(now()) and year(time)=year(now());";
                
                $res = $conn->prepare($que);
                if (!$res) die ("Database access failed: " . $conn->error);
                
                $res->execute();
                $res->bind_result($id, $name, $gst, $pty, $time);
                
                $a = [];                
                while($res->fetch()){
                    array_push($a, ['name' => $name, 'pty' => $pty]);
                }
                //print_r($a);
                $cou = count($a);
                
                
                
                
                echo "<div class='row d-flex justify-content-center mt-5'>";
                echo "<div style='width:250px; min-height:200px;' class='text-white rounded text-center mx-5 p-2 bg-secondary my-2'>";
                if(!$count){
                    echo "You are not yet checked into any rooms";
                }else{
                    echo "Your room number is<br>";
                    foreach($arr as $i){
                        echo $i['rnum']." on the ".$i['view']." side<br>";   
                    }
                }
                echo "</div>";
                
                echo "<div style='width:250px; min-height:200px;' class='text-white rounded text-center mx-5 p-2 bg-secondary my-2'>";
                if(!$coun){
                    echo "You have not ordered anything today";
                }else{
                    echo "You have ordered<br>";
                    foreach($ar as $i){
                        echo $i['food']." at room number ".$i['rnum']."<br>";   
                    }
                }
                echo "</div>";
                
                echo "<div style='width:250px; min-height:200px;' class='text-white rounded text-center mx-5 p-2 bg-secondary my-2'>";
                if(!$cou){
                    echo "You have no tours schedueled for today";
                }else{
                    echo "You have schedueled<br>";
                    foreach($a as $i){
                        echo $i['name']." tour for ".$i['pty']." people<br>";   
                    }
                }
                echo "</div>";
                echo "</div>";
                
            ?>
        </body>
    </html>
    <?php
    }
}else{
?>
    <html>
        <head>
            <title>Doorman Hotels</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        </head>
        
        <style>
            .img{
                width:25px;
            }
            .imgs{
                display:inline-block;
                float:right;
            }
            #one{
                width:35%;
                position:relative;
                left:50%;
                transform:translateX(-50%);
            }
            @media only screen and (max-width: 900px) {
                #one{
                    width:80%;
                }
            }
        </style>
        
        <body style='background-color:#e8e8e8'>
            <?php require "navbar.php";
                    require "conn.php";
                //$username = $_SESSION['username'];
                $query  = "SELECT * FROM review;";
                
                $result = $conn->prepare($query);
                if (!$result) die ("Database access failed: " . $conn->error);
                
                $result->execute();
                $result->bind_result($id, $user, $star, $rev);
                
                echo "<div id='one' position:relative; left:50%; transform:translateX(-50%);'>";
                echo "<h1 class='text-center mt-4 mb-3'>Reviews</h1>";
                while($result->fetch()){
                    
                    if($star == 1){
                    $str = "
                    <div class='imgs'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                    </div>
                    ";   
                    }
                    if($star == 2){
                    $str = "
                    <div class='imgs'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                    </div>
                    ";   
                    }
                    if($star == 3){
                    $str = "
                    <div class='imgs'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/star.png'>
                        <img class='img' src='../images/star.png'>
                    </div>
                    ";   
                    }
                    if($star == 4){
                    $str = "
                    <div class='imgs'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/star.png'>
                    </div>
                    ";   
                    }
                    if($star == 5){
                    $str = "
                    <div class='imgs'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                        <img class='img' src='../images/fullstar.png'>
                    </div>
                    ";   
                    }
                    
                    echo "
                    <div class='bg-secondary rounded p-2 text-white my-4'>
                        <p style='display:inline' class='mr-2'><b>$user:</b></p> $str<br>
                        $rev
                    </div>";
                }
                echo "</div>";
            ?>
        </body>
    </html>
<?php
}
?>