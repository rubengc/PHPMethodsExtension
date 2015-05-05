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

// STRING

/**
 * Capitalizes the string. If $delimiter isn't null, then capitalize all strings by $delimiter.
 *
 * @param $string string
 * @param $delimiter string
 * @return string
 */
if(!function_exists("capitalize")) {
    function capitalize($object, $delimiter = null) {
        $type = gettype($object);

        if($type == "string") {
            if($delimiter != null) {
                $array = explode($delimiter, $object);
                $arrayAux = array();

                foreach($array as $item)
                    $arrayAux[] = ucfirst($item);

                $object = implode($delimiter, $arrayAux);
            } else {
                $object = ucfirst($object);
            }
        } else if($type == "array") {
            $arrayAux = array();

            foreach($object as $item)
                $arrayAux[] = capitalize($item, $delimiter);

            $object = $arrayAux;
        }

        return PMEReturn($object);
    }
}

/**
 * Returns true if $haystack contains $needle. Returns true if $needle is an empty string.
 *
 * @param $haystack mixed
 * @param $needle string
 * @param $ignoreCase bool
 * @return bool
 */
if(!function_exists("contains")) {
    function contains($haystack, $needle, $ignoreCase = false) {
        $type = gettype($haystack);

        if($type == "string") {
            if ($ignoreCase) {
                $haystack = strtolower($haystack);
                $needle = strtolower($needle);
            }

            return $needle === "" || strpos($haystack, $needle) !== false;
        } else if($type == "array") {
            foreach($haystack as $value)
                if(contains($value, $needle, $ignoreCase))
                    return true;
        }

        return false;
    }
}

if(!function_exists("containsIgnoreCase")) {
    function containsIgnoreCase($haystack, $needle) {
        return contains($haystack, $needle, true);
    }
}

/**
 * Returns true if $string ends with $needle. Returns true if $needle is an empty string.
 *
 * @param $string string
 * @param $suffix string
 * @param $ignoreCase bool
 * @return bool
 */
if(!function_exists("endsWith")) {
    function endsWith($string, $suffix, $ignoreCase = false) {
        if($ignoreCase) {
            $string = strtolower($string);
            $suffix = strtolower($suffix);
        }

        return $suffix === "" || strpos($string, $suffix, strlen($string)-strlen($suffix)) !== false;
    }
}

if(!function_exists("endsWithIgnoreCase")) {
    function endsWithIgnoreCase($string, $suffix) {
        return endsWith($string, $suffix, true);
    }
}

if(!function_exists("equals")) {
    function equals($stringX, $stringY, $ignoreCase = false) {
        if($ignoreCase) {
            $stringX = strtolower($stringX);
            $stringY = strtolower($stringY);
        }

        return $stringX === $stringY;
    }
}

if(!function_exists("equalsIgnoreCase")) {
    function equalsIgnoreCase($stringX, $stringY) {
        return equals($stringX, $stringY, true);
    }
}

if(!function_exists("indexOf")) {
    function indexOf($haystack, $needle, $offset = 0, $ignoreCase = false) {
        $type = gettype($haystack);
        $index = false;

        if($type == "string") {
            if ($ignoreCase) {
                $haystack = strtolower($haystack);
                $needle = strtolower($needle);
            }

            $index = strpos($haystack, $needle, $offset);
        } else if($type == "array") {
            if ($ignoreCase) {
                $haystack = array_map("strtolower", $haystack);
                $needle = strtolower($needle);
            }

            foreach($haystack as $key => $value)
                if ((($ignoreCase)?$needle == $value:$needle === $value) || (is_array($value) && indexOf($value, $needle, $offset, $ignoreCase) !== -1))
                    $index = $key;
        }

        return $index !== false ? $index : -1;
    }
}

if(!function_exists("indexOfIgnoreCase")) {
    function indexOfIgnoreCase($haystack, $needle, $offset = 0) {
        return indexOf($haystack, $needle, $offset, true);
    }
}

if(!function_exists("lastIndexOf")) {
    function lastIndexOf($haystack, $needle, $offset = 0, $ignoreCase = false) {
        $type = gettype($haystack);
        $index = false;

        if($type == "string") {
            if ($ignoreCase) {
                $haystack = strtolower($haystack);
                $needle = strtolower($needle);
            }

            $index = strrpos($haystack, $needle, $offset);
        } else if($type == "array") {
            if ($ignoreCase) {
                $haystack = array_map("strtolower", $haystack);
                $needle = strtolower($needle);
            }

            foreach($haystack as $key => $value)
                if ((($ignoreCase)?$needle == $value:$needle === $value) || (is_array($value) && indexOf($value, $needle, $offset, $ignoreCase) !== -1))
                    $index = $key;
        }

        return $index !== false ? $index : -1;
    }
}

if(!function_exists("lastIndexOfIgnoreCase")) {
    function lastIndexOfIgnoreCase($haystack, $needle, $offset = 0) {
        return lastIndexOf($haystack, $needle, $offset, true);
    }
}

if(!function_exists("length")) {
    function length($object) {
        switch(gettype($object)) {
            case "boolean": return (($object)?1:0);
            case "integer": return strlen((string)$object);
            case "double":  return strlen((string)$object);
            case "string":  return strlen($object);
            case "array":   return count($object);
            case "object":  return (($object)?1:0);
            case "resource":  return (($object)?1:0);
            case "NULL":  return 0;
            default: return 0;
        }
    }
}

if(!function_exists("parseInt")) {
    function parseInt($object, $base = 10) {
        return intval($object, $base);
    }
}

if(!function_exists("parseFloat")) {
    function parseFloat($object, $decimals = -1, $decimalPoint = ".", $thousandsSeparator = ",") {
        if($decimals >= 0)
            return number_format(floatval($object), $decimals, $decimalPoint, $thousandsSeparator);

        return floatval($object);
    }
}

if(!function_exists("replace")) {
    function replace($object, $search, $replace, $count = null, $ignoreCase = false) {
        $type = gettype($object);

        if($type == "string") {
            if ($ignoreCase)
                $object = str_ireplace($search, $replace, $object, $count);
            else
                $object = str_replace($search, $replace, $object, $count);
        } else if($type == "array") {
            $arrayAux = array();

            foreach($object as $item) {
                $arrayAux[] = replace($item, $search, $replace, $count, $ignoreCase);
            }

            $object = $arrayAux;
        }

        return PMEReturn($object);
    }
}

if(!function_exists("replaceIgnoreCase")) {
    function replaceIgnoreCase($object, $search, $replace, $count = null) {
        return replace($object, $search, $replace, $count, true);
    }
}

/**
 * Returns true if $haystack starts with $needle. Returns true if $needle is an empty string.
 *
 * @param $string string
 * @param $prefix string
 * @param $ignoreCase bool
 * @return bool
 */
if(!function_exists("startsWith")) {
    function startsWith($string, $prefix, $ignoreCase = false) {
        if($ignoreCase) {
            $string = strtolower($string);
            $prefix = strtolower($prefix);
        }

        return $prefix === "" || strrpos($string, $prefix, -strlen($string)) !== false;
    }
}

if(!function_exists("startsWithIgnoreCase")) {
    function startsWithIgnoreCase($string, $prefix) {
        return startsWith($string, $prefix, true);
    }
}

// ARRAY

if(!function_exists("inArray")) {
    function inArray(array $haystack, $needle, $strict = false, $ignoreCase = false) {
        if($ignoreCase) {
            $haystack = array_map("strtolower", $haystack);
            $needle = strtolower($needle);
        }

        foreach($haystack as $key => $value)
            if((($strict)? $needle === $value : $needle == $value) || (is_array($value) && inArray($value, $needle, $strict) !== false))
                return $key;

        return false;
    }
}

if(!function_exists("inArrayIgnoreCase")) {
    function inArrayIgnoreCase(array $haystack, $needle, $strict = false) {
        return inArray($haystack, $needle, $strict, true);
    }
}

// DATE

if(!function_exists("daysInMonth")) {
    function daysInMonth($date) {
        return (integer)date("t", strtotime($date));
    }
}

/**
 * Calculates the difference of days between two dates
 *
 * @param $dateIn string
 * @param $dateOut string
 * @return integer
 */
if(!function_exists("daysDifference")) {
    function daysDifference($dateIn, $dateOut) {
        return round((strtotime($dateOut) - strtotime($dateIn))/(3600*24));
    }
}

if(!function_exists("monthName")) {
    function monthName($date, $language = "english", $full = true) {
        if($full)
            return getFullMonthName((integer)date("n", strtotime($date))-1, $language);
        else
            return getShortMonthName((integer)date("n", strtotime($date))-1, $language);
    }
}

if(!function_exists("monthNumber")) {
    function monthNumber($monthName, $leadingZero = false, $monthNamesConstant = FULL_MONTH_NAMES) {
        foreach(unserialize(LANGUAGES) as $language) {
            $monthNames = unserializeConstant($monthNamesConstant);

            if(is_array($monthNames))
                $monthNumber = inArray($monthNames[$language], $monthName, true);
            else
                $monthNumber = false;

            if($monthNumber !== false) {
                $monthNumber = (integer)$monthNumber+1;

                if($leadingZero)
                    return (($monthNumber < 10) ? "0" : "").$monthNumber;
                else
                    return $monthNumber;
            }
        }

        return 0;
    }
}

if(!function_exists("nextMonth")) {
    function nextMonth($format = "Y-m-d H:i:s", $date = "1991-09-22", $nextMonths = 1) {
        if(func_num_args() == 1) {
            $format = "Y-m-d";
            $date = func_get_arg(0);
        }

        return date($format, strtotime("+" . $nextMonths . " Months " . $date));
    }
}

if(!function_exists("previousMonth")) {
    function previousMonth($format = "Y-m-d H:i:s", $date = "1991-09-22", $previousMonths = 1) {
        if(func_num_args() == 1) {
            $format = "Y-m-d";
            $date = func_get_arg(0);
        }

        return date($format, strtotime("-" . $previousMonths . " Months " . $date));
    }
}

/*
 * Return an array with all dates (Y-m-d) between $startDate and $endDate (include them)
 *
 * @param date("Y-m-d")
 * @param date("Y-m-d")
 * @return array
 */
if(!function_exists("datesRange")) {
    function datesRange($from, $to, $format = "Y-m-d") {
        $dates = array();

        $fromTime = strtotime($from);
        $toTime = strtotime($to);

        $from = mktime(1, 0, 0, date("n", $fromTime), date("j", $fromTime), date("Y", $fromTime));
        $to = mktime(1, 0, 0, date("n", $toTime), date("j", $toTime), date("Y", $toTime));

        if($to >= $from) {
            array_push($dates, date($format, $from)); // first entry

            while($from < $to) {
                $from += 86400; // add 24 hours
                array_push($dates, date($format, $from));
            }
        }

        return $dates;
    }
}

// Terminal

/*
 * Execute a command and kill it if the timeout limit fired to prevent long php execution
 *
 * @see http://stackoverflow.com/questions/2603912/php-set-timeout-for-script-with-system-call-set-time-limit-not-working
 *
 * @param string $cmd Command to exec (you should use 2>&1 at the end to pipe all output)
 * @param integer $timeout
 * @return string Returns command output
 */
if(!function_exists("timeoutExec")) {
    function timeoutExec($cmd, $timeout = 5) {
        $descriptorspec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );
        $pipes = array();

        $timeout += time();
        $process = proc_open($cmd, $descriptorspec, $pipes);
        if (!is_resource($process)) {
            throw new \Exception("proc_open failed on command: '".$cmd."'");
        }

        $output = '';

        do {
            $timeleft = $timeout - time();
            $read = array($pipes[1]);
            stream_select($read, $write, $exeptions, $timeleft, NULL);

            if (!empty($read)) {
                $output .= fread($pipes[1], 8192);
            }
        } while (!feof($pipes[1]) && $timeleft > 0);

        if ($timeleft <= 0) {
            proc_terminate($process);
            throw new \Exception("Timeout exceeded on command: '".$cmd."'");
        } else {
            return $output;
        }
    }
}