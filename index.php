<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    if(isset($_GET['error'])){
        echo "<p style='color:red;'>Incorrect Credentials</p>";
    }
    ?>
    <form action="/coop/authentication.php" method="post">
        <div>
            <label>Surname</label>
            <input type="text" name="surname" id="surname" required>
        </div>
        <div>
            <label>Membership Id</label>
            <input type="number" name="membership_number" id="membership_number" required>
        </div>
        <div>
            <button type="submit" name="submit">Log in</button>
        </div>
    </form>
    <a href="/coop/index.php">
        <button>Refresh Page</button>
    </a>
</body>
</html>