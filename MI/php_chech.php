<?php
$host = 'smtp.gmail.com';
$ports = [465, 587];
foreach ($ports as $port) {
    echo "Testing $host:$port ... ";
    $connection = @fsockopen($host, $port, $errno, $errstr, 10);
    if (is_resource($connection)) {
        echo "✅ Connection successful (port open)\n";
        fclose($connection);
    } else {
        echo "❌ Failed: $errstr ($errno)\n";
    }
}
