<!-- Регистрация и проверка правильности ввода логина -->
<?php
    include "db_link.php";

    if( isset($_POST["submit"]) ) {
        $login = $_POST["login"];
        $password = $_POST["password"];

        $err = array();
        if( !preg_match("/^[a-zA-Z0-9]+$/", $login) ) {
            $err[] = "Логин может состоять только из букв английского алфавита и цифр";
        }
        
        if( strlen($login) < 3 || strlen($login) > 30 ) {
            $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
        }

        $sql = "SELECT * FROM `users` WHERE `user_login` LIKE '%$login%'";
        $res = mysqli_query($db_link, $sql);

        if( $res->num_rows > 0 ) {
            $err[] = "Пользователь с таким логином уже существует в базе данных";
        }

        if( count($err) == 0 ) { 
            $password = md5( md5( trim($password) ) );
            
            $sql = "INSERT INTO `users` SET `user_login`='$login', `user_password`='$password'";
            mysqli_query($db_link, $sql);
            
            header("Location: login.php"); 
            exit();
        }
        else {
            echo "<b>При регистрации произошли следующие ошибки:</b><br>";
            foreach($err AS $error) {
                echo $error."<br>";
            }
        }
    }
?>

<form method="POST">
Логин <input name="login" type="text"><br>
Пароль <input name="password" type="password"><br>
<input name="submit" type="submit" value="Зарегистрироваться">
</form>