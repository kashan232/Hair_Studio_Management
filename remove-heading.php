<?php
$svg = file_get_contents('C:\xampp\htdocs\Hair_Studio_Management\resources\views\stylist\designer-svg.blade.php');
$svg = preg_replace('/<use id="WhatsApp_Image[^>]+>/i', '', $svg);
file_put_contents('C:\xampp\htdocs\Hair_Studio_Management\resources\views\stylist\designer-svg.blade.php', $svg);
echo "Done!\n";
