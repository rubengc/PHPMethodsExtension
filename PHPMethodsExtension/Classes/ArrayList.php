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

if(!class_exists("ArrayList")) {
    class ArrayList implements \ArrayAccess, \Countable, \IteratorAggregate, \Serializable {
        private $array;

        public function __construct() {
            if(func_num_args() == 1 && gettype(func_get_arg(0)) == "array") {
                $this->array = func_get_arg(0);
            } else {
                $this->array = array();
                $args = func_get_args();

                foreach($args as $arg)
                    $this->array[] = $arg;
            }

            return $this;
        }

        public function __toString() {
            return (string)implode(ARRAYLIST_SEPARATOR, $this->array);
        }

        public function toArray() {
            return $this->array;
        }

        public function __call($name, $arguments) {
            if(substr($name, 0, 3) == "get" && strlen($name) > 3) {
                $key = substr($name, 3, strlen($name));

                if(isset($this->array[$key]))
                    return $this->get($key);
                else if(isset($this->array[ucfirst($key)]))
                    return $this->get(ucfirst($key));
                else if(isset($this->array[lcfirst($key)]))
                    return $this->get(lcfirst($key));
                else if(isset($this->array[strtolower($key)]))
                    return $this->get(strtolower($key));
                else if(isset($this->array[strtoupper($key)]))
                    return $this->get(strtoupper($key));
            } else if(substr($name, 0, 3) == "set" && strlen($name) > 3) {
                $key = substr($name, 3, strlen($name));

                if(isset($this->array[$key]))
                    return $this->set($key, $arguments[0]);
                else if(isset($this->array[ucfirst($key)]))
                    return $this->set(ucfirst($key), $arguments[0]);
                else if(isset($this->array[lcfirst($key)]))
                    return $this->set(lcfirst($key), $arguments[0]);
                else if(isset($this->array[strtolower($key)]))
                    return $this->set(strtolower($key), $arguments[0]);
                else if(isset($this->array[strtoupper($key)]))
                    return $this->set(strtoupper($key), $arguments[0]);
            }
        }

        public function add($index = null, $object = null) {
            if(func_num_args() == 2)
                $this->array[func_get_arg(0)] = func_get_arg(1);
            else
                $this->array[] = func_get_arg(0);

            return $this;
        }

        public function count() {
            return count($this->array);
        }

        public function each($callback) {
            foreach($this->array as $key => $value)
                call_user_func_array($callback, array($value, $key, $this));

            return $this;
        }

        public function get($index = 0) {
            return $this->array[$index];
        }

        public function getIterator() {
            $array = new ArrayObject($this->array);
            return $array->getIterator();
        }

        public function indexOf($object, $strict = false) {
            foreach($this->array as $key => $value) {
                if($strict) {
                    if ($object === $value || (is_array($value) && $this->indexOf($value, $strict) !== -1))
                        return $key;
                } else {
                    if ($object == $value || (is_array($value) && $this->indexOf($value, $strict) !== -1))
                        return $key;
                }
            }

            return -1;
        }

        public function inverseOrder() {
            $array = array();

            $index = count($this->array)-1;

            foreach($this->array as $key => $value) {
                $array[$index] = $value;
                $index--;
            }

            $this->array = $array;

            return $this;
        }

        public function join($glue = ",") {
            return PMEReturn(implode($glue, $this->array));
        }

        public function keySort($order = SORT_ASC, $sortMode = SORT_REGULAR) {
            if ($order == SORT_ASC)
                ksort($this->array, $sortMode);
            else
                krsort($this->array, $sortMode);

            return $this;
        }

        public function keySortInverse($sortMode = SORT_REGULAR) {
            return $this->keySort(SORT_DESC, $sortMode);
        }

        public function lastIndexOf($object, $strict = false) {
            $index = false;

            foreach($this->array as $key => $value) {
                if($strict) {
                    if ($object === $value || (is_array($object) && $this->lastIndexOf($value, $strict) !== -1))
                        $index = $key;
                } else {
                    if ($object == $value || (is_array($object) && $this->lastIndexOf($value, $strict) !== -1))
                        $index = $key;
                }
            }

            return $index !== false ? $index : -1;
        }

        public function length() {
            return count($this->array);
        }

        public function naturalSort($ignoreCase = false) {
            if($ignoreCase)
                natcasesort($this->array);
            else
                natsort($this->array);

            return $this;
        }

        public function naturalSortIgnoreCase() {
            return $this->naturalSort(true);
        }

        public function offsetExists($offset) {
            return isset($this->array[$offset]);
        }

        public function offsetGet($offset) {
            return isset($this->array[$offset]) ? $this->array[$offset] : null;
        }

        public function offsetSet($offset, $value) {
            is_null($offset) ? $this->array[] = $value : $this->array[$offset] = $value;

            return $this;
        }

        public function offsetUnset($offset) {
            unset($this->array[$offset]);

            return $this;
        }

        public function randomSort($maintainKeys = true) {
            $keys = array_keys($this->array);

            shuffle($keys);

            $array = array();

            foreach($keys as $key) {
                if($maintainKeys)
                    $array[$key] = $this->array[$key];
                else
                    $array[] = $this->array[$key];
            }

            $this->array = $array;

            return $this;
        }

        public function remove($index = 0) {
            unset($this->array[$index]);

            return $this;
        }

        public function serialize() {
            return serialize($this->array);
        }

        public function set($index, $object) {
            $this->array[$index] = $object;

            return $this;
        }

        public function sort($order = SORT_ASC, $sortMode = SORT_REGULAR, $maintainKeys = true) {
            if($maintainKeys) {
                if ($order == SORT_ASC)
                    asort($this->array, $sortMode);
                else
                    arsort($this->array, $sortMode);
            } else {
                if ($order == SORT_ASC)
                    sort($this->array, $sortMode);
                else
                    rsort($this->array, $sortMode);
            }

            return $this;
        }

        public function sortInverse($sortMode = SORT_REGULAR, $maintainKeys = true) {
            return $this->sort(SORT_DESC, $sortMode, $maintainKeys);
        }

        public function subList($start, $end = null) {
            $array = array();

            for ($i = $start; $i < ($end ? $end : count($this->array)); $i++)
                $array[] = $this->array[$i];

            return PMEReturn($array);
        }

        public function toJson() {
            return json_encode($this->array);
        }

        public function unserialize($data) {
            $this->array = unserialize($data);
        }
    }
}