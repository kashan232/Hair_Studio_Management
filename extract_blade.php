<?php
$orig_blade = file_get_contents('resources/views/stylist/designer-svg.blade.php');
$blade_logic_start = strpos($orig_blade, '@php');
echo substr($orig_blade, $blade_logic_start, 200);
