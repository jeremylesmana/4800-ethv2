<?php
session_start();
require_once "config.php";
$id = (int)$_GET["listingID"];
$sql = "SELECT * FROM listing WHERE listingID = " . $id . ";";

$result = $link->query($sql);

if ($row = $result->fetch_assoc()) {
    $user_query = "SELECT id FROM userdata WHERE id = " . $row["listingOwnerId"];
    $user_result = $link->query($user_query)->fetch_assoc();
    if ($_SESSION['id'] == $user_result['id']) {
        $sql = "DELETE FROM listing WHERE listingID = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $row['listingID']);

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
} 
// header("location: index.php");
// exit;
