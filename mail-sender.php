<!DOCTYPE html>
<html>
    <head>
        <title>Тестировщик</title>
        <meta charset="utf-8">
    </head>
    <body>
        <form action="#" method="get">
            <button type="submit" name="submit">Отправить</button>
        </form>
        <?php
        
function encode($value) {
    return '=?UTF-8?B?'. base64_encode($value) .'?=';
}
        if (isset($_GET['submit'])) {
            $from = 'noreply@cleantwins.ru';
            $to = 'test-1maq9@mail-tester.com';
            include('mail.php');
            $content = get_mail_content(345345,345345,345,345,345,345,67,7889,8709,234);
            $subject = encode('Уведомление-2');
            $message = $content;
            $headers = "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: CLEANTWINS <noreply@cleantwins.ru>\r\n";
            mail($to,$subject,$message,$headers, '-f'.$from) or die();
            //header('Location: mail-sender.php');
        }
        ?>
    </body>
</html>