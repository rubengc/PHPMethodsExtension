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

if(!class_exists("Date")) {
    class Date {
        private $date;
        private $format;

        public function __construct($format = "Y-m-d", $date) {
            $type = gettype($date);

            if($type == "string")
                $date = strtotime($date);

            $this->date = date($format, $date);
            $this->format = $format;
        }

        public function __toString() {
            return (string)$this->date;
        }

        public function daysInMonth() {
            return (integer)date("t", strtotime($this->date));
        }

        public function daysDifference($date) {
            return round((strtotime($this->date) - strtotime($date))/(3600*24));
        }

        public function getDay($leadingZeros = true) {
            return date((($leadingZeros)?"d":"j"), $this->date);
        }

        public function getFormat() {
            return $this->format;
        }

        public function getMonth($leadingZeros = true) {
            return date((($leadingZeros)?"m":"n"), $this->date);
        }

        public function getYear($twoDigit = false) {
            return date((($twoDigit)?"y":"Y"), $this->date);
        }

        public function isLeap() {
            return date("L", $this->date);
        }

        public function monthName($language = "english", $full = true) {
            if($full)
                return unserialize(FULL_MONTH_NAMES)[$language][(integer)date("n", strtotime($this->date))-1];
            else
                return unserialize(SHORT_MONTH_NAMES)[$language][(integer)date("n", strtotime($this->date))-1];
        }

        public function nextMonth($nextMonths = 1) {
            $this->date = date($this->format, strtotime("+" . $nextMonths . " Months " . $this->date));

            return $this;
        }

        public function previousMonth($previousMonths = 1) {
            $this->date = date($this->format, strtotime("-" . $previousMonths . " Months " . $this->date));

            return $this;
        }

        public function setFormat($format = "Y-m-d") {
            $this->date = date($format, strtotime($this->date));
            $this->format = $format;

            return $this;
        }
    }
}