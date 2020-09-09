<?php
$conn = mysqli_connect('localhost', 'richard', 'qwertyuiop', 'coop_database');

if(!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
}

if (isset($_POST['submit'])) {
    $sql = "SELECT id, surname, membership_number, can_vote FROM members WHERE surname = '$_POST[surname]'";

    $result = mysqli_query($conn, $sql);
    $members = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $credentials = $members[0];
    // mysqli_free_result($result);
    mysqli_close($conn);

    if($credentials['membership_number'] == $_POST['membership_number'] && $credentials['can_vote'] == 1){
        echo "Can Watch and Can Vote";
    } 
    elseif ($credentials['membership_number'] == $_POST['membership_number'] && $credentials['can_vote'] == 0){
        echo "Can Watch but Can't Vote";
    }
    else {
        echo "Incorrect Credentials";
        header("Location: http://localhost:8080/coop/index.php?error=credentials");
    }

    print_r($credentials);
}
?>