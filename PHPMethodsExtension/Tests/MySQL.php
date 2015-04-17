<?php

require_once(__DIR__ ."/../PHPMethodsExtension.php");

const BR = "<br>";

// MySQL class test
$mysql = new MySQl();                                                               // Activates the SQL constructor mode if MySQL() doesn't receive any arguments
echo $mysql->select("*")->from("Example")->where("id", 1).BR;                       // SELECT * FROM Example WHERE id = 1
$mysql->reset();
echo $mysql->select()->from("Example")->where("id >= 1").BR;                        // SELECT * FROM Example WHERE id >= 1
$mysql->reset();
echo $mysql->from("Example")->notWhere("id", 1).BR;                                 // SELECT * FROM Example WHERE id != 1
$mysql->reset();

// Select and from
echo $mysql->select("id, name")->from("Example").BR;                                // SELECT id, name FROM Example
$mysql->reset();
echo $mysql->select(array("a.id"))->from("TabA", "a").BR;                           // SELECT a.id FROM TabA AS a
$mysql->reset();
echo $mysql->from("TabA", "a")->from("TabB", "b").BR;                               // SELECT * FROM TabA AS a, TabB AS b
$mysql->reset();
echo $mysql->select(["a.id","b.id"])->from("TabA AS a, TabB AS b").BR;              // SELECT a.id, b.id FROM TabA AS a, TabB AS b
$mysql->reset();
echo $mysql->select(["a.id","b.id"])->from(["TabA AS a","TabB AS b"]).BR;           // SELECT a.id, b.id FROM TabA AS a, TabB AS b
$mysql->reset();
echo $mysql->from(["TabA" => "a","TabB" =>"b"]).BR;                                 // SELECT * FROM TabA AS a, TabB AS b
$mysql->reset();

// Where
echo $mysql->from("Table")->where("id", 1).BR;                                      // SELECT * FROM Table WHERE id = 1
$mysql->reset();
echo $mysql->from("Table")->notWhere("id", 1).BR;                                   // SELECT * FROM Table WHERE id != 1
$mysql->reset();
echo $mysql->from("Table")->where("id != 1")->where("name", null).BR;               // SELECT * FROM Table WHERE id != 1 AND name IS NULL
$mysql->reset();
echo $mysql->from("Table")->notWhere("id = 1")->notWhere("name", null).BR;          // SELECT * FROM Table WHERE id = 1 AND name IS NOT NULL
$mysql->reset();
echo $mysql->from("Table")->andWhere("id", 1)->andWhere("name", "hello").BR;        // SELECT * FROM Table WHERE id = 1 AND name = 'hello'
$mysql->reset();
echo $mysql->from("Table")->orWhere("id", 1)->orWhere("name", "hello").BR;          // SELECT * FROM Table WHERE id = 1 OR name = 'hello'
$mysql->reset();
echo $mysql->from("Table")->andNotWhere("id", 1)->andNotWhere("name", "hello").BR;  // SELECT * FROM Table WHERE id != 1 AND name != 'hello'
$mysql->reset();
echo $mysql->from("Table")->orNotWhere("id", 1)->orNotWhere("name", "hello").BR;    // SELECT * FROM Table WHERE id != 1 OR name != 'hello'
$mysql->reset();

// Like
echo $mysql->from("Table")->like("name", "Hello%")->like("name", "%World%").BR;     // SELECT * FROM Table WHERE name LIKE 'Hello%' AND name LIKE '%World%'
$mysql->reset();
echo $mysql->from("Table")->notLike("name","Hello%")->notLike("name","%World%").BR; // SELECT * FROM Table WHERE name NOT LIKE 'Hello%' AND name NOT LIKE '%World%'
$mysql->reset();
echo $mysql->from("Table")->andLike("name","Hello%")->andLike("name","%World%").BR; // SELECT * FROM Table WHERE name LIKE 'Hello%' AND name LIKE '%World%'
$mysql->reset();
echo $mysql->from("Table")->orLike("name","Hello%")->orLike("name","%World%").BR;   // SELECT * FROM Table WHERE name LIKE 'Hello%' OR name LIKE '%World%'
$mysql->reset();
echo $mysql->from("Table")->andNotLike("name","H%")->andNotLike("name","%W%").BR;   // SELECT * FROM Table WHERE name NOT LIKE 'H%' AND name NOT LIKE '%W%'
$mysql->reset();
echo $mysql->from("Table")->orNotLike("name","H%")->orNotLike("name","%W%").BR;     // SELECT * FROM Table WHERE name NOT LIKE 'H%' OR name NOT LIKE '%W%'
$mysql->reset();

// GroupBy
echo $mysql->from("Table")->groupBy("name").BR;                                     // SELECT * FROM Table GROUP BY name
$mysql->reset();
echo $mysql->from("Table")->groupBy("id, name").BR;                                 // SELECT * FROM Table GROUP BY id, name
$mysql->reset();
echo $mysql->from("Table")->groupBy(["id", "name"]).BR;                             // SELECT * FROM Table GROUP BY id, name
$mysql->reset();

// OrderBy
echo $mysql->from("Table")->orderBy("name").BR;                                     // SELECT * FROM Table ORDER BY name ASC
$mysql->reset();
echo $mysql->from("Table")->orderBy("id, name", "DESC").BR;                         // SELECT * FROM Table ORDER BY id, name DESC
$mysql->reset();
echo $mysql->from("Table")->orderBy(["id", "name"]).BR;                             // SELECT * FROM Table ORDER BY id, name ASC
$mysql->reset();
echo $mysql->from("Table")->orderBy(["id", "name"], "DESC").BR;                     // SELECT * FROM Table ORDER BY id, name DESC
$mysql->reset();

// Limit
echo $mysql->from("Table")->limit(10).BR;                                           // SELECT * FROM Table LIMIT 10
$mysql->reset();
echo $mysql->from("Table")->limit(10, 5).BR;                                        // SELECT * FROM Table LIMIT 5, 10
$mysql->reset();

// Insert
$example = new ArrayList(array("name" => "Hello"));
echo $mysql->insert("Table", $example).BR;                                          // INSERT INTO Table (name) VALUES ('Hello')
$mysql->reset();

// Update
echo $mysql->where("id", 1)->update("Table", $example).BR;                          // UPDATE Table SET name = 'Hello' WHERE id = 1
$mysql->reset();

// DELETE
echo $mysql->where("id", 1)->delete("Table").BR;                                    // DELETE FROM Table WHERE id = 1
$mysql->reset();

/*
 * Example table
 * +----+---------+---------+
 * | id |   name  | surname |
 * +----+---------+---------+
 * |  1 |    john |     doe |
 * +----+---------+---------+
 * |  2 |   lorem |   ipsum |
 * +----+---------+---------+
 * |  3 | rubengc |     dev |
 * +----+---------+---------+
 */
$mysql = new MySQl("127.0.0.1", "root", "", "Database");                            // Default port
$mysql = new MySQl("127.0.0.1", "root", "", "Database", 3306);                      // Port=3306

// Select
echo $mysql->from("Example")->getAll().BR;                                          // 1,john,doe,2,lorem,ipsum,3,rubengc,dev

// Insert
$newExample = new ArrayList(array("name" => "new", "surname" => "new"));
echo $mysql->insert("Example", $newExample).BR;                                     // true
echo $mysql->from("Example")->getAll().BR;                                          // 1,john,doe,2,lorem,ipsum,3,rubengc,dev,4,new,new