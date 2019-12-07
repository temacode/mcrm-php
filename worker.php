<?php
// Соединямся с БД
include('../php/connect.php');
$link=$connect;

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_array($query);

    if (($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
    {
        echo($userdata['user_hash']);
        echo($_COOKIE['hash']);
        setcookie("id", "", time() + 3600*6, '/');
        setcookie("hash", "", time() + 3600*6, '/');
        setcookie("name", "", time() + 3600*6, '/');
        print "Хм, что-то не получилось";
    }
    else
    {
        $user_city = $userdata['city'];
        //print "Привет, ".$userdata['user_login'].". Всё работает!";
    }
}
else
{
    header('Location: log_form.php');
}
function show_client_info($name, $tel, $email) {
    $button = '<p style="cursor: pointer;" onclick="alert(\'Имя: '.$name.'\nТелефон: '.$tel.'\nПочта: '.$email.'\');">Связаться <br>с клиентом</p>';
    return $button;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Работа</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/crm-style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>

<body>
    <div class="header">
        <div class="header-name">
            <h1><a href="index.php">BLANKSTUDIO</a></h1>
        </div>
        <div class="username">
            <a href="log_form.php?getout">Привет,
                <?php
                    echo($_COOKIE['name']);
                    ?>
            </a>
            <a href="log_form.php?getout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
    <div class="content">
        <div class="include">
            <h3>Заказы в работе</h3>
            <?php
                include('../php/connect.php');
                $orders = mysqli_query($connect, "SELECT * FROM order_new WHERE (status<3 OR status = 4) AND city = '$user_city'") or die(mysqli_error($connect));
        while($order = mysqli_fetch_array($orders)) {
            $id = $order['id'];
            $client_id = $order['client_id'];
            $address = $order['address'];
            $date_day = $order['date_day'];
            $date_time = $order['date_time'];
            $commit = $order['commit'];
            $sum = $order['sum'];
            switch ($order['status']) {
                case '0':
                    $status = 'Ждет забора';
                    $status_color = '#FFDBDB';
                    break;
                case '1':
                    $status = 'В работе';
                    $status_color = '#FBF9CB';
                    break;
                case '2':
                    $status = 'Ждет доставки';
                    $status_color = '#D5FBD5';
                    break;
                case '3':
                    $status = 'Закрыт';
                    break;
                case '4':
                    $status = 'Открыт заново';
                    $status_color = '#F7DADA';
                    break;
            }
            $client = mysqli_query($connect, "SELECT * FROM client WHERE id=$client_id LIMIT 1") or die(mysqli_error($connect));
            $client = mysqli_fetch_array($client);
            $client_info = show_client_info($client['name'], $client['tel'], $client['email']);
            echo('
            <div class="table-container">
            <table>
            <tr>
                <th>Номер</th>
                <th>Контакты</th>
                <th>Название обуви</th>
                <th>Услуга</th>
                <th>Адрес</th>
                <th>Получен</th>
                <th>Комментарии</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Управление</th>
            </tr>
            <tr>
                <td>'.$id.'</td>
                <td>'.$client_info.'</td>
                <td></td>
                <td></td>
                <td>'.$address.'</td>
                <td>'.$date_day.', '.$date_time.'</td>
                <td>'.$commit.'</td>
                <td>'.$sum.'</td>
                <td bgcolor="'.$status_color.'">'.$status.'</td>
                <td rowspan="1">
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$order['id'].'" name="id">
                        <input type="hidden" value="'.$order['status'].'" name="status">
                        <button type="submit" name="submit_up" value="up" title="Повысить статус"><i class="fas fa-chevron-up"></i></button>
                    </form>
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$order['id'].'" name="id">
                        <button type="submit" name="submit_up" value="delete"name="delete" title="Удалить заказ"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    <button title="Изменить время доставки" onclick="showDeliveryChange('.$order['id'].')"><i class="fas fa-truck"></i></button>
                </td>
            </tr>
            ');
            $shoes = mysqli_query($connect, "SELECT * FROM order_info WHERE order_id = $id") or die(mysqli_error($connect));
            while($shoe = mysqli_fetch_array($shoes)) {
                $shoe_name = $shoe['shoe_name'];
                switch ($shoe['type']) {
                case '0':
                    $type = 'CLASSIC';
                    break;
                case '1':
                    $type = 'CLASSIC+';
                    break;
                case '2':
                    $type = 'STANDART';
                    break;
                case '3':
                    $type = 'STANDART+';
                    break;
                case '4':
                    $type = 'PREMIUM';
                    break;
                case '5':
                    $type = 'PREMIUM+';
                    break;
                case '6':
                    $type = 'EXCLUSIVE';
                    break;
                case '7':
                    $type = 'EXCLUSIVE+';
                    break;
                default:
                    $type = $query2['type'];
                    break;
            }
                echo('
                <tr>
                    <td></td>
                    <td></td>
                    <td>'.$shoe_name.'</td>
                    <td>'.$type.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                ');
            }
            echo('</table></div>');
        }
            ?>
        </div>
    </div>
</body>

</html>
