<?php
if (isset($_SESSION['msg'])) {
    if ($_SESSION['msg'] !== 0) {
        echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
        $_SESSION['msg'] = 0;
    }
}
?>
<div class="include">
    <h3>Сводка</h3>
    <div class="help-table" id="absolute">
        <table>
            <tr>
                <th>Выберите месяц</th>
                <th>Средства</th>
                <th>Зарплата</th>
                <th>Реклама</th>
                <th></th>
            </tr>
            <tr>
                <form action="crm-php/crm-func.php" method="post" id="submit-summary"></form>
                <td>
                    <select name="year" form="submit-summary">
                        <option value="<?php include('../php/connect.php');echo((date('Y'))-1); ?>">
                            <?php include('../php/connect.php');echo((date('Y'))-1); ?>
                        </option>
                        <option value="<?php include('../php/connect.php');echo((date('Y'))); ?>" selected>
                            <?php include('../php/connect.php');echo((date('Y'))); ?>
                        </option>
                        <option value="<?php include('../php/connect.php');echo((date('Y'))+1); ?>">
                            <?php include('../php/connect.php');echo((date('Y'))+1); ?>
                        </option>
                    </select>
                    <select name="month" form="submit-summary">
                        <?php
                        for($i=1;$i<=12;$i++) {
                            $month = $i;
                            switch ($month) {
                                case 1:
                                    $month = 'Январь';
                                    break;
                                case 2:
                                    $month = 'Февраль';
                                    break;
                                case 3:
                                    $month = 'Март';
                                    break;
                                case 4:
                                    $month = 'Апрель';
                                    break;
                                case 5:
                                    $month = 'Май';
                                    break;
                                case 6:
                                    $month = 'Июнь';
                                    break;
                                case 7:
                                    $month = 'Июль';
                                    break;
                                case 8:
                                    $month = 'Август';
                                    break;
                                case 9:
                                    $month = 'Сентябрь';
                                    break;
                                case 10:
                                    $month = 'Октябрь';
                                    break;
                                case 11:
                                    $month = 'Ноябрь';
                                    break;
                                case 12:
                                    $month = 'Декабрь';
                                    break;
                            }
                            echo('<option value="'.$i.'" ');
                            if ($i == date('n')) {
                                echo('selected');
                            }
                            echo('>'.$month.'</option>');
                        }
                        ?>
                    </select>
                </td>
                <td><input type="number" name="arsenal" placeholder="0" form="submit-summary"></td>
                <td><input type="number" name="salary" placeholder="0" form="submit-summary"></td>
                <td><input type="number" name="advert" placeholder="0" form="submit-summary"></td>
                <td><input type="hidden" name="city" value="<?php echo $user_city; ?>" form="submit-summary"></td>
                <td><button type="submit" name="submit-for-summary" form="submit-summary">Отправить</button></td>
            </tr>
        </table>
    </div>
    <div class="include-content">
    <?php
    include('../php/connect.php');
    $query = mysqli_query($connect,"SELECT * FROM order_new WHERE (status = 3) AND city = '$user_city' ORDER BY id DESC");
    echo('
    <table>
    <tr>
    <th>Месяц</th>
    <th>Количество заказов</th>
    <th>Средства</th>
    <th>Курьер</th>
    <th>Зарплата</th>
    <th>Аренда</th>
    <th>Реклама</th>
    <th>Выручка</th>
    <th>Чистая прибиль</th>
    </tr>
    ');
    $order_data = array ();
    switch ($user_city) {
        case 'mos':
            $rent = 13680;
            $rent_txt = '13.680';
            break;
        case 'spb':
            $rent = 18750;
            $rent_txt = '18.750';
            break;
    }
    while ($query2 = mysqli_fetch_array($query)) {
        $month = explode('-', $query2['date_day']);
        $month = $month[1];
        switch ($month) {
            case '1':
                $month_txt = 'Январь';
                break;
            case '2':
						$month_txt = 'Февраль';
						break;
					case '3':
						$month_txt = 'Март';
						break;
					case '4':
						$month_txt = 'Апрель';
						break;
					case '5':
						$month_txt = 'Май';
						break;
					case '6':
						$month_txt = 'Июнь';
						break;
					case '7':
						$month_txt = 'Июль';
						break;
					case '8':
						$month_txt = 'Август';
						break;
					case '9':
						$month_txt = 'Сентябрь';
						break;
					case '10':
						$month_txt = 'Октябрь';
						break;
					case '11':
						$month_txt = 'Ноябрь';
						break;
					case '12':
						$month_txt = 'Декабрь';
						break;
				}
                $year = explode('-', $query2['date_day']);
                $year = $year[0];
        $order_data[] = array (
            'date_day' => $query2['date_day'],
            'month' => $month,
            'month_txt' => $month_txt,
            'year' => $year,
            'delivery' => intval($query2['delivery']),
            'sum' => intval($query2['sum']),
        );
    }
    $orders_data = array(
        'sum' => array(),
        'delivery' => array(),
        'orders_num' => array(),
        'arsenal' => array(),
        'salary' => array(),
        'advert' => array()
    );
    for ($i=0;$i<count($order_data);$i++) {
            $month_year = $order_data[$i]['year'].'-'.$order_data[$i]['month'].'-01';
            if (!(array_key_exists($month_year, $orders_data['sum']))) {
                $orders_data['sum'][$month_year] = 0;
                $orders_data['sum'][$month_year] += $order_data[$i]['sum'];
                $orders_data['delivery'][$month_year] = 0;
                $orders_data['delivery'][$month_year] += $order_data[$i]['delivery'];
                $orders_data['orders_num'][$month_year] = 0;
                $orders_data['orders_num'][$month_year]++;
                $month = $order_data[$i]['month'];
                $year = $order_data[$i]['year'];
                $options = mysqli_query($connect, "SELECT * FROM summary WHERE month = $month AND year = $year AND city = '$user_city' LIMIT 1") or die(mysqli_error($connect));
                $options = mysqli_fetch_array($options);
                if ($options === NULL) {
                    $options['arsenal'] = 0;
                    $options['salary'] = 0;
                    $options['advert'] = 0;
                }
                $orders_data['arsenal'][$month_year] = $options['arsenal'];
                $orders_data['salary'][$month_year] = $options['salary'];
                $orders_data['advert'][$month_year] = $options['advert'];
            } else {
                $orders_data['sum'][$month_year] += $order_data[$i]['sum'];
                $orders_data['delivery'][$month_year] += $order_data[$i]['delivery'];
                $orders_data['orders_num'][$month_year]++;
            }
        } 
    setlocale(LC_TIME, '');
    ksort($orders_data['sum'], SORT_LOCALE_STRING);
    $orders_data['sum'] = array_reverse($orders_data['sum']);
    foreach ($orders_data['sum'] as $key => $value) {
        $key_arr = explode('-', $key);
        switch ($key_arr[1]) {
            case '01':
                $month_txt = 'Январь';
                break;
            case '02':
						$month_txt = 'Февраль';
						break;
					case '03':
						$month_txt = 'Март';
						break;
					case '04':
						$month_txt = 'Апрель';
						break;
					case '05':
						$month_txt = 'Май';
						break;
					case '06':
						$month_txt = 'Июнь';
						break;
					case '07':
						$month_txt = 'Июль';
						break;
					case '08':
						$month_txt = 'Август';
						break;
					case '09':
						$month_txt = 'Сентябрь';
						break;
					case '10':
						$month_txt = 'Октябрь';
						break;
					case '11':
						$month_txt = 'Ноябрь';
						break;
					case '12':
						$month_txt = 'Декабрь';
						break;
				}
        echo('
                <tr>
                <td><p>'.$month_txt.'   <span style="color: #e0e0e0;">'.$key_arr[0].'</span></p></td>
                <td><p>'.$orders_data['orders_num'][$key].'</p></td>
                <td><p>'.$orders_data['arsenal'][$key].'</p></td>
                <td><p>'.$orders_data['delivery'][$key].'</p></td>
                <td><p>'.$orders_data['salary'][$key].'</p></td>
                <td><p>'.$rent_txt.'</p></td>
                <td><p>'.$orders_data['advert'][$key].'</p></td>
                <td><p>'.$value.'</p></td>
                <td><p>'.($value - ($orders_data['delivery'][$key]+$orders_data['advert'][$key] + $orders_data['salary'][$key] + $orders_data['arsenal'][$key] + $rent)).'</p></td>
                </tr>
                ');
    }
            echo('</table>');
            ?>
            </div>
</div>
