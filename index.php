<?php
session_start();

require_once "config.php";




?>
<html>

<head>
    <title>RedemptionNFT - Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/main.scss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include("header.php"); ?>

    <div class="hero" style="padding:10rem;">
        <h1>BUY AND SELL</h1>
        <h2>Physical items as NFTs</h2>
        <?php
        if (isset($_SESSION["loggedin"])) {
            echo '<h4>Welcome back, ' . $_SESSION["username"] . '!</h4>';
        } else {
            echo '<h4>Log in or sign up today to get started!</h4>';
        };
        ?>
    </div>
    <div class="cardList">
        <?php
        $sql = "SELECT * FROM listing";

        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $user_query = "SELECT username FROM userdata WHERE id = " . $row["listingOwnerId"];
                $user_result = $link->query($user_query)->fetch_assoc();
                echo "
                <div class='card'>
                <img src='" . $row["listingPictureURL"] . "' class='card-img-top' alt='Image not available'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . $row["listingName"] . "</h5>
                        <p class='card-text'>" . $row["listingDesc"] . "</p>
                        <a href='listing.php?listingID=" . $row["listingID"] . "' class='btn btn-primary'>" . $row["listingPrice"] . " ETH</a><br><br>
                        <p class='card-text'>Owned by: " . $user_result["username"] . "</p>
                    </div>
                </div>";
            }
        } else {
            echo "<h1 class='noResults'>0 results</h1>";
        }
        ?>
    </div>

</body>

</html>