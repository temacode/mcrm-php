<?php
ini_set('display_errors',1);
class view {
    var $connect;
    var $query;
    function __construct($address, $user, $password, $table) {
        $this->connect = mysqli_connect($address, $user, $password, $table);
    }
    function selectSQL($sql) {
        $this->query = mysqli_query($this->connect, $sql);
    }
    function showClient($client_id) {
        
    }
    function showQuery() {
        $result = mysqli_fetch_array($this->query);
        $keys = array_keys($result);
        echo "<table>";
        echo "<tr>";
        for ($i=0;$i<count($keys);$i++) {
            $i++;
            switch ($keys[$i]) {
                case 'id':
                    $header = 'Номер заказа';
                        break;
                    case 'address':
                        $header = 'Адрес';
                        break;
                    case 'client_id':
                        $header = 'Контакты';
                        break;
                    case 'status':
                        $header = 'Статус';
                        break;
                    case 'date_day':
                        $header = 'Дата';
                        break;
                    case 'date_time':
                        $header = 'Время';
                        break;
                    case 'delivery':
                        $header = 'NOT_SHOW';
                        break;
                    case 'date_del':
                        $header = 'NOT_SHOW';
                        break;
                    case 'delivery_first':
                        $header = 'NOT_SHOW';
                        break;
                    case 'delivery_second':
                        $header = 'NOT_SHOW';
                        break;
                    case 'date_delivery':
                        $header = 'NOT_SHOW';
                        break;
                    case 'commit':
                        $header = 'Комментарии';
                        break;
                    case 'sum':
                        $header = 'Сумма';
                        break;
                    case 'shoe_num':
                        $header = 'NOT_SHOW';
                    default:
                        $header = $keys[$i];
                        break;
            }
            if ($header !== 'NOT_SHOW') {
                echo "<th>".$header."</th>";
            }
        }
        echo "</tr>";
        do {
            $keys = array_keys($result);
            next($keys);
            echo "<tr>";
            while ($key = current($keys)) {
                next($keys);
                switch ($key) {
                    case 'id':
                        $header = 'Номер заказа';
                        break;
                    case 'address':
                        $header = 'Адрес';
                        break;
                    case 'client_id':
                        $header = 'Контакты';
                        break;
                    case 'status':
                        $header = 'Статус';
                        break;
                    case 'date_day':
                        $header = 'Дата';
                        break;
                    case 'date_time':
                        $header = 'Время';
                        break;
                    case 'delivery':
                        $header = 'NOT_SHOW';
                        break;
                    case 'date_del':
                        $header = 'NOT_SHOW';
                        break;
                    case 'delivery_first':
                        $header = 'NOT_SHOW';
                        break;
                    case 'delivery_second':
                        $header = 'NOT_SHOW';
                        break;
                    case 'date_delivery':
                        $header = 'NOT_SHOW';
                        break;
                    case 'commit':
                        $header = 'Комментарии';
                        break;
                    case 'sum':
                        $header = 'Сумма';
                        break;
                    case 'shoe_num':
                        $header = 'NOT_SHOW';
                    default:
                        $header = $key;
                        break;
                }
                if ($header !== "NOT_SHOW") {
                    echo '<td>'.$result[$key].'</td>';
                }
                next($keys);
            }
        echo "</tr>";
        } while($result = mysqli_fetch_array($this->query));
        echo "</table>";
    }
}
class route {
    var $server;
    var $path = '';
    function __construct() {
        $this->server = explode('/', $_SERVER['REQUEST_URI']);
        if (file_exists($this->server[2])) {
            for ($i=2;$i<count($this->server);$i++) {
                $this->path .= $this->server[$i].'/';
            }
            $this->path = substr($this->path, 0, -1);
            if (file_exists($this->path)) {
                echo "Все норм";
            } else {
                echo "404 - ".$this->path;
            }
        } else {
            for ($i=2;$i<count($this->server);$i++) {
                $this->path .= $this->server[$i].'/';
            }
            $this->path = substr($this->path, 0, -1);
            echo "404 - ".$this->path;
        }
    }
}
$obj = new view("localhost","root","password","cleantwins");
$obj->selectSQL("SELECT * FROM order_new");
?>