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
    <script src="assets/js/remove_listing.js"></script>
</head>

<body>
    <?php include("header.php"); ?>
        <?php
        $id = (int)$_GET["listingID"];
        $sql = "SELECT * FROM listing WHERE listingID = " . $id . ";";

        $result = $link->query($sql);

        if ($row = $result->fetch_assoc()) {
            $user_query = "SELECT username FROM userdata WHERE id = " . $row["listingOwnerId"];
            $user_result = $link->query($user_query)->fetch_assoc();
            echo "<div class='card' style='width: 50rem; margin: 0 auto;'>
                <h5 class='card-header'>NFT Listing</h5>
                <img src='" . $row["listingPictureURL"] . "' class='card-img-top' alt='Image not available'>
                    <div class='card-body'>
                        <h5 id='nft_name' class='card-title'>" . $row["listingName"] . "</h5>
                        <p class='card-text'>" . $row["listingDesc"] . "</p>
                        <a href='listing.php?listingID=" . $row["listingID"] . "' class='btn btn-primary'>" . $row["listingPrice"] . " ETH</a><br><br>
                        <p class='card-text'>Owned by: " . $user_result["username"] . "</p>
                        <button class='btn btn-danger btn-lg' onclick='history.back()' style='margin: 0 auto;'>Go Back</button>
                    </div>
                </div>";
        } else {
            echo "<h1 class='noResults'>0 results</h1>";
        }
        ?>
    <?php
    if(isset($_SESSION["id"])){
        if ($_SESSION["id"] == $row["listingOwnerId"]) {
            $id = (int)$_GET["listingID"];
            $sql = "SELECT * FROM listing WHERE listingID = " . $id . ";";

            $result = $link->query($sql);

            if ($row = $result->fetch_assoc()) {
                $user_query = "SELECT username FROM userdata WHERE id = " . $row["listingOwnerId"];
                $user_result = $link->query($user_query)->fetch_assoc();
                echo "<button class='open-button' onclick='openForm()'>Remove Listing</button>
                <div class='form-popup' id='myForm' style='display:none;'>
                    <form action='remove_listing.php?listingID=$id'  class='form-container' method='POST'>
                    <h1>Confirm Remove NFT Listing</h1>
                
                    <label><b>Type the NFT name to confirm</b></label>
                    <input type='text' placeholder='Enter NFT name' name='nft_name'  onkeyup='validate_text_match(this)' required>
                    <button type='submit' id='confirm' disabled class='btn'>Confirm Delete</button>
                    <button type='button' class='btn cancel' onclick='closeForm()'>Cancel</button>     
                    </form>
                </div>";
            }
        }
    }
    ?>
    
</body>

</html>