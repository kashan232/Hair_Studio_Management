<?php
$orig = file_get_contents('resources/views/stylist/designer-svg.blade.php');
$new = file_get_contents('C:\Users\Admin\Downloads\chairs (1).svg');

// 1. Get the blade logic from the original file.
$blade_logic_start = strpos($orig, '    @php');
if ($blade_logic_start === false) {
    $blade_logic_start = strpos($orig, '@php');
}
$blade_logic = substr($orig, $blade_logic_start);

// 2. Get the filters from the original file.
$filter_start = strpos($orig, '<filter id="chair-green"');
// Find the first </defs> AFTER the filters. We can search from $filter_start
$filter_end = strpos($orig, '</defs>', $filter_start);

// Wait! If there is NO </defs> between <filter> and @php, then the filters just go until @php
$filter_block = substr($orig, $filter_start, $blade_logic_start - $filter_start);
// We want to just capture the <filter> blocks exactly.
// Since there's only two filters, let's just use string extraction more robustly.
$filter_end = strpos($orig, '</filter>', $filter_start);
$filter_end = strpos($orig, '</filter>', $filter_end + 1); // Second filter
$filter_end += strlen('</filter>');
$filters = substr($orig, $filter_start, $filter_end - $filter_start);

// 3. Process the new SVG
$new_defs_end = strpos($new, '</defs>');
$part1 = substr($new, 0, $new_defs_end); // Everything up to just before </defs>
$part2 = substr($new, $new_defs_end);    // Everything from </defs> onwards

// Remove ALL <use> tags from $part2 to form $backgrounds
$backgrounds = preg_replace('/<use[^>]+>/', '', $part2);
$backgrounds = str_replace('</svg>', '', $backgrounds);

// Change id="bg" to id="elade_map"
$part1 = str_replace('<svg id="bg"', '<svg id="elade_map"', $part1);
$part1 = preg_replace('/width="[^"]+"/', 'width="100%"', $part1, 1);
$part1 = preg_replace('/height="[^"]+"/', 'height="100%"', $part1, 1);
$part1 = preg_replace('/viewBox="([^"]+)"/', 'viewBox="$1" preserveAspectRatio="xMidYMid meet"', $part1, 1);


// Assemble the final content!
$final_content = $part1 . "\n" . $filters . "\n" . $backgrounds . "\n" . $blade_logic;

file_put_contents('resources/views/stylist/designer-svg.blade.php', $final_content);
echo "SUCCESS!";
