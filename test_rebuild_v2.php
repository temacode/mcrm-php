<form method="post">
<button type="submit" name="rebuild_time">Отправить</button>
</form>
<?php
if (isset($_POST['rebuild_time'])) {
    include('../php/connect.php');
    $query = mysqli_query($connect, "SELECT id, date_day FROM request ");
    while ($row = mysqli_fetch_array($query)) {
        $id = $row['id'];
        $date = $row['date_day'];
        $date_arr = explode('.', $date);
        if (!isset($date_arr[2])) {
        } else {
            if (strlen($date_arr[0]) === 1) {
                $date_arr[0] = '0'.$date_arr[0];
            }
            if (strlen($date_arr[1]) === 1) {
                $date_arr[1] = '0'.$date_arr[1];
                if ($date_arr[1] === '00') {
                    $date_arr[1] = '01';
                }
            }
            $new_date = $date_arr[2].'.'.$date_arr[1].'.'.$date_arr[0];

            echo $id.'-';
            echo $new_date.'<br>';
        $update = mysqli_query($connect, "UPDATE request SET date_day_r = '$new_date' WHERE id = $id") or die(mysqli_error($connect));
        }
    }
}
?>