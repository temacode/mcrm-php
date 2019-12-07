<?php
function show_client_info($name, $tel, $email) {
    $button = '<p style="cursor: pointer;" onclick="alert(\'Имя: '.$name.'\nТелефон: '.$tel.'\nПочта: '.$email.'\');">Связаться <br>с клиентом</p>';
    return $button;
}
?>
   <div class="include">
    <h3>Закрытые заказы</h3>
    <div class="include-content">
    <?php
        include('../php/connect.php');
        $orders = mysqli_query($connect, "SELECT * FROM order_new WHERE (status = 3 OR status = 5) AND city = '$user_city' ORDER BY id DESC") or die(mysqli_error($connect));
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
                    $status_color = '';
                    break;
                case '4':
                    $status = 'Открыт заново';
                    $status_color = '#F7DADA';
                    break;
                case '5':
                    $status = 'Отменен';
                     $status_color = '#F7DADA';
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
                        <input type="hidden" value="'.$id.'" name="id">
                        <input type="hidden" value="'.$order['status'].'" name="status">
                        <button type="submit" name="submit_up" value="reopen" title="Снова открыть заказ"><i class="fas fa-plus"></i></button>
                    </form>
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