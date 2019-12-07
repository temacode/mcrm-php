<div class="include-content">
<script src="js/courier_anim.js"></script>
<form method="post" action="crm-php/crm-func.php">
<div class="time-between" id="timeBetween">
<p>Расписание</p>
<div class="timelinr"></div>
<?php
include('../php/connect.php');
function get_day_text($day_number) {
    switch ($day_number) {
        case 1:
            $day_text = 'понедельник';
            break;
        case 2:
            $day_text = 'вторник';
            break;
        case 3:
            $day_text = 'среду';
            break;
        case 4:
            $day_text = 'четверг';
            break;
        case 5:
            $day_text = 'пятницу';
            break;
        case 6:
            $day_text = 'субботу';
            break;
        case 7:
            $day_text = 'воскресенье';
            break;
    }
    return $day_text;
}
$date = date('Y-m-d');
$query = mysqli_query($connect, "SELECT * FROM courier WHERE day >= '$date' AND courierID = '$user_login'") or die(mysqli_query($connect));
$flag = array(
    date('Y-m-d', strtotime("+1 day")) => '',
    date('Y-m-d', strtotime("+2 day")) => '',
    date('Y-m-d', strtotime("+3 day")) => '',
    date('Y-m-d', strtotime("+4 day")) => '',
    date('Y-m-d', strtotime("+5 day")) => '',
    date('Y-m-d', strtotime("+6 day")) => '',
    date('Y-m-d', strtotime("+7 day")) => ''
);
while ($courier = mysqli_fetch_array($query)) {
    $day = $courier['day'];
    $time = $courier['time'];
    if(array_key_exists($day, $flag)) {
        $flag[$day] .= $time.'/';
    }
}
foreach($flag as $key => $value) {
    if ($value !== '') {
        $flag[$key] = substr($value, 0, -1);
    }
}
foreach($flag as $key => $value) {
    if ($value === '') {
        echo '<div class="time-between-container" id="'.$key.'">';
        echo '<p>'.$key.'</p>';
        echo '<div class="time-gap">';
        echo '<p>c</p>';
        echo '<select name="'.$key.'[]">';
        for ($i=9;$i<=20;$i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        echo '</select>';
        echo '<p>до</p>';
        echo '<select name="'.$key.'[]">';
        for ($i=10;$i<=21;$i++) {
            echo '<option value="'.$i.'">'.$i.'</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '<div class="plus-gap" onclick="newGap(\''.$key.'\')"><p>+</p></div>';
        echo '</div>';
    }
}
?>
<!-- ============= -->
</div>
<input type="hidden" name="user_login" value="<?php echo $user_login; ?>">
<button type="submit" name="submit-courier-timetable">Отправить</button>
</form>
</div>