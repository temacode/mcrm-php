<?php
function get_mail_delivery($date_delivery, $shoe_num, $client_name, $client_tel, $client_email, $sum, $order_discount, $for_delivery, $commit, $address, $date_day, $date_time, $city = 0) {
    if ($city ===  'spb') {
        $color = '#DD0500';
    } else {
        $color =  '#0088DD';
    }
    $content ='
    <!DOCTYPE html>
<html bgcolor="'.$color.'">
    <head>
        <title>Письмо</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>  
            html, body {
                background-color: '.$color.';
            }
            /*import url(https://fonts.googleapis.com/css?family=Roboto);
            font-family: Arial, Helvetica, sans-serif;
            font-family: "Arial Black", Gadget, sans-serif;
            font-family: Georgia, serif;
            font-family: "MS Sans Serif", Geneva, sans-serif;
            font-family: "MS Serif", "New York", sans-serif;
            font-family: Tahoma, Geneva, sans-serif;
            font-family: "Times New Roman", Times, serif;
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-family: Verdana, Geneva, sans-serif; */
            p,a,b,h4,h3,h2,h1,span {
                font-family: sans-serif;
                color: '.$color.';
            }
            h1 {
                font-family: "Arial Black", Gadget, sans-serif;
                font-size: 30px;
            }
            h2 {
                font-size: 20px;
            }
            h3 {
                color: #eaeaea;
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            ul li {
                border-bottom: 1px solid '.$color.';
            }
            /* Type styles for all clients */
            @media screen and (max-width:480px) {
                table {
                    width: 100%!important;
                }
                h1 {
                    font-size: 1.5em;
                }
                img {
                    width: 100%;
                }
            }
            /* Type styles for WebKit clients */
            
            @media screen and (-webkit-min-device-pixel-ratio:0) {
                @media screen and (max-width:480px) {
                    table {
                        width: 100%!important;
                    }
                }
        </style>
    </head>
    <body bgcolor="'.$color.'" style="padding: 10px; margin: 0;">
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px; border-bottom: 10px solid white;">
                    <img src="https://cleantwins.ru/pic/ct2-blue.png" width="120px" alt="Логотип cleantwins.ru">
                </td>
                <td width="70%" style="border-bottom: 10px solid white;">
                    <h1 align="center">CLEANTWINS</h1>
                    <h2 align="center">Информация курьеру</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 2px solid #eaeaea;"></td>
            </tr>
        </table>
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px;" colspan="2">
                    <p style="display: block; padding: 20px;">Вся информация по заказу представлена ниже:</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Время доставки</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$date_delivery.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Количество пар</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$shoe_num.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Имя заказчика</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$client_name.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Телефон</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$client_tel.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Почта</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$client_email.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Сумма</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$sum.'-'.$order_discount.'%='.($sum-($sum/100*$order_discount)).'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Обувь и тип чистки</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$for_delivery.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Комментарии</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$commit.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Адрес доставки</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$address.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Дата заказа</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted '.$color.';">'.$date_day.'-'.$date_time.'</p>
                </td>
            </tr>
            <tr>
                <td><p style="color: #eaeaea; margin: 10px; font-size: 10px;">Copyright © 2017-2018 All rights reserved</p></td>
                <td align="right" style="padding: 20px;"><h3>CLEANTWINS</h3></td>
            </tr>
        </table>
    </body>
</html>
';
    return $content;
}
function get_mail_request($shoe_num, $client_name, $client_tel, $client_email, $address, $date_day, $date_time, $city = 0) {
    $content ='
    <!DOCTYPE html>
<html bgcolor="#0088dd">
    <head>
        <title>Письмо</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>  
            html, body {
                background-color: #0088dd;
            }
            /*import url(https://fonts.googleapis.com/css?family=Roboto);
            font-family: Arial, Helvetica, sans-serif;
            font-family: "Arial Black", Gadget, sans-serif;
            font-family: Georgia, serif;
            font-family: "MS Sans Serif", Geneva, sans-serif;
            font-family: "MS Serif", "New York", sans-serif;
            font-family: Tahoma, Geneva, sans-serif;
            font-family: "Times New Roman", Times, serif;
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-family: Verdana, Geneva, sans-serif; */
            p,a,b,h4,h3,h2,h1,span {
                font-family: sans-serif;
                color: #0088dd;
            }
            h1 {
                font-family: "Arial Black", Gadget, sans-serif;
                font-size: 30px;
            }
            h2 {
                font-size: 20px;
            }
            h3 {
                color: #eaeaea;
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            ul li {
                border-bottom: 1px solid #0088dd;
            }
            /* Type styles for all clients */
           @media screen and (max-width:480px) {
                table {
                    width: 100%!important;
                }
                h1 {
                    font-size: 1.5em;
                }
                img {
                    width: 100%;
                }
            }
            /* Type styles for WebKit clients */
            
            @media screen and (-webkit-min-device-pixel-ratio:0) {
                @media screen and (max-width:480px) {
                    table {
                        width: 100%!important;
                    }
                }
        </style>
    </head>
    <body bgcolor="#0088dd" style="padding: 10px; margin: 0;">
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px; border-bottom: 10px solid white;">
                    <img src="https://cleantwins.ru/pic/ct2-blue.png" width="120px" alt="Логотип cleantwins.ru">
                </td>
                <td width="70%" style="border-bottom: 10px solid white;">
                    <h1 align="center">CLEANTWINS</h1>
                    <h2 align="center">Новая заявка</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 2px solid #eaeaea;"></td>
            </tr>
        </table>
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px;" colspan="2">
                    <p style="display: block; padding: 20px;">Вся информация по заказу представлена ниже:</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Количество пар</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$shoe_num.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Имя заказчика</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$client_name.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Телефон</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$client_tel.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Почта</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$client_email.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Адрес доставки</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$address.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Дата заказа</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$date_day.'-'.$date_time.'</p>
                </td>
            </tr>
            <tr>
                <td><p style="color: #eaeaea; margin: 10px; font-size: 10px;">Copyright © 2017-2018 All rights reserved</p></td>
                <td align="right" style="padding: 20px;"><h3>CLEANTWINS</h3></td>
            </tr>
        </table>
    </body>
</html>
';
    return $content;
}
function get_mail_client($name, $shoe_num, $address, $date_day, $date_time) {
    $content ='
    <!DOCTYPE html>
<html bgcolor="#0088dd">
    <head>
        <title>Письмо</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <style>  
            html, body {
                background-color: #0088dd;
            }
            /*import url(https://fonts.googleapis.com/css?family=Roboto);
            font-family: Arial, Helvetica, sans-serif;
            font-family: "Arial Black", Gadget, sans-serif;
            font-family: Georgia, serif;
            font-family: "MS Sans Serif", Geneva, sans-serif;
            font-family: "MS Serif", "New York", sans-serif;
            font-family: Tahoma, Geneva, sans-serif;
            font-family: "Times New Roman", Times, serif;
            font-family: "Trebuchet MS", Helvetica, sans-serif;
            font-family: Verdana, Geneva, sans-serif; */
            p,a,b,h4,h3,h2,h1,span {
                font-family: sans-serif;
                color: #0088dd;
            }
            h1 {
                font-family: "Arial Black", Gadget, sans-serif;
                font-size: 30px;
            }
            h2 {
                font-size: 20px;
            }
            h3 {
                color: #eaeaea;
            }
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            ul li {
                border-bottom: 1px solid #0088dd;
            }
            /* Type styles for all clients */
            @media screen and (max-width:480px) {
                table {
                    width: 100%!important;
                }
                h1 {
                    font-size: 1.5em;
                }
                img {
                    width: 100%;
                }
            }
            /* Type styles for WebKit clients */
            
            @media screen and (-webkit-min-device-pixel-ratio:0) {
                @media screen and (max-width:480px) {
                    table {
                        width: 100%!important;
                    }
                }
        </style>
    </head>
    <body bgcolor="#0088dd" style="padding: 10px; margin: 0;">
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px; border-bottom: 10px solid white;">
                    <img src="https://cleantwins.ru/pic/ct2-blue.png" width="120px" alt="Логотип cleantwins.ru">
                </td>
                <td width="70%" style="border-bottom: 10px solid white;">
                    <h1 align="center">CLEANTWINS</h1>
                    <h2 align="center">Заказ с сайта</h2>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 2px solid #eaeaea;"></td>
            </tr>
        </table>
        <table width="600"  bgcolor="white" style="margin: auto; padding: 0;" cellspacing="0" border="0" align="center">
            <tr>
                <td style="padding: 10px;" colspan="2">
                    <p style="display: block; padding: 20px;">Добрый день, '.$name.'! Спасибо, что оставили заявку на чистку на нашем сайте. Наш оператор свяжется с Вами в ближайшее время для подтверждения заказа и уточнения времени забора. </p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Количество пар</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$shoe_num.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Адрес доставки</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$address.'</p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0;">Дата заказа</p>
                </td>
                <td align="center" style="padding: 20px;">
                    <p style="display: block; height: 100%; padding: 5px; margin: 0; border-bottom: 2px dotted #0088dd;">'.$date_day.'-'.$date_time.'</p>
                </td>
            </tr>
            <tr>
                <td><p style="color: #eaeaea; margin: 10px; font-size: 10px;">Copyright © 2017-2018 All rights reserved</p></td>
                <td align="right" style="padding: 20px;"><h3>CLEANTWINS</h3></td>
            </tr>
        </table>
    </body>
</html>
';
    return $content;
}
?>