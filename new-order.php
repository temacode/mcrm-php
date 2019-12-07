<?php
if (isset($_SESSION['msg'])) {
    if ($_SESSION['msg'] !== 0) {
        echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
        $_SESSION['msg'] = 0;
    }
}
?>
<div class="include">
    <h3>Добавление заказа</h3>
    <div class="include-content">
    <form action="crm-php/crm-func.php" method="post">
        <p>Введите имя</p>
        <input type="text" placeholder="Введите имя клиента" name="name">
        <p>Введите номер телефона</p>
        <input type="tel" name="tel" placeholder="Введите номер">
        <p>Введите почту</p>
        <input type="email" name="mail" placeholder="Введите адрес эл.почты">
        <p>Введите адрес доставки</p>
        <input type="text" name="address" placeholder="Введите адрес">
        <!--Надо сделать здесь выбор из бывших названий-->
        <p>Введите количество пар</p>
        <input type="number" name="shoe_num" placeholder="Введите количество"><br>
        <input type="hidden" name="city" value="<?php echo $user_city ?>">
        <button type="submit" name="submit-new-order">Отправить</button>
    </form>
    </div>
</div>