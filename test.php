<?php
$str = 'bogatyrevvvv?utm_source=ig_profile_share&igshid=1xde5gvpxvh25';
$str = strtok($str, '?');
if ($str[strlen($str)-1] === '/') {
    $str = substr($str, 0, -1);
} 
$str = str_replace('instagram.com/', '#', $str);
$str = explode('#', $str);
if (count($str)>1) {
    $str = $str[1];
} else {
    $str = $str[0];
}
echo $str;
?>