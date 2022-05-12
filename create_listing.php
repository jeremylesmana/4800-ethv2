<?php
// Include config file
session_start();
require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if ((isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false)) {
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$nft_name = $nft_description = "";
$nft_name_err = $nft_description_err = "";
$nft_price = 0;
$nft_picture = $nft_picture_err = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate NFT name
    if (empty(trim($_POST["nft_name"]))) {
        $nft_name_err = "Please enter a name for the NFT.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["nft_name"]))) {
        $nft_name_err = "NFT Name can only contain letters, numbers, and underscores.";
    } else {
        $param_nft_name = trim($_POST["nft_name"]);
        $nft_name = trim($_POST["nft_name"]);
    }

    // Validate NFT description
    if (empty(trim($_POST["nft_description"]))) {
        $nft_description_err = "Please enter a description for the NFT.";
    } elseif (!preg_match('/^[a-zA-Z0-9\t\n .\/<>?;:"\'`!@#$%^&*()\[\]{}_+=|\\-,]+$/', trim($_POST["nft_description"]))) {
        $nft_description_err = "NFT description can only contain letters, numbers, and reasonable symbols.";
    } else {
        $param_nft_description = trim($_POST["nft_description"]);
        $nft_description = trim($_POST["nft_description"]);
    }

    // Validate NFT description
    if (empty(trim($_POST["nft_price"]))) {
        $nft_price_err = "Please enter a price for the NFT.";
    } elseif ($_POST["nft_price"] < 0) {
        $nft_price_err = "NFT price cannot be negative.";
    } else {
        $param_nft_price = trim($_POST["nft_price"]);
        $nft_price = trim($_POST["nft_price"]);
    }

    // Validate NFT picture url
    if (empty(trim($_POST["nft_picture"]))) {
        $nft_picture_err = "Please enter a picture URL for the NFT.";
    // } elseif (!filter_var($nft_picture, FILTER_VALIDATE_URL)) {
    //     $nft_picture_err = $nft_picture . " is not a valid URL";
    } else {
        $param_nft_picture = trim($_POST["nft_picture"]);
        $nft_picture = trim($_POST["nft_picture"]);
    }

    // Check input errors before inserting in database
    if (empty($nft_name_err) && empty($nft_description_err) && empty($nft_price_err) && empty($nft_picture_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO listing (listingName, listingDesc, listingPrice, listingPictureURL, listingOwnerId) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_nft_name, $param_nft_description, $param_nft_price, $param_nft_picture, $_SESSION["id"]);

            // Set parameters
            $param_nft_name = $nft_name;
            $param_nft_description = $nft_description;
            $param_nft_price = $nft_price;
            $param_nft_picture = $nft_picture;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: profile.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create a new NFT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/header.css">
    <link rel="stylesheet" href="assets/main.scss">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include("header.php") ?>

    <div class="form">
        <h2>Create a new NFT</h2>
        <p>Please fill this form to create an NFT.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>NFT Name</label>
                <input type="text" name="nft_name" class="form-control <?php echo (!empty($nft_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nft_name; ?>">
                <span class="invalid-feedback"><?php echo $nft_name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="nft_description" class="form-control <?php echo (!empty($nft_description_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nft_description; ?>">
                <span class="invalid-feedback"><?php echo $nft_description_err; ?></span>
            </div>
            <div class="form-group">
                <label>Listing Price</label>
                <input type="number" min="0" name="nft_price" class="form-control <?php echo (!empty($nft_price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nft_price; ?>">
                <span class="invalid-feedback"><?php echo $nft_price_err; ?></span>
            </div>
            <div class="form-group">
                <label>Listing Picture URL</label>
                <input type="text" name="nft_picture" class="form-control <?php echo (!empty($nft_picture_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nft_picture; ?>">
                <span class="invalid-feedback"><?php echo $nft_picture_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
        </form>
    </div>
</body>

</html>