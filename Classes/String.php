<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the PHP Methods Extension (http://rubengc.com/php-methods-extension)
 *
 * @author Ruben Garcia <contact@rubengc.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

if(!class_exists("String")) {
    class String implements ArrayAccess {
        private $string;

        public function __construct($string = "") {
            $this->string = (string)$string;
        }

        public function __toString() {
            return $this->string;
        }

        public function append() {
            $args = func_get_args();

            foreach($args as $arg)
                $this->string .= (string)$arg;

            return $this;
        }

        public function capitalize($delimiter = null) {
            if($delimiter != null) {
                $array = explode($delimiter, $this->string);
                $arrayAux = array();

                foreach($array as $item)
                    $arrayAux[] = ucfirst($item);

                $this->string = implode($delimiter, $arrayAux);

                return $this;
            }

            $this->string = ucfirst($this->string);

            return $this;
        }

        public function charAt($index) {
            return $this->string[$index];
        }

        public function concat() {
            $args = func_get_args();

            foreach($args as $arg)
                $this->string .= (string)$arg;

            return $this;
        }

        public function contains($needle, $ignoreCase = false) {
            $string = $this->string;

            if($ignoreCase) {
                $string = strtolower($string);
                $needle = strtolower($needle);
            }

            return $needle === "" || strpos($string, $needle) !== false;
        }

        public function containsIgnoreCase($needle) {
            return $this->contains($this->string, $needle, true);
        }

        public function endsWith($suffix, $ignoreCase = false) {
            $string = $this->string;

            if($ignoreCase) {
                $string = strtolower($string);
                $suffix = strtolower($suffix);
            }

            return $suffix === "" || strpos($string, $suffix, strlen($string)-strlen($suffix)) !== false;
        }

        public function endsWithIgnoreCase($suffix) {
            return $this->endsWith($suffix, true);
        }

        public function equals($string, $ignoreCase = false) {
            $stringX = $this->string;

            if($ignoreCase) {
                $stringX = strtolower($stringX);
                $string = strtolower($string);
            }

            return $stringX === $string;
        }

        public function equalsIgnoreCase($string) {
            return $this->equals($this->string, $string, true);
        }

        public function indexOf($string, $offset = 0, $ignoreCase = false) {
            $stringX = $this->string;

            if($ignoreCase) {
                $stringX = strtolower($stringX);
                $string = strtolower($string);
            }

            $index = strpos($stringX, $string, $offset);

            return $index !== false ? $index : -1;
        }

        public function indexOfIgnoreCase($string, $offset = 0) {
            return $this->indexOf($string, $offset, true);
        }

        public function length() {
            return strlen($this->string);
        }

        public function offsetExists($offset) {
            return isset($this->string[$offset]);
        }

        public function offsetGet($offset) {
            return isset($this->string[$offset]) ? $this->string[$offset] : "";
        }

        public function offsetSet($offset, $value) {
            is_null($offset) ? $this->string[] = $value : $this->string[$offset] = $value;

            return $this;
        }

        public function offsetUnset($offset) {
            unset($this->array[$offset]);

            return $this;
        }

        public function parseInt($base = 10) {
            return intval($this->string, $base);
        }

        public function parseFloat($decimals = -1, $decimalPoint = ".", $thousandsSeparator = ",") {
            $float = $this->string;

            if($decimals > 0)
                return number_format(floatval($float), $decimals, $decimalPoint, $thousandsSeparator);

            return floatval($float);
        }

        public function prepend() {
            $args = func_get_args();
            $string = "";

            foreach($args as $arg)
                $string .= (string)$arg;

            $this->string = $string . $this->string;

            return $this;
        }

        public function replace($search, $replace, $count = null, $ignoreCase = false) {
            if($ignoreCase)
                $this->string = ($count ? str_ireplace($search, $replace, $this->string, $count) : str_ireplace($search, $replace, $this->string));
            else
                $this->string = ($count ? str_replace($search, $replace, $this->string, $count) : str_replace($search, $replace, $this->string));

            return $this;
        }

        public function replaceIgnoreCase($search, $replace, $count = null) {
            return $this->replace($search, $replace, $count, true);
        }

        public function split($delimiter, $limit = null) {
            return PMEReturn(
                $limit ? explode($delimiter, $this->string, $limit) : explode($delimiter, $this->string)
            );
        }

        public function startsWith($prefix, $ignoreCase = false) {
            $string = $this->string;

            if($ignoreCase) {
                $string = strtolower($string);
                $prefix = strtolower($prefix);
            }

            return $prefix === "" || strrpos($string, $prefix, -strlen($string)) !== false;
        }

        public function startsWithIgnoreCase($prefix) {
            return $this->startsWith($prefix, true);
        }

        public function substring($start, $length = null) {
            return PMEReturn(
                $length ? substr($this->string, $start, $length) : substr($this->string, $start)
            );
        }

        public function toLowerCase() {
            $this->string = strtolower($this->string);

            return $this;
        }

        public function toUpperCase() {
            $this->string = strtoupper($this->string);

            return $this;
        }

        public function trim($characterMask = " \t\n\r\0\x0B") {
            $this->string = trim($this->string, $characterMask);

            return $this;
        }

        public function valueOf($var) {
            return String::parse($var);
        }

        public static function parse($object) {
            switch(gettype($object)) {
                case "boolean": return PMEReturn($object ? "true" : "false");
                case "integer": return PMEReturn((string)$object);
                case "double":  return PMEReturn((string)$object);
                case "string":  return PMEReturn($object);
                case "array":   return PMEReturn(implode($object));
                case "object":  return PMEReturn((string)$object);
                case "resource":  return PMEReturn((string)$object);
                case "NULL":  return PMEReturn("NULL");
                default: return PMEReturn("unknown type");
            }
        }
    }
}