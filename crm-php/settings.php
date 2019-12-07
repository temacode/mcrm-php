<?php
    // Настройки
    $mail->CharSet = 'utf-8';
    $mail->isSMTP(); 
    $mail->Host = 'smtp.mail.ru'; 
    $mail->SMTPAuth = true; 
    $mail->Username = 'noreply@cleantwins.ru'; 
    $mail->Password = 'ivanrodion2017'; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Port = 465;
    $mail->setFrom('noreply@cleantwins.ru', 'CLEANTWINS');
    $mail->setLanguage('ru', '/optional/path/to/language/directory/');
    
    // Письмо
    
    
    $mail->isHTML(true);
?>