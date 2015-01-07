<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ('StringBuilder.php');

$errors = 0;
$tests = 0;

// test helper functions
function testlog($message, $result) {
    global $errors, $tests; // yes I know.. 
            
    if ($result) {
        echo "+ PASS: ";
    } else {
        echo "- FAIL: ";
        ++$errors; // count an error
    }
    
    ++$tests; // count the test as completed
    
    echo $message . "\n";
}

// display header
echo "Running StringBuilder Tests...\n";

////////////////////////////////////////////////////////////////////////////////
// test redeclaration of the class - will fail or throw a warning
////////////////////////////////////////////////////////////////////////////////
include ('StringBuilder.php'); // will display an error if its an issue
include_once ('StringBuilder.php'); // will display an error if its an issue
require ('StringBuilder.php'); // will display an error if its an issue
require_once ('StringBuilder.php'); // will display an error if its an issue
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a length
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder();
$len = strlen($sb->toString());
if ($len != 0) {
    testlog("New stringbuilder has a value ({$len}) greater than 0", false);
} else {
    testlog("New stringbuilder has a value ({$len}) equal to 0", true);
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a length with a default buffer length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("", 256);
$len = strlen($sb->toString());
if ($len != 0) {
    testlog("New stringbuilder has a value ({$len}) greater than 0 with the buffer being set to 256", false);
} else {
    testlog("New stringbuilder has a value ({$len}) equal to 0", true);
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test the actual buffer length
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("", 1024);
if ($sb->getActualBufferSize() == 1024) {
    testlog("New stringbuilder buffer has a value ({$sb->getActualBufferSize()}) the actual default buffer being set to 1024", false);
} else {
    testlog("New stringbuilder buffer has a value ({$sb->getActualBufferSize()}) equal to the default value 1024", true);
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a length with a default string and buffer 
// length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("test1234", 256);
if ($sb->length() != 8) {
    testlog("New stringbuilder has a value ({$len}) greater than the expected length of 8", false);
} else {
    testlog("New stringbuilder has a value ({$len}) equal to 8", true);
}
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a value with a default string and buffer 
// length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("test1234", 512);
if ($sb->toString() != "test1234") {
    testlog("New stringbuilder has an unexpected value ({$sb->toString()}), should be test1234", false);
} else {
    testlog("New stringbuilder has a value ('$sb->toString()') equal to 'test1234'", true);
}
////////////////////////////////////////////////////////////////////////////////

// display footer
echo "StringBuilder Tests complete. {$errors} error(s) found out of a total of {$tests} tests.\n";
