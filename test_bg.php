<?php
$c=file_get_contents('C:\Users\Admin\Downloads\chairs (1).svg'); 
if (preg_match_all('/fill="([^"]+)"/', $c, $m)) {
    print_r(array_unique($m[1]));
}
if (preg_match_all('/<([a-zA-Z0-9]+)[^>]*>/', $c, $m)) {
    print_r(array_unique($m[1]));
}
