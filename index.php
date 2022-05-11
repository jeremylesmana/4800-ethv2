<?php
session_start();

require_once "config.php";



?>
<html>

<head>
    <title>RedemptionNFT - Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/header.css">

    <style>
        body {
            background: rgb(44,42,89);
            background: radial-gradient(circle, rgba(44,42,89,1) 0%, rgba(0,28,34,1) 48%, rgba(10,10,56,1) 100%);

        }
        .hero {
            color: white;
            margin: 0 auto;
            font-family: "Montserrat", sans-serif;
            text-align:center;
        }
        h1 {
            font-size: 70px;
        }
        h2 {
            color: #DDDDDD;
        }
        h4 {
            color: #999999;
        }
        .cardList {
            width: 75%;
            margin: 0 auto;
        }

        .card {
            display: inline-grid;
            margin: 20 auto;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="assets/logo.png" width="300">
        <div class="header-right">
            <a class="active" href="index.php">Home</a>
            <?php
                if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                    echo '<a href="login.php">Create Listing</a>';
                }
                else {
                    echo '<a href="create.php">Create Listing</a>';
                }
            ?>
            <?php
                if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
                    echo '<a href="login.php">Log In</a>';
                }
                else {
                    echo '<a href="logout.php">Log Out</a>';
                }
            ?>
        </div>
    </div>

    <div class="hero"><br><br><br><br><br><br><br><br><br>
        <h1>BUY AND SELL</h1>
        <h2>Physical items as NFTs</h2>
        <?php
            if(isset($_SESSION["loggedin"])){
                echo '<h4>Welcome back, ' . $_SESSION["username"] . '!</h4>';
            } else {
                echo '<h4>Log in or sign up today to get started!</h4>';
            };
        ?>
    </div><br><br><br><br>
    <div class="cardList">
        <?php
            $sql = "SELECT * FROM listing";
            $result = $link->query($sql);
            
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                echo "<div class='card' style='width: 18rem;'>
                <img src='" . $row["listingPictureURL"]. "' class='card-img-top' alt='Image not available'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . $row["listingName"]. "</h5>
                        <p class='card-text'>" . $row["listingDesc"]. "</p>
                        <a href='listing.php?listingID=" . $row["listingID"] . "' class='btn btn-primary'>" . $row["listingPrice"]. " ETH</a><br><br>
                        <p class='card-text'>Owned by: " . $row["listingOwner"]. "</p>
                    </div>
                </div>'";
              }
            } else {
              echo "<h1>0 results</h1>";
            }
        ?>
    </div>

</body>

</html>