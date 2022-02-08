<?php
if(!isset($_COOKIE["email"])) {
    header('Location: http://localhost/php/form-oops/login.php');
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    setcookie("email", "", time() - 300, "/", "", 0);
    header('Location: http://localhost/php/form-oops/login.php');
}
require('utility/db-connection.php');
require("utility/users-list.php");
if(isset($_GET['update'])) {
    UsersList::updateUserInDB();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Page</title>
    <link rel="stylesheet" href="css/override.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/users.css">
</head>
<body>
    <div class="wrapper">
        <h1>Welcome!</h1>
        <p>User: <?php echo $_COOKIE["email"] ?></p>
        <h2>All Users:</h2>
        <?php
            if(!isset($_GET["email"])) {
        ?>
                <ul class="users-list">
                    <?php
                    UsersList::createUserList();
                    ?>
                </ul>
        <?php   }
            else {
        ?>
                <ul class="users-list">
                    <?php
                    UsersList::deleteUserFromDB();
                    UsersList::createUserList();
                    ?>
                </ul>
        <?php   }
        ?>
        <form method="post" class="submit-div" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>