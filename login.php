<!-- Проверяет на правильность ввода логина и пароля -->
<?php
    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;  
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];  
        }
        return $code;
    }

    include "db_link.php";

    if( isset($_POST["submit"]) ) {
        $login = $_POST["login"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM `users` WHERE `user_login` LIKE '%$login%' LIMIT 1";
        $res = mysqli_query($db_link, $sql);

        $data = mysqli_fetch_assoc($res);

        if( $data["user_password"] === md5( md5($password) ) ) {
            $uid = $data["user_id"];
            $hash = md5( generateCode(10) );
            
            $sql = "UPDATE `users` SET `user_hash`='$hash' WHERE `user_id`=$uid";
            mysqli_query($db_link, $sql);
            
            setcookie("id",   $uid,  time()+60*60*24*30);
            setcookie("hash", $hash, time()+60*60*24*30);
            
            header("Location: check.php"); exit();
        }
        else {
            echo "Вы ввели неправильный логин/пароль";
        }
    }
?>
<form method="POST">
    Логин <input name="login" type="text"><br>
    Пароль <input name="password" type="password"><br>
    <input name="submit" type="submit" value="Войти">
</form>