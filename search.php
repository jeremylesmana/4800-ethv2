<?php
session_start();
require_once "config.php";

?>

<html>
<head>
    <style>
        .searchHelper {
            color:white;
            text-align:center;
            margin: 0 auto;
            font-size: 30px;
        }
        
        .noResults {
            color:white;
        }

    </style>
    <title>RedemptionNFT - Home Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/main.scss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php include("header.php"); ?>

    <br><br>
    <p class="searchHelper">Search for your desired NFT here</p>

    <form action="search.php" method="get">
    <div class="input-group mb-3" style="width:500px;margin:0 auto;">
        
        <input name="q" type="text" class="form-control" placeholder="Search NFT here" aria-label="Search NFT here" aria-describedby="button-addon2">
        <div class="input-group-append">
            <button class="btn btn-info" type="submit" id="button-addon2">Search</button>
        </div>
        
    </div>
    </form>
    <div class="cardList">
        <?php
        //if there's a query being searched already

        if(isset($_GET["q"])) {
            $searchQuery = $_GET["q"];
            $sql = "SELECT * FROM listing WHERE (`listingName` LIKE '%".$searchQuery."%') OR (`listingDesc` LIKE '%".$searchQuery."%')";
        } else {
            $sql = "SELECT * FROM listing";
        }

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