<?php
//Соединямся с БД
include('../php/connect.php');
$link = $connect;

if(isset($_POST['submit']))
{
    $err = [];

    // проверям логин
    if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Логин может состоять только из букв английского алфавита и цифр";
    }

    if (strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "Логин должен быть не меньше 3-х символов и не больше 30";
    }

    // проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'");
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "Пользователь с таким логином уже существует в базе данных";
    }

    // Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        // Убираем лишние пробелы и делаем двойное хеширование
        $password = md5(md5(trim($_POST['password'])));
        $name = $_POST['name'];

        mysqli_query($link,"INSERT INTO users SET user_name = '".$name."', user_login='".$login."', user_password='".$password."'") or die (mysqli_error($connect));
        header("Location: log_form.php"); exit();
    }
    else
    {
        print "<b>При регистрации произошли следующие ошибки:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Регистрация</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/crm-style.css">
    </head>
    <body>
        <div class="log-form">
            <h5>Регистрация</h5>
            <form method="POST">
                <input name="name" type="text" required placeholder="Имя"><br>
                <input name="login" type="text" required placeholder="Логин"><br>
                <input name="password" type="password" required placeholder="Пароль"><br>
                <button name="submit" type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </body>
</html>