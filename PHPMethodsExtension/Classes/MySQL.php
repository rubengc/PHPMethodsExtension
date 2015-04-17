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

if(!class_exists("MySQL")) {
    class MySQL {
        private $mysql;
        private $mode;

        private $sql;
        private $type;

        private $select;
        private $table;
        private $where;
        private $set;
        private $groupBy;
        private $orderBy;
        private $orderByOrder;
        private $limit;
        private $limitOffset;

        private $values;

        public function __construct($host = "", $username = "", $password = "", $database = "", $port = null)
        {
            if($host != "") {
                if ($port == null)
                    $port = ini_get("mysqli.default_port");

                $this->mysql = new mysqli($host, $username, $password, $database, $port);

                $this->mysql->set_charset("utf8");

                $this->mode = "connection";
            } else {
                $this->mode = "constructor";
            }

            $this->reset();
        }

        public function __destruct()
        {
            if($this->mode == "connection")
                $this->mysql->close();
        }

        public function __toString() {
            $this->build();

            return $this->sql;
        }

        public function query($sql, $params = array()) {
            $this->sql = $sql;
        }

        public function select($fields = "*") {
            $this->type = "select";
            $type = gettype($fields);

            if($this->select != "")
                $this->select .= ", ";

            if($type == "string") {
                $this->select .= $fields;
            } else if($type == "array") {
                $this->select .= implode(", ", $fields);
            }

            return $this;
        }

        public function insert($table, $values = null) {
            $this->type = "insert";
            $this->table = $table;

            if($values != null)
                $this->set($values);

            if($this->mode == "connection") {
                $stmt = $this->execute();

                return $this->getResults($stmt);
            } else {
                return $this;
            }
        }

        public function update($table, $values = null) {
            $this->type = "update";
            $this->table = $table;

            if($values != null)
                $this->set($values);

            if($this->mode == "connection") {
                $stmt = $this->execute();

                return $this->getResults($stmt);
            } else {
                return $this;
            }
        }

        public function delete($table) {
            $this->type = "delete";
            $this->table = $table;

            if($this->mode == "connection") {
                $stmt = $this->execute();

                return $this->getResults($stmt);
            } else {
                return $this;
            }
        }

        public function from($table, $alias = null) {
            $this->type = "select";
            $type = gettype($table);

            if($this->table != "")
                $this->table .= ", ";

            if($type == "string") {
                $this->table .= $table.(($alias != null)?" AS ".$alias:"");
            } else if($type == "array") {
                foreach($table as $key => $value) {
                    if(gettype($key) == "string")
                        $this->from($key, $value);
                    else
                        $this->from($value);
                }
            }

            return $this;
        }

        public function where($field, $value = null) { return $this->buildWhere($field, "=", $value); }
        public function notWhere($field, $value = null) { return $this->buildWhere($field, "!=", $value); }
        public function andWhere($field, $value = null) { return $this->buildWhere($field, "=", $value); }
        public function andNotWhere($field, $value = null) { return $this->buildWhere($field, "!=", $value); }
        public function orWhere($field, $value = null) { return $this->buildWhere($field, "=", $value, "OR"); }
        public function orNotWhere($field, $value = null) { return $this->buildWhere($field, "!=", $value, "OR"); }

        public function like($field, $value = null) { return $this->buildWhere($field, "LIKE", $value); }
        public function notLike($field, $value = null) { return $this->buildWhere($field, "NOT LIKE", $value); }
        public function andLike($field, $value = null) { return $this->buildWhere($field, "LIKE", $value); }
        public function andNotLike($field, $value = null) { return $this->buildWhere($field, "NOT LIKE", $value); }
        public function orLike($field, $value = null) { return $this->buildWhere($field, "LIKE", $value, "OR"); }
        public function orNotLike($field, $value = null) { return $this->buildWhere($field, "NOT LIKE", $value, "OR"); }

        private function buildWhere($field, $comparisonOperator = "=", $value = null, $logicalOperator = "AND") {
            if($this->where != "")
                $this->where .= " ";

            if(count(explode(" ", $field)) > 1) {
                if($this->where == "")
                    $this->where .= $field;
                else
                    $this->where .= $logicalOperator." ".$field;
            } else {
                $value = $this->parseValue($value);

                if($value == "NULL") {
                    if($comparisonOperator == "=")
                        $comparisonOperator = "IS";
                    else if($comparisonOperator == "!=")
                        $comparisonOperator = "IS NOT";
                }

                if($this->where == "") {
                    $this->where .= $field . " " . $comparisonOperator . " " . $value;
                } else {
                    $this->where .= $logicalOperator . " " . $field . " " . $comparisonOperator . " " . $value;
                }
            }

            return $this;
        }

        public function buildSet() {
            if($this->set != "")
                $this->set .= ", ";
        }

        public function groupBy($fields) {
            $type = gettype($fields);

            if($this->groupBy != "")
                $this->groupBy .= ", ";

            if($type == "string") {
                $this->groupBy .= $fields;
            } else if($type == "array") {
                $this->groupBy .= implode(", ", $fields);
            }

            return $this;
        }

        public function orderBy($fields, $order = "ASC") {
            $type = gettype($fields);

            if($this->orderBy != "")
                $this->orderBy .= ", ";

            if($type == "string") {
                $this->orderBy .= $fields;
            } else if($type == "array") {
                $this->orderBy .= implode(", ", $fields);
            }

            $this->orderByOrder = $order;

            return $this;
        }

        public function limit($records, $offset = -1) {
            $this->limit = $records;

            if($offset > -1)
                $this->limitOffset = $offset;

            return $this;
        }

        public function set($values) {
            if(gettype($values) == "array")
                $this->values = $values;
            elseif(get_class($values) == "ArrayList")
                $this->values = $values->toArray();

            return $this;
        }

        public function get() {

        }

        public function getAll() {
            $stmt = $this->execute();

            return $this->getResults($stmt);
        }

        public function getBy($fields) {
            $this->type = "select";
        }

        public function getOne() {

        }

        public function getOneBy($fields) {
            $this->type = "select";
        }

        public function getSQL() {
            return $this->sql;
        }

        public function getResults(mysqli_stmt $stmt) {
            $parameters = array();
            $results = array();

            $metadata = $stmt->result_metadata();

            if(!$metadata && $stmt->sqlstate)
                return PMEReturn(true);

            $row = array();
            while($field = $metadata->fetch_field()) {
                $row[$field->name] = null;
                $parameters[] = &$row[$field->name];
            }

            $stmt->store_result();

            call_user_func_array(array($stmt, 'bind_result'), $parameters);

            while($stmt->fetch()) {
                $x = array();
                foreach ($row as $key => $value) {
                    $x[$key] = $value;
                }
                array_push($results, $x);
            }

            return PMEReturn($results);
        }

        private function build() {
            if($this->type == "insert")
                $this->buildInsert();
            else if($this->type == "update")
                $this->buildUpdate();
            else if($this->type == "delete")
                $this->buildDelete();
            else
                $this->buildSelect();
        }

        private function buildSelect() {
            $this->sql = "SELECT ".(($this->select == "")?"*":$this->select)." ";
            $this->sql .= "FROM ".(($this->table == "")?"Table":$this->table)." ";

            if($this->where != "")
                $this->sql .= "WHERE ".$this->where." ";

            if($this->groupBy != "")
                $this->sql .= "GROUP BY ".$this->groupBy." ";

            if($this->orderBy != "")
                $this->sql .= "ORDER BY ".$this->orderBy." ".$this->orderByOrder." ";

            if($this->limit > -1)
                $this->sql .= "LIMIT ".($this->limitOffset > -1?$this->limitOffset.", ":"").$this->limit." ";
        }

        private function buildInsert() {
            $this->sql = "INSERT INTO ".$this->table." "
                ."(".implode(", ", array_keys($this->values)).") "
                ."VALUES (".implode(", ", array_map(function ($value) {return $this->parseValue($value);}, $this->values)).")";
        }

        private function buildUpdate() {
            $this->sql = "UPDATE ".$this->table." "
                ."SET ".implode(", ", array_map(function ($value, $key) {
                    return $key." = ".$this->parseValue($value);
                }, $this->values, array_keys($this->values)))." ";

            if($this->where != "")
                $this->sql .= "WHERE ".$this->where." ";

            if($this->orderBy != "")
                $this->sql .= "ORDER BY ".$this->orderBy." ".$this->orderByOrder." ";

            if($this->limit > -1)
                $this->sql .= "LIMIT ".($this->limitOffset > -1?$this->limitOffset.", ":"").$this->limit." ";
        }

        private function buildDelete() {
            $this->sql = "DELETE FROM ".$this->table." ";

            if($this->where != "")
                $this->sql .= "WHERE ".$this->where." ";

            if($this->orderBy != "")
                $this->sql .= "ORDER BY ".$this->orderBy." ".$this->orderByOrder." ";

            if($this->limit > -1)
                $this->sql .= "LIMIT ".($this->limitOffset > -1?$this->limitOffset.", ":"").$this->limit." ";
        }

        private function prepare() {
            if (!$stmt = $this->mysql->prepare($this->sql))
                throw new Exception($this->mysql->error, E_USER_ERROR);

            return $stmt;
        }

        private function bindParams() {
            $stmt = $this->prepare();

            return $stmt;
        }

        private function execute() {
            $this->build();
            $stmt = $this->bindParams();
            $stmt->execute();
            $this->reset();

            return $stmt;
        }

        public function reset() {
            $this->sql = "";
            $this->select = "";
            $this->table = "";
            $this->where = "";
            $this->groupBy = "";
            $this->orderBy = "";
            $this->orderByOrder = "ASC";
            $this->limit = -1;
            $this->limitOffset = -1;
            $this->values = array();

            return $this;
        }

        private function parseValue($object) {
            if(gettype($object) == "string") {
                return "'" . $object . "'";
            } else if(gettype($object) == "object") {
                if(get_class($object) == "String")
                    return "'".$object."'";
                else
                    return $object;
            } else if(gettype($object) == "NULL") {
                return "NULL";
            } else {
                return $object;
            }
        }
    }
}