<?php
$c = file_get_contents('C:\Users\Admin\Downloads\chairs (1).svg');
$p = strrpos($c, '<use');
echo substr($c, $p, 500);
