<?php
include('../php/connect.php');
$orders = mysqli_query($connect, "SELECT * FROM orders") or die(mysqli_error($connect));
//$orders_arr = mysqli_fetch_array($orders);
$counter_order = 0;
$counter_order_info = 0;
$check_id = '';
while ($orders_arr = mysqli_fetch_array($orders)) {
    $id = $orders_arr['id'];
    $order_id = $orders_arr['order_id'];
    $type = $orders_arr['type'];
    $client_id = $orders_arr['client_id'];
    $address = $orders_arr['address'];
    $status = $orders_arr['status'];
    $date_day = $orders_arr['date_day'];
    $date_time = $orders_arr['date_time'];
    $delivery = $orders_arr['delivery'];
    if (intval($delivery == 0)) {
        $delivery = 0;
    }
    $date_del = $orders_arr['date_del'];
    $date_delivery = $orders_arr['date_delivery'];
    if ($date_delivery == '') {
        $date_delivery = '-';
    }
    $delivery_first = $orders_arr['delivery_first'];
    $delivery_second = $orders_arr['delivery_second'];
    $shoe_name = $orders_arr['shoe_name'];
    $commit = $orders_arr['commit'];
    $sum = $orders_arr['sum'];
    if ($order_id !== $check_id) {
        $check_id = $order_id;
        $data_order = array(
        'id'              => $id,
        'order_id'        => $order_id, 
        'client_id'       =>  $client_id,
        'address'         =>  $address,
        'status'          =>  $status,
        'date_day'        =>  $date_day ,
        'date_time'       =>  $date_time ,
        'delivery'        =>  $delivery ,
        'date_del'        =>  $date_del ,
        'date_delivery'   =>  $date_delivery ,
        'delivery_first'  =>  $delivery_first ,
        'delivery_second' =>  $delivery_second ,
        'commit'          =>  $commit ,
        'sum'             =>  $sum
        );
        $data_order_info = array(
        'id'              => $id,
        'order_id'        => $order_id, 
        'type'            => $type, 
        'shoe_name'       =>  $shoe_name ,
        ); 
        $data_arr_order[$counter_order] = $data_order;
        $counter_order++;
        $data_arr_order_info[$counter_order_info] = $data_order_info; 
        $counter_order_info++;
    } else {
        $data_order_info = array(
        'id'              => $id,
        'order_id'        => $order_id, 
        'type'            => $type, 
        'shoe_name'       =>  $shoe_name ,
        );   
        $data_arr_order_info[$counter_order_info] = $data_order_info; 
        $counter_order_info++;
    }
}
echo('Вывод заказов<br>');
for ($i=0; $i<count($data_arr_order); $i++) {
    $order_id = $data_arr_order[$i]['order_id'];
    $client_id = $data_arr_order[$i]['client_id'];
    $address = $data_arr_order[$i]['address'];
    $status = $data_arr_order[$i]['status'];
    $date_day = $data_arr_order[$i]['date_day'];
    $date_time = $data_arr_order[$i]['date_time'];
    $delivery = $data_arr_order[$i]['delivery'];
    $date_del = $data_arr_order[$i]['date_del'];
    $date_delivery = $data_arr_order[$i]['date_delivery'];
    $delivery_first = $data_arr_order[$i]['delivery_first'];
    $delivery_second = $data_arr_order[$i]['delivery_second'];
    $commit = $data_arr_order[$i]['commit'];
    $sum = $data_arr_order[$i]['sum'];
    $query = mysqli_query($connect, "INSERT INTO order_new (id, client_id, address, status, date_day, date_time, delivery, date_del, date_delivery, delivery_first, delivery_second, commit, sum) VALUES ('$order_id','$client_id','$address','$status','$date_day','$date_time','$delivery','$date_del','$date_delivery','$delivery_first','$delivery_second','$commit','$sum')") or die(mysqli_error($connect));
}
echo('Вывод состава заказов<br>');
for ($i=0; $i<count($data_arr_order_info); $i++) {
    $order_id = $data_arr_order_info[$i]['order_id'];
    $shoe_name = $data_arr_order_info[$i]['shoe_name'];
    $type = $data_arr_order_info[$i]['type'];
    $query = mysqli_query($connect, "INSERT INTO order_info (order_id, shoe_name, type) VALUES ('$order_id','$shoe_name','$type')") or die(mysqli_error($connect));
}
?>