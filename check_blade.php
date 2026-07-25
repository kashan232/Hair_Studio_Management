<?php
$c = file_get_contents('resources/views/stylist/booking.blade.php');
preg_match_all('/@(if|elseif|else|endif|foreach|endforeach|for|endfor|switch|case|default|endswitch|isset|endisset|empty|endempty|auth|endauth|guest|endguest)/', $c, $m);
foreach ($m[0] as $tag) {
    echo $tag . "\n";
}
