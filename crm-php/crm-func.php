<?php
session_start();
include('../../php/connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Файлы phpmailer
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
function mailer($to, $header, $content) {
    $mail = new PHPMailer(true);
    include('settings.php');
    $mail->addAddress($to);
    $mail->Subject = $header;
    $mail->Body    = $content;
    $mail->send();
}
function console_log($str) {
    echo('<script> console.log("'.$str.'"); </script>');
}
function tel_cor ($str) {
    if ($str[0] == '+') {
        for ($i=0;$i<strlen($str)-1;$i++) {
            $str[$i]=$str[$i+1];
        }
        for ($i=0;$i<strlen($str)-1;$i++) {
            $str[$i]=$str[$i+1];
        }
        $str = mb_strimwidth($str,0,10);
    } else {
        if (strlen($str)==11) {
            for ($i=0;$i<strlen($str)-1;$i++) {
                $str[$i]=$str[$i+1];
            }
            $str = mb_strimwidth($str,0,10);
        } else {
            $str = mb_strimwidth($str,0,10);
        }
    }
    return $str;
}
function client_check ($name, $tel, $email, $city = 'mos') {
include('../../php/connect.php');
    $query = mysqli_query($connect, "SELECT * FROM client WHERE MATCH (tel) AGAINST ('$tel') ") or die(mysqli_error($connect));
    $query = mysqli_fetch_array($query);
    /*Если такой есть - увелчиваем количество заказов*/
    if (isset($query['tel'])) {
        if ($query['tel']==$tel) {
            $new_num = $query['orders_num']+1;
            $id = $query['id'];
            $query_n = mysqli_query($connect, "UPDATE client SET orders_num = $new_num WHERE id=$id") or die(mysqli_error($connect));
            return $check_status = $id;
        }
    } else { //Если нет - добавляем
        $name = $_POST['name'];
        $email = $_POST['mail'];
        $query_n = mysqli_query($connect, "INSERT INTO client (name, tel, email, city) VALUES ('$name', '$tel', '$email', '$city')") or die(mysqli_error($connect));
        $query = mysqli_query($connect, "SELECT MAX(id) FROM client") or die(mysqli_error($connect));
        $query = mysqli_fetch_array($query);
        $id = $query[0];
        return $check_status = $id;
    }
}
function encode($value) {
    return '=?UTF-8?B?'. base64_encode($value) .'?=';
}
if (isset($_POST['submit_up'])) {
        /*✚✚✚✚✚✚✚✚✚✚✚✚Если заказ закрывается, надо выставить время доставки автоматиески✚✚✚✚✚✚✚✚✚✚✚*/
        /*✚✚✚✚✚✚✚✚✚✚✚✚Если заказ закрывается, надо посчитать сумму✚✚✚✚✚✚✚✚✚✚✚*/
        $id=$_POST['id'];
        $action = $_POST['submit_up'];
        switch ($action) {
            case 'up':
                $status=$_POST['status'];
                $date_day = date('Y-m-d');
                if ($status == 4) {
                    $status = 3;
                } else {
                    $status++;
                }
                if ($status === 2) {
                    $query = mysqli_query($connect, "UPDATE order_new SET date_close = '$date_day', status = $status, date_delivery = NULL, delivery_first = 0, delivery_second = 0 WHERE id=$id") or die(mysqli_error($connect));
                } else {
                    $query = mysqli_query($connect, "UPDATE order_new SET date_close = '$date_day', status = $status WHERE id=$id") or die(mysqli_error($connect));
                }
                header('Location: ../index.php?type=order_new');
                break;
            case 'reopen':
                $query = mysqli_query($connect, "UPDATE order_new SET status=4 WHERE id=$id") or die(mysqli_error($connect));
                header('Location: ../index.php?type=base');
                break;
            case 'delete':
                $date_day = date('Y.m.d');
                $date_day = mysqli_real_escape_string($connect, $date_day);
                $query = mysqli_query($connect, "UPDATE order_new SET status=5, date_close = '$date_day' WHERE id=$id") or die(mysqli_error($connect));
                header('Location: ../index.php?type=order_new');
                break;
            case 'delete-request':
                $query = mysqli_query($connect, "UPDATE request SET status=2 WHERE id=$id") or die(mysqli_error($connect));
        header('Location: ../index.php?type=request');
                break;
        }
    }
/*✚✚✚✚✚✚✚✚✚✚✚✚Добавить кнопку отклонить заказ✚✚✚✚✚✚✚✚✚*/
    if (isset($_POST['submit-new-order'])) {
        if ($_POST['name']!='' && $_POST['tel']!='' && $_POST['address'] != '' && $_POST['shoe_num'] != '') {
        //if (true) {
            $name = $_POST['name'];
            $mail = $_POST['mail'];
            $address = $_POST['address'];
            $shoe_num = $_POST['shoe_num'];
            $date_day = date('Y-m-d');
            $date_time = date('G:i');
            //Удаление лишних символов в номере телефона
            $tel = tel_cor($_POST['tel']);
            $city = $_POST['city'];
            /*Проверка существования клиента в БД*/
            $client_check = client_check($name, $tel, $mail);
             $query = mysqli_query($connect, "SELECT * FROM discount WHERE status = 1") or trigger_error(mysql_error()." ".$query);
        $query = mysqli_fetch_array($query);
        $discount = $query['value'];
        $query = mysqli_query($connect, "INSERT INTO request (client_id, name, tel, email, city, address, date_day, date_time, shoe_num, discount) VALUES ('$client_check', '$name','$tel','$mail', '$city','$address','$date_day','$date_time','$shoe_num','$discount')") or die(mysqli_error($connect));
            $_SESSION['msg'] = 'Заявка успешно отправлена';
            header('Location: ../index.php?type=request');
        } else {
            $_SESSION['msg'] = 'Заполните все поля';
            header('Location: ../index.php?type=new');
        }
    }
    if (isset($_POST['submit-order-from-site'])) {
        $shoe_num = $_POST['shoe_num'];
        $name = $_POST['name'];
        $tel = tel_cor($_POST['tel']);
        $mail = $_POST['mail'];
        $address = $_POST['address'];
        $date_day = date('Y-m-d');
        $date_time = date('G:i');
        $client_check = client_check($name, $tel, $mail);
        $query = mysqli_query($connect, "SELECT value FROM discount WHERE status=1") or die(mysqli_error($connect));
        $query = mysqli_fetch_array($query);
        $discount = $query['value'];
        $city = $_POST['city'];
        $query = mysqli_query($connect, "INSERT INTO request (client_id, name, tel, email, address, date_day, date_time, shoe_num, city, discount) VALUES ('$client_check', '$name','$tel','$mail','$address','$date_day','$date_time','$shoe_num', '$city', '$discount')") or die(mysqli_error($connect));
        include('../mail.php');
        switch ($city) {
            case 'mos':
                $to = 'inbox@cleantwins.ru';
                break;
            case 'spb':
                $to = 'inbox.spb@cleantwins.ru';
                break;
            default:
                $to = 'inbox@cleantwins.ru';
                break;
        }
        $header = 'Заявка';
        $content = get_mail_request($shoe_num, $name, $tel, $mail, $address, $date_day, $date_time);
        mailer($to, $header, $content);
        $to = $mail;
        $header = 'Заявка на чистку';
        $content = get_mail_client($name, $shoe_num, $address, $date_day, $date_time);
        mailer($to, $header, $content);
        //$mail->send()
        $_SESSION['sent'] = 1;
        header('Location: ../../index.php');
}
/*✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚В таблице заказов для каждой обуви показывается цена за весь заказ. Выход - передавать сюда не цифру, а строку с ценой за каждый ботинок через слеш, а потом разбивать эту сроку на массив и вводить в бд церез цикл ка и type ✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚✚*/
if (isset($_POST['submit-ready-order'])) {
        $request_id = $_POST['id'];
        $client_id = $_POST['client_id'];
        $city = $_POST['city'];
        $shoe_num = $_POST['shoe_num'];
        $address = $_POST['address'];
        $date_day = $_POST['date_day'];
        $date_time = $_POST['date_time'];
        $delivery = $_POST['delivery'];
        $delivery_first = $_POST['delivery_first'];
        $delivery_second = $_POST['delivery_second'];
        $delivery_day = $_POST['delivery_day'];
        $delivery_month = $_POST['delivery_month'];
        $delivery_year = $_POST['delivery_year'];
        $date_delivery = $delivery_year.'.'.$delivery_month.'.'.$delivery_day;
        $date_delivery = mysqli_real_escape_string($connect, $date_delivery);
        $date_delivery_for_email = $date_delivery.', с '.$delivery_first.' до '.$delivery_second;
        $date_delivery_for_email = mysqli_real_escape_string($connect, $date_delivery_for_email);
        $commit = $_POST['commit'];
        $commit = mysqli_real_escape_string($connect, $commit);
		$order_final_sum = $_POST['order_final_sum']; //Фактическая сумма
		$sum = $_POST['order_sum']; //Сумма без скидки для писем
		$order_discount = $_POST['order_discount']; //Скидка для писем
        $query = mysqli_query($connect, "SELECT MAX(id) from order_new") or die(mysqli_error($connect));
        $query = mysqli_fetch_array($query);
        $id = $query[0]+1; //Получение номера предстоящего заказа
		$status = 1;
        $for_delivery = '';
        for ($i=0;$i<$shoe_num;$i++) {
			if (isset($_POST['type'][$i]) && isset($_POST['shoe_name'][$i])) {
				$type[$i] = $_POST['type'][$i];
                switch ($type[$i]) {
                case 0:
                    $shoe_type = 'CLASSIC';
                    break;
                case 1:
                    $shoe_type = 'CLASSIC+';
                    break;
                case 2:
                    $shoe_type = 'STANDART';
                    break;
                case 3:
                    $shoe_type = 'STANDART+';
                    break;
                case 4:
                    $shoe_type = 'PREMIUM';
                    break;
                case 5:
                    $shoe_type = 'PREMIUM+';
                    break;
                case 6:
                    $shoe_type = 'EXCLUSIVE';
                    break;
                case 7:
                    $shoe_type = 'EXCLUSIVE+';
                    break;
            }
				$shoe_name[$i] = $_POST['shoe_name'][$i];
                $for_delivery .= $shoe_name[$i].'-'.$shoe_type.'<br>';
				$shoe_name[$i] = mysqli_real_escape_string($connect, $shoe_name[$i]);
                $query = mysqli_query($connect, "INSERT INTO order_info (order_id, shoe_name, type) VALUES ('$id', '$shoe_name[$i]', '$type[$i]')") or die(mysqli_error($connect));
				$flag = 1;
			} else {
				$flag = 0;
				$_SESSION['msg'] = 'Не выбран тип чистки';
				header('Location: ../index.php?type=request');
				break;
			}
        }
		if ($flag==1) {
            $query = mysqli_query($connect, "INSERT INTO order_new (client_id, city, address, date_day, date_time, delivery, date_delivery, delivery_first, delivery_second, commit, sum) VALUES ('$client_id', '$city', '$address' ,'$date_day' ,'$date_time', '$delivery', '$date_delivery', '$delivery_first', '$delivery_second','$commit','$order_final_sum')") or die(mysqli_error($connect));
			$query = mysqli_query($connect, "UPDATE request SET status=$status WHERE id=$request_id") or die(mysqli_error($connect));
			$_SESSION['msg'] = 'Заказ успешно добавлен';
            $query_client = mysqli_query($connect, "SELECT * FROM client WHERE id=$client_id LIMIT 1") or die(mysqli_error($connect));
            $query_client = mysqli_fetch_array($query_client);
            include('../mail.php');
            switch ($city) {
            case 'mos':
            $to = 'delivery@cleantwins.ru';
            break;
            case 'spb':
            $to = 'delivery.spb@cleantwins.ru';
            break;
            default:
            $to = 'delivery@cleantwins.ru';
            break;
            }
            $header = 'Доставка-'.$id;
            $content = get_mail_delivery($date_delivery_for_email, $shoe_num, $query_client['name'], $query_client['tel'], $query_client['email'], $sum, $order_discount, $for_delivery, $commit, $address, $date_day, $date_time, $city);
            mailer($to, $header, $content);
            $to = 'inbox@cleantwins.ru';
            mailer($to, $header, $content);
        	header('Location: ../index.php?type=request');
		} else {
        	header('Location: ../index.php?type=request');
		}
}
if (isset($_POST['discount-change'])) {
    $new = $_POST['new_desc'];
    $old = $_POST['active_desc'];
    $query = mysqli_query($connect, "UPDATE discount SET status=0 WHERE id=$old") or die(mysqli_error($connect));
    $query = mysqli_query($connect, "UPDATE discount SET status=1 WHERE id=$new") or die(mysqli_error($connect));
    $_SESSION['msg'] = 'Новая скидка установлена!';
    header('Location: ../index.php?type=discount');
}
if (isset($_POST['submit-for-summary'])) {
    $year = $_POST['year'];
    $month = ($_POST['month']);
    $salary = ($_POST['salary']);
    $arsenal = ($_POST['arsenal']);
    $advert = ($_POST['advert']);
    $city = $_POST['city'];
    if ($month !== '' && $salary !== '' && $arsenal !== '' && $advert !== '' && $year !== '') {
        $query = mysqli_query($connect, "SELECT * FROM summary WHERE (year = $year AND month = $month) AND city = '$city' LIMIT 1") or die(mysqli_error($connect));
        $query = mysqli_fetch_array($query);
        if ($query['year'] == '' || $query['month'] == '') {
            $query = mysqli_query($connect, "INSERT INTO summary (year, month, salary, arsenal, advert, city) VALUES ('$year', '$month', '$salary', '$arsenal', '$advert', '$city')") or die(mysqli_error($connect));
        } else {
            $query = mysqli_query($connect, "UPDATE summary SET
            salary = $salary,
            arsenal=$arsenal,
            advert = $advert
            WHERE (year = $year AND month = $month) AND city = '$city'") or die(mysqli_error($connect));
        }
        header('Location: ../index.php?type=summary');
    } else {
        $_SESSION['msg'] = 'Заполните все поля';
        header('Location: ../index.php?type=summary');
    }
}
if (isset($_POST['submit-change-delivery-time'])) {
    $id = $_POST['id'];
    $delivery_first = $_POST['delivery_first'];
    $delivery_second = $_POST['delivery_second'];
    $day = $_POST['day'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $date_delivery = $year.'-'.$month.'-'.$day;
    if ($id == '') {
        $_SESSION['msg'] = 'Заполните все поля!';
        header('Location: ../index.php?type=timetable');
    } else {
        $change_order = mysqli_query($connect, "UPDATE order_new SET delivery_first = $delivery_first, delivery_second=$delivery_second, date_delivery='$date_delivery' WHERE id=$id LIMIT 1") or die(mysqli_error($connect));
        header('Location: ../index.php?type=order_new');
    }
}
if (isset($_POST['submit-edit-order'])) {
    $id = $_POST['id'];
    $city = $_POST['city'];
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $date_day = $_POST['date_day'];
    $delivery = $_POST['delivery'];
    $commit = $_POST['commit'];
    $sum = $_POST['sum'];
    $shoe = $_POST['shoe'];
    $sql = ' (order_id = \''.$id.'\') AND ';
    foreach ($shoe as $key => $value) {
        $sql .= 'id != '.$shoe[$key].' AND ';
    }
    $sql = substr($sql,0,-5);
    $query = mysqli_query($connect, "UPDATE order_new SET city='$city', address = '$address', date_day = '$date_day', delivery = '$delivery', commit = '$commit', sum = $sum WHERE id = $id ") or die(mysqli_error($connect));
    $query = mysqli_query($connect, "UPDATE order_info SET order_id = concat('0_', order_id) WHERE $sql") or die(mysqli_error($connect));
    if (isset($_POST['type'])) {
        $type = $_POST['type'];
        foreach ($type as $key => $value) {
            $name = $_POST['shoe_name'][$key];
            $value;
            $query = mysqli_query($connect, "INSERT INTO order_info (order_id, shoe_name, type) VALUES ($id, '$name', '$value')") or die(mysqli_error($connect));
        }
    }
    header('Location: ../index.php?type=order_edit');
}
if (isset($_POST['submit-courier-timetable'])) {
    $user_login = $_POST['user_login'];
    $data = array();
    foreach($_POST as $key => $value) {
        if ($key !== 'submit' && $key !== 'user_login') {
            $data[$key] = array();
            for ($i=0;$i<count($_POST[$key]);$i++) {
                $data[$key][] = array(
                    'first' => $_POST[$key][$i],
                    'second' => $_POST[$key][$i+1]
                );
                $i++;
            }
        }
        echo '<br>';
    }
    foreach($data as $key => $value) {
        foreach($data[$key] as $dataset) {
            if ($dataset['first']>=$dataset['second']) {
            } else {
                $time = $dataset['first'].'-'.$dataset['second'];
                $query = mysqli_query($connect, "INSERT INTO courier (courierID, day, time) VALUES ('$user_login', '$key', '$time')") or die(mysqli_error($connect));
            }
        }
    }
    header('Location: ../index.php?type=courier');
}
?>
