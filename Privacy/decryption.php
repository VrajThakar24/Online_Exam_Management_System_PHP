<?php
function decrypt($ciphertext) {
    $result = '';
    for ($i = 0; $i < strlen($ciphertext); $i++) {
        $result .= chr(ord($ciphertext[$i]) - 3);
    }
    return $result;
}
?>
