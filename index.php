<?php
include('crm-php/check.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CRM</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--Мобильная версия-->
        <link rel="stylesheet" type="text/css" media="screen and (max-width: 450px)" href="css/crm-style-mobile.css?v=1.2">
        <!--Десктоп-->
        <link rel="stylesheet" type="text/css" media="screen and (min-width: 450px)" href="css/crm-style.css?v=1.1">
        <!--Иконки-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/timetable.css">
    </head>
    <body>
        <div class="header" <?php if ($user_city == 'spb') {echo 'style="background-color: red;"';} ?>>
            <div class="header-name"<?php if ($user_city == 'spb') {echo 'style="background-color: red;"';} ?>>
                <h1><a href="index.php"><?php if ($user_city == 'spb') {echo 'CRM-SPB';} else {echo 'CLEANTWINS';} ?></a></h1>
                <div class="header-btn" id="headerBtn">
                    <ul>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="username">
                <a href="log_form.php?getout">Привет, 
                    <?php
                    echo($_COOKIE['name']);
                    ?>
                </a>
                <a href="log_form.php?getout"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        </div>
        <div class="header-menu" id="headerMenu">
            <ul>
                <?php
                foreach($menu_list as $key => $value) {
                    $value_arr = explode('#', $value);
                    echo '<li><a href="index.php?type='.$key.'"><i class="'.$value_arr[1].'"></i>'.$value_arr[0].'</a>';
                    if (isset($_GET['type'])) {
                        if ($_GET['type'] == $key) {
                            echo('<span></span>');
                        }
                    }
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
        <div class="content" id="content">
            <?php
            if (isset($_GET['type'])) {
                $type = $_GET['type'];
                if (is_file($type.'.php')) {
                    include($type.'.php');
                } else {
                    echo('<h2>CRM<span>Работает в тестовом режиме. Обо всех неполадках сообщать!</span></h2>');
                }
            } else {
                echo('<h2>CRM<span>Работает в тестовом режиме. Обо всех неполадках сообщать!</span></h2>');
            }
            ?>
        </div>
        <script src="js/anim.js"></script>
    </body>
</html>