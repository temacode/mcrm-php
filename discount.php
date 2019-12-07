<div class="include">
    <?php
    if (isset($_SESSION['msg'])) {
        if ($_SESSION['msg'] !== 0) {
            echo('<script> alert("'.$_SESSION['msg'].'"); </script>');
            $_SESSION['msg'] = 0;
        }
    }
    ?>
    <h3>Управление скидками</h3>
    <div class="include-content">
        <form action="crm-php/crm-func.php" method="post">
            <?php
            include('../php/connect.php');
            $query = mysqli_query($connect, "SELECT * FROM discount") or die(mysqli_error($connect));
            for ($i=0;$i<8;$i++) {
                $query2 = mysqli_fetch_array($query);
                //echo($query2[2]);
                if ($query2[2]==1) {
                    $discount = $query2['value'];
                    $id = $query2['id'];
                }
            }
            ?>
            <p>Текущас скидка - <?php echo($discount); ?></p>
            <input type="hidden" name="active_desc" value="<?php echo($id); ?>"><br>
            <p>Выберите новую скидку: </p>
            <select name="new_desc">
                <?php
                include('../php/connect.php');
                $query = mysqli_query($connect, "SELECT * FROM discount") or die(mysqli_error($connect));
                for ($i=0;$i<8;$i++) {
                    $query2 = mysqli_fetch_array($query);
                    //echo($query2[2]);
                    if ($query2[2]==0) {
                        echo('<option value="'.$query2['id'].'">'.$query2['value'].'%</option>');
                    } else {
                        echo('<option selected disabled value="'.$query2['id'].'">'.$query2['value'].'% </option>');
                    }
                }
                ?>
            </select>
            <button type="submit" name="discount-change">Отправить</button>
        </form>
    </div>
</div>