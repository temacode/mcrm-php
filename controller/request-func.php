<?php
function getSelects($id, $num) {
    $selects = '';
       for ($i=0;$i<$num;$i++) {
           $selects .=
               '<select form="request-'.$id.'" name="type[]" id="val'.$id.($i+1).'" onchange="showSum'.$id.'()">
                    <option selected disabled>Выбрать</option>
                    <option value="0">CLASSIC</option>
                    <option value="1">CLASSIC+</option>
                    <option value="2">STANDART</option>
                    <option value="3">STANDART+</option>
                    <option value="4">PREMIUM</option>
                    <option value="5">PREMIUM+</option>
                    <option value="6">EXCLUSIVE</option>
                    <option value="7">EXCLUSIVE+</option>
                </select><br>';
       }
    return $selects;
}
function getNames($id, $num) {
    $names = '';
    for ($i=0;$i<$num;$i++) {
        $names .= '<input form="request-'.$id.'" type="text" name="shoe_name[]" placeholder="Введите название обуви"><br>';
    }
    return $names;
}
?>