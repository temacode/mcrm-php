<?php
        if (isset($_SESSION['msg'])) {
            if ($_SESSION['msg'] !== 0) {
                echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
                $_SESSION['msg'] = 0;
            }
        }
    ?>
<div class="include">

<h3>Заявки с сайта</h3>
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
            for (i=1;i<=31;i++) {
                if (i===date.getDate()) {
                    day.innerHTML += '<option selected value="'+i+'">'+i+'</option>';
                } else {
                    day.innerHTML += '<option value="'+i+'">'+i+'</option>';    
                }
            }
            for (i=1;i<=12;i++) {
                switch (i) {
                case 1:
                    var monthName = 'Январь';
                    break;
                case 2:
                    var monthName = 'Февраль';
                    break;
                case 3: 
                    var monthName = 'Март';
                    break;
                case 4:
                    var monthName = 'Апрель';
                    break;
                case 5:
                    var monthName = 'Май';
                    break;
                case 6:
                    var monthName = 'Июнь';
                    break;
                case 7:
                    var monthName = 'Июль';
                    break;
                case 8:
                    var monthName = 'Август';
                    break;
                case 9:
                    var monthName = 'Сентябрь';
                    break;
                case 10:
                    var monthName = 'Октябрь';
                    break;
                case 11:
                    var monthName = 'Ноябрь';
                    break;
                case 12:
                    var monthName = 'Декабрь';
                    break;
            }
                if (i===date.getMonth()+1) {
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
	<div class="help-table" id="absolute">
		<table>
			<tr>
				<th>Тип чистки</th>
                <td>CLASSIC</td>
                <td>CLASSIC+</td>
                <td>STANDART</td>
                <td>STANDART+</td>
                <td>PREMIUM</td>
                <td>PREMIUM+</td>
                <td>EXCLUSIVE</td>
                <td>EXCLUSIVE+</td>
			</tr>
			<tr>
				<th>Цена</th>
				<td>900</td>
                <td>1200</td>
                <td>1600</td>
                <td>1900</td>
                <td>2200</td>
                <td>2500</td>
                <td>2900</td>
                <td>3200</td>
			</tr>
		</table>
    </div>
    <div class="include-content">
    <?php
        include('../php/connect.php');
        $query = mysqli_query($connect,"SELECT * FROM request WHERE (status = 0) AND city = '$user_city'") or die(mysqli_error($connect));
            while ($query2 = mysqli_fetch_array($query)) {
                echo('
        <div class="table-container">
            <table>
                <tr>
                    <th>Номер</th>
                    <th>Имя</th>
                    <th>Количество пар</th>
                    <th>Телефон</th>
                    <th>Почта</th>
                    <th>Адрес</th>
                    <th>Получен</th>
                    <th>Время</th>
                    <th>Сумма заказа</th>
                    <th>Скидка</th>
                    <th>Управление</th>
                </tr>
            ');
                $tel = $query2['tel'];
                $tel_r = '+7 ('.$tel[0].$tel[1].$tel[2].') '.$tel[3].$tel[4].$tel[5].'-'.$tel[6].$tel[7].'-'.$tel[8].$tel[9];
                $client = $query2['client_id'];
                $query_client = mysqli_query($connect, "SELECT * FROM client WHERE id=$client") or die(mysqli_error($connect));
                $query_client = mysqli_fetch_array($query_client);
                echo('
                
                <form id="request'.$query2['id'].'" action="crm-php/crm-func.php" method="post"></form>
                <input form="request'.$query2['id'].'" type="hidden" name="id" value="'.$query2['id'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="client_id" value="'.$client.'">
                <input form="request'.$query2['id'].'" type="hidden" name="city" value="'.$query2['city'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="shoe_num" value="'.$query2['shoe_num'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="email" value="'.$query_client['email'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="address" value="'.$query2['address'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="date_day" value="'.$query2['date_day'].'">
                <input form="request'.$query2['id'].'" type="hidden" name="date_time" value="'.$query2['date_time'].'">
				
                <input form="request'.$query2['id'].'" type="hidden" name="order_sum" id="orderSum'.$query2['id'].'">
				
                <input form="request'.$query2['id'].'" type="hidden" name="order_discount" id="orderDiscount'.$query2['id'].'">
				
                <input form="request'.$query2['id'].'" type="hidden" name="order_final_sum" id="orderFinalSum'.$query2['id'].'">
                <tr>
                    <td><p>'.$query2['id'].'</p></td>
                    <td><p>'.$query_client['name'].'</p></td>
                    <td><p>'.$query2['shoe_num'].'</p></td>
                    <td><p>'.$tel_r.'</p></td>
                    <td><p>'.$query_client['email'].'</p></td>
                    <td><p>'.$query2['address'].'</p></td>
                    <td><p>'.$query2['date_day'].'</p></td>
                    <td><p>'.$query2['date_time'].'</p></td>
                    <td id="sum'.$query2['id'].'">
					</td>
                    <td>
                        '.$query2['discount'].'%
					</td>
                    <td></td>
                </tr>
                <tr>
                    <td><p></p></td>
                    <td><p></p></td>
                    <td><p>Выберите тип чистки</p></td>
                    <td><p>Добавьте название обуви</p></td>
                    <td><p></p></td>
                    <td><p>Добавьте оплату курьера</p></td>
                    <td><p>Добавьте комментарии к заказу</p></td>
                    <td><p></p></td>
                    <td><p>Кастомная скидка</p></td>
                    <td><p></p></td>
                    <td><p></p></td>
                </tr>
                <tr>
                <td>
                </td>
                <td>
                </td>
                <td>
                        ');
                for ($i=0;$i<$query2['shoe_num'];$i++) {
                    echo('
                    
                    <select form="request'.$query2['id'].'" name="type[]" id="val'.$query2['id'].($i+1).'" onchange="showSum'.$query2['id'].'()">
                    <option selected disabled>Выбрать</option>
                    <option value="0">CLASSIC</option>
                    <option value="1">CLASSIC+</option>
                    <option value="2">STANDART</option>
                    <option value="3">STANDART+</option>
                    <option value="4">PREMIUM</option>
                    <option value="5">PREMIUM+</option>
                    <option value="6">EXCLUSIVE</option>
                    <option value="7">EXCLUSIVE+</option>
                    </select><br>
                    ');
                }
                echo('
                </td>
                <td>
                    ');
                for ($i=0;$i<$query2['shoe_num'];$i++) {
                    echo('
                    <input form="request'.$query2['id'].'" type="text" name="shoe_name[]" placeholder="Введите название обуви"><br>
                    ');
                }
                echo('
                </td>
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
                <td>
                    <input form="request'.$query2['id'].'" type="text" name="delivery" placeholder="Введите сумму" id="del'.$query2['id'].'" oninput="showSum'.$query2['id'].'()">
                </td>
                <td>
                    <textarea form="request'.$query2['id'].'" name="commit" placeholder="Введите текст"></textarea>
                </td>
                <td>
                </td>
                <td>
                    <select form="request'.$query2['id'].'" name="new_desc" id="newDesc'.$query2['id'].'" onchange="showSum'.$query2['id'].'()">
                    <option selected value="-">Выбрать</option>
                ');
                $query_desc = mysqli_query($connect, "SELECT * FROM discount") or die(mysqli_error($connect));
                for ($i=0;$i<8;$i++) {
                    $query_desc2 = mysqli_fetch_array($query_desc);
                        echo('<option value="'.$query_desc2['value'].'">'.$query_desc2['value'].'%</option>');
                }
                echo('</select>
                     </td>
                     <td>
                     <script>
                     function showSum'.$query2['id'].'() {
                        shoeNum = '.$query2['shoe_num'].';
                        var sum=0;
                        var fullSum = 0;
                        var place = document.getElementById("sum'.$query2['id'].'");
                        var orderSum = document.getElementById("orderSum'.$query2['id'].'");
                        var orderDiscount = document.getElementById("orderDiscount'.$query2['id'].'");
                        var orderFinalSum = document.getElementById("orderFinalSum'.$query2['id'].'");
                        var newDesc = document.getElementById("newDesc'.$query2['id'].'");
                            for (var i=0;i<shoeNum;i++) {
                                val = document.getElementById("val'.$query2['id'].'"+(i+1));
                                var value = val.value;
                                switch (value) {
                                    case "0":
                                        value = 900;
                                        break;
                                    case "1":
                                        value = 1200;
                                        break;
                                    case "2":
                                        value = 1600;
                                        break;
                                    case "3":
                                        value = 1900;
                                        break;
                                    case "4":
                                        value = 2200;
                                        break;
                                    case "5":
                                        value = 2500;
                                        break;
                                    case "6":
                                        value = 2900;
                                        break;
                                    case "7":
                                        value = 3200;
                                        break;
                                    default:
                                        value = 0;
                                        break;
                                }
                                sum = sum + value;
                            }
                        var del = document.getElementById("del'.$query2['id'].'");
                    orderSum.value = Number(sum);
                    if (newDesc.value !== "-") {
                        sum = sum-(sum/100)*newDesc.value;
                        sum = Math.ceil(sum);
                        orderDiscount.value = newDesc.value;
                    } else {
                        sum = sum-(sum/100)*'.$query2['discount'].';
                        sum = Math.ceil(sum);
                        orderDiscount.value = '.$query2['discount'].';
                    }
                    place.innerHTML = "<b>"+sum+"</b>";
					//sum = sum+Number(del.value);
                    orderFinalSum.value = sum;
                    }
                    </script>
                </td>
                <td>
					<button form="request'.$query2['id'].'" type="submit" name="submit_up" value="delete-request"><i class="fas fa-times"></i></button>
                    <button form="request'.$query2['id'].'" type="submit" name="submit-ready-order"><i class="fas fa-arrow-right"></i></button>
                </td>
                </tr>
                ');
                echo('</table></div>');
            }
            ?>  
            </div>  
</div>