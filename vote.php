<?php
session_start();

$conn = mysqli_connect('5.134.12.203', 'peachpreviewco_coopuser', 'H$Sr7b4,R?)j', 'peachpreviewco_coop');
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

$sql = "UPDATE members SET voted = 1 WHERE membership_number = '" . $_SESSION['membership_number'] .  "'";
$result = mysqli_query($conn, $sql);
echo "You have successfully voted";

msqli_close($conn);

?>