<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Unit tests for the StringBuilder Class
 *
 * Just a simple program for unit testing the StringBuilder class. I'd 
 * have used PHPUnit however, most people don't have it, so I chose to 
 * do it this way for ease of use.
 *
 * @package StringBuilder
 * @subpackage Tests
 */

// include the string builder class
include ('StringBuilder.php');

// set some evil global variables
$errors = 0;
$tests = 0;

// unit test helper logging function
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
$result = false;
if ($len === 0) {
    $result = true;
}
testlog("StringBuilder() string has a 0 length. Actual={$len}", $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a length with a default buffer length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("", 256);
$len = strlen($sb->toString());
$result = false;
if ($len === 0) {
    $result = true;
}
testlog("StringBuilder('', 256) string has 0 length. Actual={$len}", $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test the actual buffer length
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("xxxxx", 1024);
$result = false;
if ($sb->getActualBufferSize() == 1024) {
    $result = true;
}
testlog("StringBuilder('xxxxx', 1024) buffer string is 1024 in length. Actual=" . $sb->getActualBufferSize(), $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a length with a default string and buffer 
// length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("test1234", 256);
$result = false;
if ($sb->length() === 8) {
    $result = true;
}
testlog("StringBuilder('test1234', 256) string has length of 8. Actual=" . $sb->length(), $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder for a value with a default string and buffer 
// length defined
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("test1234", 512);
$result = false;
if ($sb->toString() == "test1234") {
    $result = true;
}
testlog("StringBuilder('test1234', 512) is 'test1234'. Actual=" . $sb->toString(), $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder with a few iterations... no default start values
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder();
$result = false;
$testString = "";
for ($i = 0; $i < 20; ++$i) {
    $sb->append('x'.$i);
    $testString .= 'x'.$i;
}
// check the values
if ($testString == $sb->toString()) {
    $result = true;
}
testlog("Dynamic concat strings match.", $result);
$sb = null;
$testString = "";
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test new stringbuilder with a few iterations... use a default start value
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("testing");
$result = false;
$testString = "testing";
for ($i = 0; $i < 20; ++$i) {
    $sb->append('x'.$i);
    $testString .= 'x'.$i;
}
// check the values
if (strlen($testString) == strlen($sb->toString())) {
    $result = true;
}
testlog("Dynamic concat strings match in length.", $result);
$sb = null;
$testString = "";
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test zero length buffer
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("test", 0);
$result = false;
// check the values
if ("test" == $sb->toString()) {
    $result = true;
}
testlog("StringBuilder('test', 0) is actually 'test'", $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////
// test zero length buffer without appender
////////////////////////////////////////////////////////////////////////////////
$sb = new StringBuilder("", 0);
$result = false;
$sb->append("test");
// check the values
if ("test" == $sb->toString()) {
    $result = true;
}
testlog("StringBuilder('', 0) with an append('test') is actually 'test'", $result);
$sb = null;
////////////////////////////////////////////////////////////////////////////////


// display footer
echo "StringBuilder Tests complete. {$errors} error(s) found out of a total of {$tests} tests.\n";
