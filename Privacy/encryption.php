<?php
function encrypt($string) {
    $result = '';
    for ($i = 0; $i < strlen($string); $i++) {
        $result .= chr(ord($string[$i]) + 3);
    }
    return $result;
}
?>
