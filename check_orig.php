<?php
$orig_blade = file_get_contents('resources/views/stylist/designer-svg.blade.php');
$blade_logic_start = strpos($orig_blade, '@php');
$before_blade = substr($orig_blade, 0, $blade_logic_start);

echo "Number of <use tags before blade logic in original file: " . substr_count($before_blade, '<use');
echo "\nNumber of <rect tags before blade logic in original file: " . substr_count($before_blade, '<rect');
echo "\nNumber of <image tags before blade logic in original file: " . substr_count($before_blade, '<image');
