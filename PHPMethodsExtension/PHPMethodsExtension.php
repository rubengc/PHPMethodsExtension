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

require_once(__DIR__ . "/Constants.php");
require_once(__DIR__ . "/Functions.php");

require_once(__DIR__ . "/Classes/ArrayList.php");
require_once(__DIR__ . "/Classes/Date.php");
require_once(__DIR__ . "/Classes/FTP.php");
require_once(__DIR__ . "/Classes/MySQL.php");
require_once(__DIR__ . "/Classes/SFTP.php");
require_once(__DIR__ . "/Classes/String.php");
require_once(__DIR__ . "/Classes/Terminal.php");

function convertToPMEObject($object) {
    switch(gettype($object)) {
        case "boolean": return $object;
        case "integer": return $object;
        case "double":  return $object;
        case "string":  return new String($object);
        case "array":
            $object = new ArrayList($object);
            $object->each(function($value, $key, $arrayList) {
                $arrayList->set($key, convertToPMEObject($value));
            });
            return $object;
        case "object":  return $object;
        case "resource":  return $object;
        case "NULL":  return $object;
        default: return $object;
    }
}

function PMEReturn($object) {
    if(RETURN_PME_OBJECTS)
        return convertToPMEObject($object);
    else
        return $object;
}

if(!class_exists("Integer")) {
    class Integer {
        private $integer;

        public function __construct($integer = 0) {
            $this->integer = $integer;
        }

        public function __toString() {
            return (string)$this->integer;
        }
    }
}

if(!class_exists("Float")) {
    class Float {

    }
}

if(!class_exists("Math")) {
    class Math {

    }
}

if(!class_exists("Time")) {
    class Time {

    }
}

if(!class_exists("File")) {
    class File {

    }
}