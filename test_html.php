<?php
$html = file_get_contents('http://127.0.0.1:8000/stylist/book?step=2');
if (preg_match_all('/<rect[^>]+fill="#[fF]{3,6}"[^>]*>/', $html, $m)) {
    print_r($m[0]);
} else {
    echo "No white fills found in output HTML.\n";
}
