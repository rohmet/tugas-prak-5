<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>Comel</header>

    <div class="container">
        <section class="login-box">
            <h2>Login</h2>
            <form method="post" action="ceklogin.php">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>

            <?php
                if(isset($_GET['msg'])){
                    echo "<p style='color:red; text-align:center;'>".$_GET['msg']."</p>";
                }
            ?>
        </section>
    </div>

    <footer>@ by harahman abd arib / rohmet comel</footer>
</body>
</html>