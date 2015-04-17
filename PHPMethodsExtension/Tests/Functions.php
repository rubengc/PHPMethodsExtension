<?php

require_once(__DIR__ ."/../PHPMethodsExtension.php");

const BR = "<br>";

// Functions test
echo capitalize("hello, world!").BR;                                                // Hello, world!
echo capitalize("hello, world!", ", ").BR;                                          // Hello, World!
var_dump(capitalize(array("hello,", " world!")));                                   // ArrayList(2){(String)"Hello,", (String)"World!"}

echo String::parse(contains("Hello, World!", "hello")).BR;                          // (String)false
echo String::parse(containsIgnoreCase("Hello, World!", "hello")).BR;                // (String)true
echo String::parse(contains(array("Hello,", " World!"), "hello")).BR;               // (String)false
echo String::parse(containsIgnoreCase(array("Hello,", " World!"), "hello")).BR;     // (String)true

echo String::parse(endsWith("Hello, World!", "world!")).BR;                         // (String)false
echo String::parse(endsWithIgnoreCase("Hello, World!", "world!")).BR;               // (String)true

echo String::parse(equals("Hello, World!", "hello, world!")).BR;                    // (String)false
echo String::parse(equalsIgnoreCase("Hello, World!", "hello, world!")).BR;          // (String)true

echo indexOf("Hello, World!", "w").BR;                                              // -1
echo indexOfIgnoreCase("Hello, World!", "w").BR;                                    // 7
echo indexOf(array("Hello,", " World!"), "hello,").BR;                              // -1
echo indexOfIgnoreCase(array("Hello,", " World!"), "hello,").BR;                    // 0

echo lastIndexOf("HELLO, WORLD!", "o").BR;                                          // -1
echo lastIndexOfIgnoreCase("HELLO, WORLD!", "o").BR;                                // 8
echo lastIndexOf(array("Hello", "Hello"), "hello,").BR;                             // -1
echo lastIndexOfIgnoreCase(array("Hello", "Hello"), "hello").BR;                    // 1

echo length("Hello, World!").BR;                                                    // 13
echo length(array("Hello,", " World!")).BR;                                         // 2
echo length(666).BR;                                                                // 3
echo length(666.66).BR;                                                             // 6 (counts the dot)
echo length(true).BR;                                                               // 1
echo length(false).BR;                                                              // 0
echo length(null).BR;                                                               // 0

echo parseInt("12")+parseInt("8").BR;                                               // 20
echo parseFloat("10.5")+parseFloat("9.5").BR;                                       // 20.0
echo parseFloat("10.123", 2, ",", "").BR;                                           // 10,12

echo replace("Hello, Foo!", "Foo", "World").BR;                                     // (String)Hello, World!
echo replace(array("Foo", "Bar", "Foo"), "Foo", "World").BR;                        // ArrayList(3){(String)World, (String)Bar, (String)World}
echo replaceIgnoreCase("Hello, Foo!", "foo", "World").BR;                           // (String)Hello, World!
echo replaceIgnoreCase(array("Foo", "Bar", "Foo"), "foo", "World").BR;              // ArrayList(3){(String)World, (String)Bar, (String)World}

echo String::parse(startsWith("Hello, World!", "hello")).BR;                        // (String)false
echo String::parse(startsWithIgnoreCase("Hello, World!", "hello")).BR;              // (String)true

echo String::parse(inArray(array("Foo", "Bar"), "foo")).BR;                         // (String)false
echo String::parse(inArrayIgnoreCase(array("Foo", "Bar"), "foo")).BR;               // (String)true