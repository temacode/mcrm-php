<?php
// Соединямся с БД
include('../php/connect.php');
$link=$connect;

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
    $query = mysqli_query($link, "SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_array($query);
    if (($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])) {
        setcookie("id", "", time() + 3600*6, '/');
        setcookie("hash", "", time() + 3600*6, '/');
        setcookie("name", "", time() + 3600*6, '/');
        //print "Хм, что-то не получилось";
    } else {
        $user_city = $userdata['city'];
        $user_login = $userdata['user_login'];
        switch ($userdata['status']) {
            case 0:
            $menu_list = array(
                'order_new' => 'Заказы в работе#fas fa-sign-out-alt',
                'base' => 'Визуализация БД#fas fa-database',
                'courier' => 'Курьер#fas fa-calendar-alt'
            );
            break;
            case 1: 
            $menu_list = array(
                'order_new' => 'Заказы в работе#fas fa-sign-out-alt',
                'request' => 'Заявки#fas fa-inbox',
                'new-order' => 'Добавление заказа#fas fa-plus-circle',
                'order_edit' => 'Изменение заказов#fas fa-edit',
                'base' => 'Визуализация БД#fas fa-database',
                'discount' => 'Активные скидки#fas fa-percent',
                'summary' => 'Сводка#fas fa-dollar-sign',
                'timetable' => 'Расписание#far fa-calendar-alt',
                'map' => 'Карта доставок#fas fa-map',
                'courier' => 'Курьер#fas fa-calendar-alt',
                'new-timetable' => 'Расписание курьеров#fas fa-calendar-alt'
            );
            break;
            case 2: 
            $menu_list = array(
                'courier_timetable' => 'Расписание#fas fa-calendar-alt',
                'courier' => 'Редактирование#fas fa-edit',
                'map' => 'Карта доставок#fas fa-map'
            );
            break;
            default:
            $menu_list = array(
                'lol' => 'Ошибка авторизации#fas fa-times'
            );
            break;
            break;
        }
    }   
} else {
    header('Location: log_form.php');
}
?>
