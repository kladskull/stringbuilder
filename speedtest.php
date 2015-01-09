<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Bench mark PHP concatenation methods
 *
 * This program compared the speeds between general php
 * concatenation, a StringBuilder and `stream` concatenation.
 *
 * @package StringBuilder
 * @subpackage Tests
 */
// include our StringBuilder library
include ("StringBuilder.php");

/**
 * set the memory limit to something big enough that we don't need to worry
 * about memory allocation erors.
 */
ini_set('memory_limit', '32M');

// simple function to return milliseconds for testing
function milliseconds() {
    return round(microtime(true) * 1000, 0, 13);
}

// total loop iterations
$iterations = 1000000;

// build a single character string the default php way
$trStart = milliseconds();
$string = "";
for ($i = 0; $i < $iterations; ++$i) {
    $string .= 'x';
}
$trEnd = milliseconds();

// build a single character string using our StringBuilder
$sbStart = milliseconds();
$sb = new StringBuilder();
for ($i = 0; $i < $iterations; ++$i) {
    $sb->append('x');
}
$sbEnd = milliseconds();

/**
 * build a single character string using a stream.
 * 
 * WARNING: I should warn, although this the quickest way to build a string, 
 * a lot of PHP tools use the output buffer and this could cause some weird 
 * issues. So please use it carefully, if you feel that the extra milliseconds
 * it saves you is worth implementing.
 */
$obStart = milliseconds();
ob_start();
for ($i = 0; $i < $iterations; ++$i) {
    echo 'x';
}
$myvar = ob_get_clean();
$obEnd = milliseconds();

// Calculate the results
$traditionalConcatTime = $trEnd - $trStart;
$stringBuilderTime = $sbEnd - $sbStart;
$outputBufferTime = $obEnd - $obStart;

// Display the results
echo "Traditional concatination took:           " . $traditionalConcatTime . "ms\n";
echo "Basic StingBuilder concatination took:    " . $stringBuilderTime . "ms\n";
echo "Output Buffer concatination took:         " . $outputBufferTime . "ms\n";
