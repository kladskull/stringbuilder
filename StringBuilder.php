<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * A String Builder Class for PHP
 *
 * A String Class that makes appending strings much quicker
 * then a straight append. Great for loops, etc.
 *
 * PHP version 5
 *
 * LICENSE: This software is MIT Licensed and there should be a copy
 * of the license with this software.
 *
 * @category   Utility
 * @package    StringBuilder
 * @author     Mike Curry <mikecurry74@gmail.com>
 * @copyright  2015 Mike Curry
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/mikecurry74/stringbuilder
 */

// Only define the class once
if (!defined('DEF_STRINGBUILDER_CLASS')) {

    class StringBuilder {

        // {{{ properties

        /**
         * The string
         *
         * Can contain any valid string.
         *
         * @var string
         * @access private
         */
        private $_string = "";
        
        /**
         * The actual string length of the stored string
         *
         * This returns the actual length, and not the entire length of 
         * the buffer string. If the string was "test" and the entire buffer
         * length was 256, this would be set to 4.
         *
         * @var integer
         * @access private
         */
        private $_stringLength = 0;

        /**
         * The actual string length of the pre-defined buffer.
         *
         * This will return the pre-defined length of the string buffer.
         * If the string surpasses the buffer length and is expanded, it will
         * still return the original buffer length.
         *
         * @var integer
         * @access private
         */
        private $_bufferSize = 262144; // default is 1024 x 256
        
        // }}}
        
        public function __constructor($string = "", $bufferLength = -1) {
            
            // if not set, use the default
            if ($bufferLength == -1) {
                $bufferLength = $this->_bufferSize;
            }
 
            // initialize the buffer
            $this->_string = str_pad(" ", $this->_bufferSize - strlen($string));
            $this->append($string);
        }
        
        // get the default buffersize
        public function bufferSize () {
            return $this->_bufferSize;
        }
        
        // get the actual current buffer size
        public function getActualBufferSize () {
            return strlen($this->_string);
        }
        
        // get the length of the string
        public function length() {
            return $this->_stringLength;
        }
        
        // append a string
        public function append($string) {
            echo $string . " - ";
            $len = strlen($string);
            echo $len."\n";
            
            // if the sum of the string + buffer are greater then the current
            // buffer length, allocate more space.
            if ($this->_stringLength + $len > strlen($this->_string)) {
                $this->_string .= str_pad(" ", $this->_bufferSize);
            }
            
            // insert the string into the buffer
            for ($i=0; $i < $len; ++$i) {
                echo $i." - ".$string[$i] ."\n";
                $this->_string[$this->_stringLength + $i] = $string[$i];
            }

            // update the string length
            $this->_stringLength = $this->_stringLength + $len;
        }
        
        // get the string
        public function toString() {
            if ($this->_stringLength) {
                return substr($this->_string, 0, $this->_stringLength);
            } else {
                return "";
            }
        }
        
    }
    
    // we've defined the class
    define('DEF_STRINGBUILDER_CLASS', true);
}