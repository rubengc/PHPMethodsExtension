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

/*
 * Define if methods returns php primitive types(like array) or PHPMethodsExtension(PME) objects(like ArrayList)
 */
define("RETURN_PME_OBJECTS", false);

/*
 * Define the separator to be used when an ArrayList is converted to String
 */
define("ARRAYLIST_SEPARATOR", ",");

define("ONLY_LETTERS", "0");
define("ONLY_LETTERS_LOWER_CASE", "1");
define("ONLY_LETTERS_UPER_CASE", "2");
define("ONLY_NUMBERS", "3");
define("ALPHANUMERIC", "4");

define("LANGUAGES",
    serialize(array(
        "english",
        "spanish"
    ))
);

define("FULL_MONTH_NAMES",
    serialize(array(
        "english" => array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"),
        "spanish" => array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre")
    ))
);

define("SHORT_MONTH_NAMES",
    serialize(array(
        "english" => array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"),
        "spanish" => array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic")
    ))
);

if(!function_exists("getFullMonthName")) {
    function getFullMonthName($index, $language = "english") {
        $fullMonthNames = unserialize(FULL_MONTH_NAMES);

        if(is_array($fullMonthNames))
            return $fullMonthNames[$language][$index];
        else
            return $fullMonthNames;
    }
}

if(!function_exists("getShortMonthName")) {
    function getShortMonthName($index, $language = "english") {
        $shortMonthNames = unserialize(SHORT_MONTH_NAMES);
        if(is_array($shortMonthNames))
            return $shortMonthNames[$language][$index];
        else
            return $shortMonthNames;
    }
}
