<!-- Проверяет был ли пользовать авторизованным и если да, то автоматически заходит. Все происходит за счет проверки куки файлов -->
<?php
    include "db_link.php";

    if ( isset($_COOKIE["id"]) && isset($_COOKIE["hash"]) ) {  
        $c_uid  = $_COOKIE["id"];
        $c_hash = $_COOKIE["hash"];

        $sql = "SELECT * FROM `users` WHERE `user_id`=$c_uid LIMIT 1";
        $res = mysqli_query($db_link, $sql);

        $data = mysqli_fetch_assoc($res);

        if(
            ($data["user_hash"] !== $c_hash) || 
            ($data["user_id"]   !== $c_uid)
        ) {
            setcookie("id",   "", time() - 3600*24*30*12, "/");
            setcookie("hash", "", time() - 3600*24*30*12, "/");
            echo "Хм, что-то не получилось";
        }
        else
        {
            echo "Привет, ".$data['user_login'].". Всё работает!";
            header("Location: index.php"); exit();
        }
    }
    else {
        echo "Включите куки";
    }
?>