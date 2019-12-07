<div class="include">
    <h3>Заказы в работе</h3>
    <table>
        <tr>
            <th>Номер</th>
            <th>Контакты</th>
            <th>Услуга</th>
            <th>Обувь</th>
            <th>Адрес</th>
            <th>Получен</th>
            <th>Время</th>
            <th>Отправлен</th>
            <th>Комментарии</th>
            <th>Сумма</th>
            <th>Статус</th>
            <th>Время доставки</th>
            <th></th>
        </tr>
        <script>
        function showSelect(id) {
    var selectFirst = document.getElementById("timeFirst"+id);
var selectSecond = document.getElementById("timeSecond"+id);
var h1 = document.getElementById("h1");
var h2 = document.getElementById("h2");
var i;
var time = "";
for (i = 9; i <= 21; i++) {
    if (length.i === 1) {
        time = "0"+i+":00";
    } else {
        time = i+":00";
    }
    selectFirst.innerHTML += "<option value=\""+i+"\">"+time+"</option>";
    var j = i+1;
    if (length.j === 1) {
        time = "0"+j+":00";
    } else {
        time = j+":00";
    }
    selectSecond.innerHTML += "<option value=\""+j+"\">"+time+"</option>";
}
selectFirst.onchange = function() {
    selectSecond.innerHTML = " ";
    for (i=Number(selectFirst.value);i<=21;i++) {
        if (length.i === 1) {
            time = "0"+(i+1)+":00";
        } else {
            time = (i+1)+":00";
        }
        selectSecond.innerHTML += "<option value=\""+(i+1)+"\">"+time+"</option>";
    } 
}
}
        function showDate(id) {
            var date = new Date();
            var day = document.getElementById('dayDelivery'+id);
            var month = document.getElementById('monthDelivery'+id);
            var year = document.getElementById('yearDelivery'+id);
            for (i=1;i<31;i++) {
                if (i===date.getDate()) {
                    day.innerHTML += '<option selected value="'+i+'">'+i+'</option>';
                } else {
                    day.innerHTML += '<option value="'+i+'">'+i+'</option>';    
                }
            }
            for (i=1;i<12;i++) {
                switch (i) {
                case 0:
                    var monthName = 'Январь';
                    break;
                case 1:
                    var monthName = 'Февраль';
                    break;
                case 2: 
                    var monthName = 'Март';
                    break;
                case 3:
                    var monthName = 'Апрель';
                    break;
                case 4:
                    var monthName = 'Май';
                    break;
                case 5:
                    var monthName = 'Июнь';
                    break;
                case 6:
                    var monthName = 'Июль';
                    break;
                case 7:
                    var monthName = 'Август';
                    break;
                case 8:
                    var monthName = 'Сентябрь';
                    break;
                case 9:
                    var monthName = 'Октябрь';
                    break;
                case 10:
                    var monthName = 'Ноябрь';
                    break;
                case 11:
                    var monthName = 'Декабрь';
                    break;
            }
                if (i===date.getMonth()) {
                    month.innerHTML += '<option selected value="'+i+'">'+monthName+'</option>';
                } else {
                    month.innerHTML += '<option value="'+i+'">'+monthName+'</option>';    
                }
            }
            for (i=(date.getFullYear()-1);i<(date.getFullYear()+2);i++) {
                if (i===date.getFullYear()) {
                    year.innerHTML += '<option selected value="'+i+'">'+i+'</option>';
                } else {
                    year.innerHTML += '<option value="'+i+'">'+i+'</option>';    
                }
            }    
        }
    </script>
        <?php
        include('../php/connect.php');
        /*Получаем все заказы*/
        $query = mysqli_query($connect,'SELECT * FROM order_new WHERE status < 3 OR status = 4');
        /*Задаеи отрицательный номер заказа*/
        $order_flag = -1;
        /*Построчно конвертируем в массив данных*/
        while ($query2 = mysqli_fetch_array($query)) {
            /*Отображать полную таблицу, если номер заказа новый*/
            if ($query2['order_id'] != $order_flag) {
                /*Ставим текущий номер заказа*/
                $order_flag = $query2['order_id'];
                /*Ставим полной отображение таблицы*/
                $full_order = true;
                /*Получем данные клиента*/
                $client = $query2['client_id'];
                $query_client = mysqli_query($connect, "SELECT * FROM client WHERE id=$client LIMIT 1") or die(mysqli_error($connect));
                $order_id = $query2['order_id'];
                $query_shoe = mysqli_query($connect, "SELECT * FROM order_info WHERE order_id=$order_id") or die(mysqli_error($connect));
                $query_client = mysqli_fetch_array($query_client);
            } else {
                $full_order = false;
            }
            /*Отображение статуса и типа чистки*/
            switch ($query2['status']) {
                case '0':
                    $status = 'Ждет забора';
                    break;
                case '1':
                    $status = 'В работе';
                    break;
                case '2':
                    $status = 'Ждет доставки';
                    break;
                case '3':
                    $status = 'Закрыт';
                    break;
                case '4':
                    $status = 'Открыт заново';
                    break;
            }
            switch ($query2['type']) {
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
            if ($full_order) {
                echo('
                <tr>
                    <td><p>'.$query2['order_id'].'</p></td>
                    <td><p style="cursor: pointer;" onclick="showContacts'.$query2['id'].'()">Связаться <br>с клиентом</p></td>
                    <script>
                        function showContacts'.$query2['id'].'() {                                
                        alert("Имя: '.$query_client['name'].'\nТелефон: '.$query_client['tel'].'\nПочта: '.$query_client['email'].'\n");
                            }
                    </script>
                    <td><p>'.$type.'</p></td>
                    <td><p>'.$query2['shoe_name'].'</p></td>
                    <td><p>'.$query2['address'].'</p></td>
                    <td><p>'.$query2['date_day'].'</p></td>
                    <td><p>'.$query2['date_time'].'</p></td>
                    <td><p>'.$query2['date_close'].'</p></td>
                    <td><p>'.$query2['commit'].'</p></td>
                    <td><p>'.$query2['sum'].'</p></td>
                    <td ');
                if ($status == 'Ждет забора') { echo('bgcolor="#FFDBDB"');}
                if ($status == 'В работе') { echo('bgcolor="#FBF9CB"');}
                if ($status == 'Ждет доставки') { echo('bgcolor="#D5FBD5"');}
                echo('><p>'.$status.'</p></td>
                <td> 
                    <p>С</p>
                    <select form="request'.$query2['id'].'" name="delivery_first" id="timeFirst'.$query2['id'].'"></select>
                    <p>До</p>
                    <select form="request'.$query2['id'].'" name="delivery_second" id="timeSecond'.$query2['id'].'"></select>
                    <select form="request'.$query2['id'].'" name="delivery_day" id="dayDelivery'.$query2['id'].'"></select>
                    <select form="request'.$query2['id'].'" name="delivery_month" id="monthDelivery'.$query2['id'].'"></select>
                    <select form="request'.$query2['id'].'" name="delivery_year" id="yearDelivery'.$query2['id'].'"></select>
                    <script>
                    showSelect('.$query2['id'].');
                    showDate('.$query2['id'].');
                    </script>
                </td>
                <td><p>
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$query2['id'].'" name="id">
                        <input type="hidden" value="'.$query2['status'].'" name="status">
                        <button type="submit" name="submit_up" title="Повысить статус"><i class="fas fa-chevron-up"></i></button>
                    </form>
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$query2['id'].'" name="id">
                        <button type="submit" name="submit-delete-order" title="Удалить заказ"><i class="fas fa-trash-alt"></i></button>
                    </form></p>
                </td>
            </tr>
            ');
            }
            if (!($full_order)) {
                echo('
                <tr>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p>'.$type.'</p></td>
                    <td><p>'.$query2['shoe_name'].'</p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p>'.$query2['commit'].'</p></td>
                    <td><p>'.$query2['sum'].'</p></td>
                    <td ');
                if ($status == 'Ждет забора') { echo('bgcolor="#FFDBDB"');}
                if ($status == 'В работе') { echo('bgcolor="#FBF9CB"');}
                if ($status == 'Ждет доставки') { echo('bgcolor="#D5FBD5"');}
                echo('><p>'.$status.'</p></td>
                <td></td>
                <td><p>
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$query2['id'].'" name="id">
                        <input type="hidden" value="'.$query2['status'].'" name="status">
                        <button type="submit" name="submit_up" title="Повысить статус"><i class="fas fa-chevron-up"></i></button>
                    </form>
                    <form action="crm-php/crm-func.php" method="post">
                        <input type="hidden" value="'.$query2['id'].'" name="id">
                        <button type="submit" name="submit-delete-order" title="Удалить заказ"><i class="fas fa-trash-alt"></i></button>
                    </form></p>
                </td>
                </tr>
                ');
            }
        }
        ?>
    </table>
</div>