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
        private $_string = '';

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
        private $_bufferSize = 1024;

        /**
         * Class Constructor
         *
         * The StringBuilder constructor, all initialization happens here
         *
         * @param string $string Optional. The initial string to add on creation.
         * @param integer bufferLength $bufferLength Optional. The amount of 
         * bytes to initially allocate to the string builder.
         */
        public function __construct($string = '', $bufferLength = -1) {
            // if not set, use the default
            if ($bufferLength === -1) {
                $bufferLength = $this->_bufferSize;
            } else {
                // store the default
                $this->_bufferSize = $bufferLength;
            }

            // initialize the buffer
            $this->_string = str_repeat(' ', $bufferLength);

            // append an initial string?
            if (isset($string[0])) {
                $this->append($string);
            }
        }

        /**
         * Default buffer size
         *
         * The default buffer size to be allocated
         *
         * @return integer Buffer size in bytes.
         */
        public function bufferSize() {
            return $this->_bufferSize;
        }

        /**
         * Current buffer size
         *
         * Returns the total bytes currently in use, includes unused buffer
         * bytes as well.
         *
         * @return integer Current string Buffer size in bytes.
         */
        public function getActualBufferSize() {
            return strlen($this->_string);
        }

        /**
         * Current string length
         *
         * Returns the total string length in bytes, doesn't included unused
         * buffer spsace. Basically returns your string length.
         *
         * @return integer Current string length in bytes.
         */
        public function length() {
            return $this->_stringLength;
        }

        /**
         * Appender function
         *
         * This is the function that appends the data to the string.
         *
         * @param string $string Required. The string to append
         */
        public function append($string) {
            $len = strlen($string);
            $i = 0;

            // do we need to allocate more space?
            if (!isset($this->_string[$this->_stringLength + $len])) {
                $this->_string .= str_repeat(' ', $this->_bufferSize);
            }

            // insert the string into the buffer
            for ($i = 0; $i < $len; ++$i) {
                $pos = $this->_stringLength + $i;
                $this->_string[$pos] = $string[$i];
            }

            //echo $this->_string;
            // update the string length
            $this->_stringLength += $len;
        }

        /**
         * ToString
         *
         * Returns the completed string.
         *
         * @return string String text.
         */
        public function toString() {
            if ($this->_stringLength) {
                if (is_array($this->_string)) {
                    return substr(implode($this->_string), 0, $this->_stringLength);
                } else {
                    return substr($this->_string, 0, $this->_stringLength);
                }
            } else {
                return '';
            }
        }

    }

    // we've defined the class, won't need to do this again
    define('DEF_STRINGBUILDER_CLASS', true);
}
