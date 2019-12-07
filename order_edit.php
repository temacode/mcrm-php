<script src="js/order-edit.js"></script>
<div class="include">
    <h3>Редактирование заказов</h3>
    <div class="include-content">
        <?php
        include("../php/connect.php");
        $query = mysqli_query($connect, "SELECT * FROM order_new WHERE (status < 3 OR status = 4) AND city = '$user_city'") or die (mysqli_error($connect));
        while ($query_arr = mysqli_fetch_array($query)) {
            echo '<div class="btn inline-btn grid-btn" onclick="showForm('.$query_arr['id'].')">'.$query_arr['id'].'</div>';
        }
        $query = mysqli_query($connect, "SELECT * FROM order_new WHERE status < 3 OR status = 4") or die (mysqli_error($connect));
        while ($query_arr = mysqli_fetch_array($query)) {
            echo '<div class="none order-info" id="id'.$query_arr['id'].'">';
            echo '<form action="crm-php/crm-func.php" method="post">';
            echo '<h4>Заказ № '.$query_arr['id'].'</h4>';
            echo '<input type="text" value="'.$query_arr['city'].'" name="city"><br>';
            echo '<p>Адрес</p>';
            echo '<textarea name="address">'.$query_arr['address'].'</textarea><br>';
            echo '<p>Дата поступления заявки</p>';
            echo '<input type="text" value="'.$query_arr['date_day'].'" name="date_day"><br>';
            echo '<p>Стоимость доставки</p>';
            echo '<input type="text" value="'.$query_arr['delivery'].'" name="delivery"><br>';
            echo '<p>Комментарии к заказу</p>';
            echo '<textarea name="commit">'.$query_arr['commit'].'</textarea><br>';
            echo '<p>Сумма</p>';
            echo '<input type="text" value="'.$query_arr['sum'].'" name="sum"><br>';
            echo '<p>Удаление обуви<br><span>Переключите для удаления</span></p>';
            echo '<div class="order-edit-delete">';
            $id = $query_arr['id'];
            $shoes = mysqli_query($connect, "SELECT * FROM order_info WHERE order_id = $id") or die(mysqli_error($connect));
            while ($shoe = mysqli_fetch_array($shoes)) {
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
                        $type = $shoe['type'];
                        break;
                }
                echo '<div class="slideThree">  
                    <input type="checkbox" value="'.$shoe['id'].'" id="slideThree'.$shoe['id'].'" name="shoe[]" checked />
                    <label for="slideThree'.$shoe['id'].'"></label>
                    </div>';
                echo '<span>'.$shoe['shoe_name'].' - '.$type.'</span><br>';
            }
            echo '<input type="hidden" name="id" value="'.$query_arr['id'].'">';
            echo '<div class="new-shoe" id="newShoeBlock'.$query_arr['id'].'">';
            echo '<p>Добавление новой пары</p>';
            echo '<div class="btn" onclick="newShoe('.$query_arr['id'].')"><i class="fas fa-plus"></i></div><br>';
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" name="submit-edit-order">Изменить</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
        <script>
            function newShoe(id) {
                var newShoeBlock = document.getElementById('newShoeBlock'+id);
                newShoeBlock.innerHTML += '<input type="text" name="shoe_name[]" placeholder="Введите название обуви" class="margin0"><br><select name="type[]"><option selected disabled>Тип чистки</option><option value="0">CLASSIC</option><option value="1">CLASSIC+</option><option value="2">STANDART</option><option value="3">STANDART+</option><option value="4">PREMIUM</option><option value="5">PREMIUM+</option><option value="6">EXCLUSIVE</option><option value="7">EXCLUSIVE+</option></select><br>';
            }
        </script>
    </div>
</div>