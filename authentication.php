<?php
session_start();
$conn = mysqli_connect('5.134.12.203', 'peachpreviewco_coopuser', 'H$Sr7b4,R?)j', 'peachpreviewco_coop');
if (!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

if (isset($_GET['submit'])) {
    $_GET['surname'] = ucwords(trim($_GET['surname']));
    $_GET['membership_number'] = trim($_GET['membership_number']);

    try {
        $sql = "SELECT id, surname, membership_number, can_vote, voted, signed_in FROM members WHERE surname = '$_GET[surname]' AND membership_number = '$_GET[membership_number]'";
        $result = mysqli_query($conn, $sql);
        $members = mysqli_fetch_assoc($result);

        if ($members['membership_number'] == $_GET['membership_number'] && $members['surname'] == $_GET['surname'] && $members['can_vote'] == 1 && $members['signed_in'] == 0) {

            $_SESSION['surname'] = $members['surname'];
            $_SESSION['membership_number'] = $members['membership_number'];
            $_SESSION['signed_in'] = 1;
            $_SESSION['can_vote'] = 1;

            $sql = "UPDATE members SET signed_in = 1 WHERE membership_number = '" . $members['membership_number'] .  "'";
            $result = mysqli_query($conn, $sql);
            $arr = ['Status' => 'both', 'Video' => 'https://player.vimeo.com/video/457819618', 'Chat' => 'https://vimeo.com/live-chat/457819618/'];
            echo json_encode($arr);
            msqli_close($conn);

        } elseif ($members['membership_number'] == $_GET['membership_number']  && $members['surname'] == $_GET['surname'] && $members['can_vote'] == 0 && $members['signed_in'] == 0) {

            $_SESSION['surname'] = $members['surname'];
            $_SESSION['membership_number'] = $members['membership_number'];
            $_SESSION['signed_in'] = 1;
            $_SESSION['can_vote'] = 0;

            $sql = "UPDATE members SET signed_in = 1 WHERE membership_number = '" . $members['membership_number'] .  "'";
            $result = mysqli_query($conn, $sql);
            $arr = ['Status' => 'watch', 'Video' => 'https://player.vimeo.com/video/457819618', 'Chat' => false];
            echo json_encode($arr);
            msqli_close($conn);

        } elseif ($members['signed_in'] == 1 && $_SESSION['signed_in'] == 1) {

            $_SESSION['attempt'] = 1;

            $arr = ['Status' => 'signed in computer'];
            echo json_encode($arr);

        } elseif ($members['signed_in'] == 1 && $_SESSION['signed_in'] == 0) {

            $arr = ['Status' => 'signed in elsewhere'];
            echo json_encode($arr);

        } else {

            $arr = ['Status' => 'incorrect'];
            $arr['Error'] = 'Either your Surname or Membership Card Number is Incorrect. Make sure you have not added any spaces, or that you are not known by any other surname. For help logging in please contact xxxxxxx';
            echo json_encode($arr);
            
        }
    } catch (Exception $error) {
        echo $error;
    }
}
