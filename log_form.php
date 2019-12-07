<?php
if (isset($_GET['getout'])) {
    if (isset($_COOKIE['id'])) {
                setcookie("id",'', (time()-3600*6), '/');
                setcookie("hash",'', (time()-3600*6),'/', null, null, true); // httponly !!!
                setcookie("name",'', (time()-3600*6), '/');
    }
}
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
// Соединямся с БД
include('../php/connect.php');
$link = $connect;
if(isset($_POST['submit']))
{
    // Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_name, user_id, user_password FROM users WHERE     user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_array($query);
    // Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        // Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));
        // Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' WHERE user_id='".$data['user_id']."'") or die(mysqli_error($link));
        // Ставим куки
        setcookie("id", $data['user_id'], (time()+3600*6), '/');
        setcookie("hash", $hash, (time()+3600*6),'/'); // httponly !!!
        setcookie("name", $data['user_name'], (time()+3600*6), '/');
        // Переадресовываем браузер на страницу проверки нашего скрипта
        header('Location: index.php');
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Вход</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Мобильная версия-->
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/crm-style-mobile.css">
        <!--Десктоп-->
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 450px)" href="css/crm-style.css">
    </head>
    <body>
        <div class="log-form">
            <h5>Вход</h5>
            <form method="POST">
                <input name="login" type="text" required placeholder="Логин"><br>
                <input name="password" type="password" required placeholder="Пароль"><br>
                <button name="submit" type="submit">Войти</button>
            </form>
        </div>
    </body>
</html>