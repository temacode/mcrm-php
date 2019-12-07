<?php
function show_client_info($name, $tel, $email) {
    $button = '<p style="cursor: pointer;" onclick="alert(\'Имя: '.$name.'\nТелефон: '.$tel.'\nПочта: '.$email.'\');">Связаться <br>с клиентом</p>';
    return $button;
}
?>
<div class="include">
    <h3>Заказы в работе <span style="color: #909090; font-size: 15px;">ведутся работы</span></h3>
    <div class="include-content include-object" id="timetableChangeBlock">
        <div class="close-btn" id="closeBtn"><i class="fas fa-times"></i></div>
        <h4>Время доставки</h4>
        <form action="crm-php/crm-func.php" method="post">
            <input type="text" name="id" placeholder="Введите номер заказа" id="orderNum">
            <p>Выберите новый промежуток</p>
            <div class="select-time">
            <select name="delivery_first" id="first"></select>
            <select name="delivery_second" id="second"></select>
            </div>
            <div class="select-date">
            <select name="day" id="day"></select>
            <select name="month" id="month"></select>
            <select name="year" id="year"></select>
            </div>
            <button type="submit" name="submit-change-delivery-time">Отправить</button>
        </form>
    </div>
    <script src="js/timetable_anim.js">
    </script>
    <div class="include-content">
        <div class="btn inline-btn grid-btn">
            <a href="index.php?type=order_new">Все заказы</a>
        </div>
        <div class="btn inline-btn grid-btn red-btn">
            <a href="index.php?type=order_new&status=0">Забрать</a>
        </div>
        <div class="btn inline-btn grid-btn yellow-btn">
            <a href="index.php?type=order_new&status=1">В работе</a>
        </div>
        <div class="btn inline-btn grid-btn green-btn">
            <a href="index.php?type=order_new&status=2">Отдать</a>
        </div>


        <?php
        include('../php/connect.php');
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            $orders = mysqli_query($connect, "SELECT * FROM order_new WHERE (status = $status) AND city = '$user_city'") or die(mysqli_error($connect));
        } else {
            $orders = mysqli_query($connect, "SELECT * FROM order_new WHERE (status<3 OR status = 4) AND city = '$user_city'") or die(mysqli_error($connect));
        }
        while($order = mysqli_fetch_array($orders)) {
            $id = $order['id'];
            $client_id = $order['client_id'];
            $address = $order['address'];
            $date_day = $order['date_day'];
            $date_time = $order['date_time'];
            if ($order['date_delivery'] !== NULL) {
                $date_delivery_arr = explode('-', $order['date_delivery']);
                $date_delivery = $date_delivery_arr[2].'.'.$date_delivery_arr[1].'.'.$date_delivery_arr[0].'<br> c '.$order['delivery_first'].' до '.$order['delivery_second'];
            } else {
                $date_delivery = 'Обратная доставка еще  не назначена<button title="Изменить время доставки" onclick="showDeliveryChange('.$order['id'].')"><i class="fas fa-truck"></i></button>';
            }
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
                <th>Доставка</th>
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
                <td>'.$date_delivery.'</td>
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
                        <button type="submit" name="submit_up" value="delete" name="delete" title="Удалить заказ"><i class="fas fa-trash-alt"></i></button>
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