<?php
$host = 'smtp-mail.outlook.com';
$port = 587;
$timeout = 10;

echo "Connecting to $host:$port...\n";
$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
if (!$fp) {
    echo "ERROR: $errno - $errstr\n";
} else {
    echo "Connected!\n";
    echo fread($fp, 512) . "\n";
    fclose($fp);
}
