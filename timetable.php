<?php
        session_start();
        if (isset($_SESSION['msg'])) {
            if ($_SESSION['msg'] !== 0) {
                echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
                $_SESSION['msg'] = 0;
            }
        }
    ?>
<div class="include-content">
    <h4>Изменение заказа</h4>
    <form action="crm-php/crm-func.php" method="post">
        <input type="text" name="id" placeholder="Введите номер заказа">
        <p>Выберите новый промежуток</p>
        <select name="delivery_first" id="first"></select>
        <select name="delivery_second" id="second"></select>
        <select name="day" id="day"></select>
        <select name="month" id="month"></select>
        <select name="year" id="year"></select>
        <button type="submit" name="submit-change-delivery-time">Отправить</button>
    </form>
    <script src="js/timetable_anim.js">
        
    </script>
</div>
<div class="timetable" id="timetable"></div>
    <script>
        function showTimetable(counter, dayText, dayNumber) {
            var mainTable = document.getElementById('timetable');
            mainTable.innerHTML += '<div class="timetable-block" id="timetableBlock-'+counter+'"></div>';
            var timetableBlock = document.getElementById('timetableBlock-'+counter);
            timetableBlock.innerHTML = '<div class="timetable-day"><p>'+dayText+', '+dayNumber+'</p></div><ul class="time"></ul><ul class="table"></ul>';
            var time = timetableBlock.childNodes[1];
            var table = timetableBlock.lastChild;
            var date = new Date();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var minutesMargin = (((49)/60)*minutes);
            if (dayNumber === date.getDate()) {
                for (i=9;i<=21;i++) {
                    if (i===hours) {
                        table.innerHTML += '<span style="margin-top: '+minutesMargin+'px"></span>'
                    }
                table.innerHTML += '<li></li>';
            }
         } else {
                for (i=9;i<=21;i++) {
                table.innerHTML += '<li></li>';
            }   
            } 
            for (i=9;i<=21;i++) {
                var timeText = '';
                if (length.i===1) {
                    timeText = '0'+i+':00';
                } else {
                    timeText = i+':00';
                }
                time.innerHTML += '<li><p>'+timeText+'</p></li>'
            }
        }
        function insertTimetable(counter, id, first, second, address, shoeCounter, color) {
                if (first===0 || second===0) {
                    return 0;
                }
                var flag = 1;
                var timeFirst = '';
                var timeSecond = '';
                if ((length.first) === 1) {
                    timeFirst = '0'+first+':00';
                } else {
                    timeFirst = first+':00';
                }
                if ((length.second) === 1) {
                    timeSecond = '0'+second+':00';
                } else {
                    timeSecond = second+':00';
                }
                var timeText = timeFirst+'-'+timeSecond;
                var hoursNum = Number(second-first);
                var blockLi = document.getElementById('timetableBlock-'+counter).lastChild.getElementsByTagName('li');
                blockLi = blockLi[first-9];
                var displayHeight = 50*(hoursNum)-1;
                blockLi.innerHTML += '<div style="background-color: '+color+'; height: '+displayHeight+'px;" class="close-time-block"><h4>'+id+', Пар - '+shoeCounter+'</h4><h5>'+address+'</h5></div>';
            }
        function calculateTimetable(start, stop, id, address) {
                var table = document.getElementById('table');
                var flag = 0;
                var flagForObject = 0;
                flag = stop-start;
                flagForObject = 1;
                console.log(flag);
                for (i=9;i<=21;i++) {
                    if (length.i === 1) {
                        str = '0'+i+':00';
                    } else {
                        str = i+':00';
                    }
                    if (i >= start && flag > 0) {
                        if (flagForObject === 1) {
                            table.innerHTML += '<li><div class="close-time-block"><div class="close-time-block green"><h4>'+id+'</h4><h5>'+address+'</h5><div class="order-help"><p></p></div></div></div></li>';  
                            flagForObject = 0;
                        } else {
                            table.innerHTML += '<li><div class="close-time-block"><div class="close-time-block green"><h4></h4><h5></h5></div></div></li>'; 
                        }
                        flag--;
                    } else {
                        console.log(flag);
                        table.innerHTML += '<li><div class="close-time-block"><div class="close-time-block"><h4></h4><h5></h5><div class="order-help"><p></p></div></div></div></li>';
                    }
                }
            }
    </script>
        <?php
        function console_log ($string) {
            echo('<script> console.log("'.$string.'"); </script>');
        }
        function console_json($string) {
            echo('<script> var string = JSON.parse('.$string.'); console.log(string); </script>');
        }
        function get_geocode($address) {
            $address = str_replace(' ', '+', $address);
            $address = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?components=locality:Moscow|country=RU&address='.$address.'&key=AIzaSyDLOjt2bN7pS9JyG_chOozjasbHLHNi2o0'));
            $status = $address->status;
            if ($status === 'OK') {
                $address = ($address->results[0]->geometry->location->lat).','.($address->results[0]->geometry->location->lng);
                console_log($address);
                return $address;
            } else {
                console_log('Возникла ошибка при получении геокодов');
                return '';
            }
        }
        function get_time($start, $end) {
            $time = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$start.'&destinations='.$end.'&key=AIzaSyDLOjt2bN7pS9JyG_chOozjasbHLHNi2o0'));
            $status = $time->status;
            if ($status === 'OK') {
                $time = $time->rows[0]->elements[0]->duration->text;
                console_log($time);
                return $time;
            } else {
                console_log('Возникла ошибка при высчитывании расстояния между точками');
                return '';
            }
            $time = $time->rows[0]->elements[0]->duration->text;
            console_log($time);
            return $time;
        }
        function get_route($route) {
            $start_point = '55.8210471,37.6181268';
            
            $route = json_encode(file_get_contents('https://roads.googleapis.com/v1/snapToRoads?path='.$route.'&interpolate=true&key=AIzaSyDLOjt2bN7pS9JyG_chOozjasbHLHNi2o0'));
            console_json($route);
        }
        $query = mysqli_query($connect, "SELECT * FROM order_new WHERE (status = 0 OR status = 2 OR status = 4) AND city = '$user_city' ORDER BY date_delivery") or die(mysqli_error($connect));
        $counter = 0;
        while ($query_arr = mysqli_fetch_array($query)) {
            $id = $query_arr['id'];
            $status = $query_arr['status'];
            if ($status == 0) {
                $color = 'rgba(253, 135, 135, 0.3)';
            } else {
                $color = 'rgba(95, 203, 67, 0.3)';
            }
            $date_delivery = $query_arr['date_delivery'];
            $delivery_first = $query_arr['delivery_first'];
            $delivery_second = $query_arr['delivery_second'];
            $address = $query_arr['address'];
            $shoe_num = mysqli_query($connect, "SELECT id FROM order_info WHERE order_id=$id") or die(mysqli_error($connect));
            $shoe_counter = $shoe_num->num_rows;
            if ($date_delivery !== NULL ) {
                $date_delivery_arr = explode('-', $date_delivery);
                $date_delivery_day = intval($date_delivery_arr[2]);
                $date_delivery_month = intval($date_delivery_arr[1]);
                $date_delivery_year = intval($date_delivery_arr[0]);
                $data[$counter] = array(
                "id" => $id, 
                "shoe_counter" => $shoe_counter, 
                "delivery_first" => $delivery_first, 
                "delivery_second" => $delivery_second, 
                "address" => $address, 
                "day" => $date_delivery_day, 
                "month" => $date_delivery_month,
                "year" => $date_delivery_year, 
                "date_delivery" => $date_delivery,
                "color" => $color
                );    
                $counter++;
            }
            $shoe_counter = 1;
        } 
$counter = 1;
function get_day_text($day, $month, $year) {
    $day_number = date('N', mktime(0, 0, 0, $month, $day, $year));
    switch ($day_number) {
        case 1:
            $day_text = 'Понедельник';
            break;
        case 2:
            $day_text = 'Вторник';
            break;
        case 3:
            $day_text = 'Среда';
            break;
        case 4:
            $day_text = 'Четверг';
            break;
        case 5:
            $day_text = 'Пятница';
            break;
        case 6:
            $day_text = 'Суббота';
            break;
        case 7:
            $day_text = 'Воскресенье';
            break;
    }
    return $day_text; 
    }
$day = get_day_text($data[0]['day'],$data[0]['month'],$data[0]['year']);
$date = $data[0]['date_delivery'];
echo('<script> showTimetable('.$counter.', "'.$day.'", '.$data[0]['day'].'); </script>');
for ($i=0;$i<count($data);$i++) {
    $delivery_first = $data[$i]['delivery_first'];
    $delivery_second = $data[$i]['delivery_second'];
    $id = $data[$i]['id'];
    $address = $data[$i]['address'];
    $shoe_counter = $data[$i]['shoe_counter'];
    $color = $data[$i]['color'];
    if ($data[$i]['date_delivery'] == $date) {
        echo('
            <script>
                insertTimetable('.$counter.', '.$id.', '.$delivery_first.', '.$delivery_second.', "'.$address.'",'.$shoe_counter.', "'.$color.'");
            </script>
            ');    
    } else {
        $counter++;
        $date = $data[$i]['date_delivery'];
        $day = get_day_text($data[$i]['day'],$data[$i]['month'],$data[$i]['year']);
        echo('<script> showTimetable('.$counter.', "'.$day.'", '.$data[$i]['day'].'); </script>');
        echo('
            <script>
                insertTimetable('.$counter.', '.$id.', '.$delivery_first.', '.$delivery_second.', "'.$address.'",'.$shoe_counter.', "'.$color.'");
            </script>
            ');  
    }
}
        ?>