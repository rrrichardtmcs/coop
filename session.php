<?php
session_start();

if (isset($_SESSION['surname']) && $_SESSION['membership_number']) {
    $conn = mysqli_connect('5.134.12.203', 'peachpreviewco_coopuser', 'H$Sr7b4,R?)j', 'peachpreviewco_coop');
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    $sql = "UPDATE members SET signed_in = 0 WHERE membership_number = '" . $_SESSION['membership_number'] .  "' AND surname = '" . $_SESSION['surname'] . "'";
    $result = mysqli_query($conn, $sql);
    $_SESSION['signed_in'] = 0;
    session_destroy();
    msqli_close($conn);
}
?>