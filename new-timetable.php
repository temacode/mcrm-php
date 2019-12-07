<div class="timetable">
        <div class="timetable-time-block">
            <div class="timetable-blank"></div>
            <ul>
                <?php
            for ($i=9;$i<=21;$i++) {
                echo '<li><p>'.$i.'</p></li>';
            }
            ?>
            </ul>
        </div>
        <div class="timetable-timeline">
<?php
$time_arr = array (9,10,11,12,13,14,15,16,17,18,19,20,21);
include('../php/connect.php');
$result = mysqli_query($connect, "SELECT * FROM courier");
$courier = array();
while ($gap = mysqli_fetch_array($result)) {
    $key = $gap['day'];
    $time = explode('-', $gap['time']);
        $first = $time[0];
        $second = $time[1];
        $courier[$key][] = array(
            'first' => $first,
            'second' => $second
        );
}
$result = mysqli_query($connect, "SELECT * FROM order_new WHERE (status = 0 OR status = 2 OR status = 4) AND city = '$user_city'");
while ($order = mysqli_fetch_array($result)) {
    $key = $order['date_delivery'];
    $id = $order['id'];
    $address = $order['address'];
    $first = $order['delivery_first'];
    $second = $order['delivery_second'];
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
    $order_arr[$key][] = array(
        'id' => $id,
        'address' => $address,
        'first' => $first,
        'second' => $second,
        'color' => $status_color
    );
}
foreach($courier as $key => $value) {
    $gap_arr[$key] = array();
    $time_arr = array (9,10,11,12,13,14,15,16,17,18,19,20,21);
    for ($i=0;$i<count($courier[$key]);$i++) {
        foreach ($time_arr as $time_key => $time_value) {
            if ($time_arr[$time_key] >= $courier[$key][$i]['first'] && $time_arr[$time_key] <= $courier[$key][$i]['second']) {
                unset($time_arr[$time_key]);
            }
        }
    }

    $first = array_shift($time_arr);
    $previous_val = $first;
    foreach ($time_arr as $time_key => $time_value) {
        if ($time_value !== $first && $time_value !== $previous_val+1) {
            $second = $previous_val;
            $gap_arr[$key][] = array(
                'first' => $first,
                'second' => $second
            );
            $first = $time_value;
            $previous_val = $time_value;
        } else {
            if ($time_value === end($time_arr)) {
                $second = $time_value;
                $gap_arr[$key][] = array(
                'first' => $first,
                'second' => $second
            );
            }
            $previous_val = $time_value;
        }
    }
}
foreach($gap_arr as $key => $value) {
        echo '<div class="timetable-day">
    <div class="timetable-day-name">
        <p>'.$key.'</p>
    </div>
    <div class="timetable-layout">';
    for($i=0;$i<count($gap_arr[$key]);$i++) {
        echo '<div class="timetable-layout-block" style="width: calc((100%/13)*'.($gap_arr[$key][$i]['second']-$gap_arr[$key][$i]['first']+1).');margin-left: calc((100%/13)*'.($gap_arr[$key][$i]['first']-9).');"></div>';
    }
    echo '</div>';
    if (array_key_exists($key, $order_arr)) {
        for($i=0;$i<count($order_arr[$key]);$i++) {
        echo '
        <div class="timetable-day-task-block">
            <div class="timetable-day-task" style="width: calc((100%/13)*'.($order_arr[$key][$i]['second']-$order_arr[$key][$i]['first']+1).' - 1px);margin-left: calc((100%/13)*'.($order_arr[$key][$i]['first']-9).'); background-color: '.$order_arr[$key][$i]['color'].';">
                <h4>Заказ '.$order_arr[$key][$i]['id'].'</h4>
                <p>'.$order_arr[$key][$i]['address'].'</p>
                <p class="time">c '.$order_arr[$key][$i]['first'].' до '.$order_arr[$key][$i]['second'].'</p>
            </div>
        </div>';
        }
    }
    echo '</div>';
}
?>
        </div>
    </div>