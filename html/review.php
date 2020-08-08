<?php require "conn.php";
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
    
    $username = $_SESSION['username'];
    
    if(isset($_POST['star'])){
        $star = $_POST['star'];
        if(isset($_POST['review'])){
            $rev = $_POST['review'];
            $query = "INSERT INTO review(user, star, review) VALUES('$username', $star, '$rev');";
        }else{
            $query = "INSERT INTO review(user, star) VALUES('$username', $star);";
        }
        $result = $conn->prepare($query);
        if (!$result) die ("Database access failed: " . $conn->error);
        $result->execute();
        
        header("Location: index.php");
    }else{
        if(isset($_POST['submit'])){
            echo "<script>alert('You must atleast give a star rating')</script>";
        }
    }
    
?>

<html>
    <head>
        <title>Doorman Hotels</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <script src="../js/jquery-3.5.1.min.js"></script>
    </head>
    <body style="background-color: #e8e8e8">
        <?php   require "navbar.php";?>
        
    <style>
        .img{
            width:75px;
        }
    </style>
    
    <div class="row mt-5">
        <form class="mt-5 p-3 rounded bg-secondary mx-auto text-center" action='review.php' method='post'>
            <img class='img' id="1" src='../images/star.png'>
                <input style="display:none;" type="radio" name="star" id="star1" value="1"> 
            <img class='img' id="2" src='../images/star.png'>
                <input style="display:none;" type="radio" name="star" id="star2" value="2"> 
            <img class='img' id="3" src='../images/star.png'>
                <input style="display:none;" type="radio" name="star" id="star3" value="3"> 
            <img class='img' id="4" src='../images/star.png'>
                <input style="display:none;" type="radio" name="star" id="star4" value="4"> 
            <img class='img' id="5" src='../images/star.png'>
                <input style="display:none;" type="radio" name="star" id="star5" value="5"> <br><br>
            <textarea placeholder="What did you think (Optional)" class="mb-3" style="resize: none;" name="review" rows="4" cols="50"></textarea><br>
            <input class="btn btn-primary" type='submit' name="submit">
        </form>
    </div>
        
        <script>
            $(document).ready(function(){
                $('.img').click(function(e){
                    for(let i = 1; i <= 5; i++){
                        $("#star"+i).attr("checked", false);
                    }
                    
                    $("#star"+e.target.id).attr("checked", true);
                    
                    for(let i = parseInt(e.target.id); i >=1; i--){
                        $("#"+i).attr("src", "../images/fullstar.png");
                    }
                    
                    for(let i = 5; i > parseInt(e.target.id); i--){
                        $("#"+i).attr("src", "../images/star.png");
                    }
                    
                });
            });
        </script>
        
    </body>
</html>