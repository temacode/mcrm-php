<?php
session_start();
if (isset($_SESSION['msg'])) {
    if ($_SESSION['msg'] !== 0) {
        echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
        $_SESSION['msg'] = 0;
    }
}
?>
<div class="include">
    <h3>Заявки</h3>
    <?php
    include('../php/connect.php');
    include('controller/request-func.php');
    $requests = mysqli_query($connect, "SELECT * FROM request WHERE status=0") or die(mysqli_error($connect));
    while($request = mysqli_fetch_array($requests)) {
        $id = $request['id'];
        $client_id = $request['client_id'];
        $clients = mysqli_query($connect, "SELECT * FROM client WHERE id=$client_id") or die(mysqli_error($connect));
        $client = mysqli_fetch_array($clients);
        $client_name = $client['name'];
        $client_tel = $client['tel'];
        $client_email = $client['email'];
        $shoe_num = $request['shoe_num'];
        $address = $request['address'];
        $date_day = $request['date_day'];
        $date_time = $request['date_time'];
        $discount = $request['discount'];
        $selects = getSelects($id, $shoe_num);
        $names = getNames($id, $shoe_num);
        echo('
        <div class="table-cointainer">
        <form name="request-'.$id.'" action="crm-php/crm-func.php" method="post"></form>
        <table>
            <tr>
                <th>Номер</th>
                <th>Имя</th>
                <th>Количество пар</th>
                <th>Телефон</th>
                <th>Почта</th>
                <th>Адрес</th>
                <th>Получен</th>
                <th>Сумма заказа</th>
                <th>Скидка</th>
                <th></th>
            </tr>
            <tr>
                <td>'.$id.'</td>
                <td>'.$client_name.'</td>
                <td>'.$shoe_num.'</td>
                <td>'.$client_tel.'</td>
                <td>'.$client_email.'</td>
                <td>'.$address.'</td>
                <td>'.$date_day.', '.$date_time.'</td>
                <td></td>
                <td>'.$discount.'</td>
                <td></td>
            </tr>
            <tr>
                <th>Заполнение заявки</th>
            </tr>
            <tr>
                <td>'.$selects.'</td>
                <td>'.$names.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        ');
    }
    ?>
</div>