<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    $user = $email = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update']) && isset($_POST['username']) && isset($_POST['email'])) {
        $user = $_POST['username'];
        $email = $_POST['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
</head>
<body>
    <div class="container_top">
        <h2>Update user: <?php echo $user?></h2>
        <a href="logged_in.php">Back</a>
        <div id="form_container">
            <form method="POST" action="change_name.php" style="display:inline;">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email);?>">
                <input class="input" type="text" id="new_username" name="new_username" placeholder="New username..." minlength="3" required> 
                <button class="input_b" type="submit">Update username</button>
            </form>

            <form method="POST" action="change_email.php" style="display:inline;">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email);?>">
                <input class="input" type="text" id="new_email" name="new_email" placeholder="Example@gmail.com..." required>
                <button class="input_b" type="submit">Update email</button>
            </form><br><br>

            <form method="POST" action="change_admin.php" style="display:inline;">
                <p>Has admin:</p>
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email);?>">
                <input type="radio" name="admin_status" id="yes" value="1" required>
                <label for="yes">Yes</label><br>
                <input type="radio" name="admin_status" id="no" value="0">
                <label for="yes">No</label><br><br>
                <button class="input_b" type="submit">Update admin status</button>
            </form>
        </div>
    </div>
</body>
</html>