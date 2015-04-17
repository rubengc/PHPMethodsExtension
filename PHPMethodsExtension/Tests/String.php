<?php

require_once(__DIR__ ."/../PHPMethodsExtension.php");

const BR = "<br>";

// String class test
$string = new String("hello");
echo $string.BR;                                                                    // world!
echo $string->append(", world", "!").BR;                                            // hello, world!
echo $string->capitalize().BR;                                                      // Hello, world!
echo $string->capitalize(", ").BR;                                                  // Hello, World!
echo $string->charAt(1).BR;                                                         // e
echo $string[1].BR;                                                                 // e
echo $string->concat("How"," are ","you?").BR;                                      // Hello, World!How are you?
echo String::parse($string->contains("world")).BR;                                  // (String)false
echo String::parse($string->containsIgnoreCase("world")).BR;                        // (String)true
echo String::parse($string->endsWith("how are you?")).BR;                           // (String)false
echo String::parse($string->endsWithIgnoreCase("how are you?")).BR;                 // (String)true
echo String::parse($string->equals("hello, world!how are you?")).BR;                // (String)false
echo String::parse($string->equalsIgnoreCase("hello, world!how are you?")).BR;      // (String)true
echo $string->indexOf("world").BR;                                                  // -1
echo $string->indexOfIgnoreCase("world").BR;                                        // 7
echo $string->length().BR;                                                          // 25
echo $string->parseInt().BR;                                                        // 0
echo $string->parseFloat().BR;                                                      // 0
echo $string->prepend("I'm", " fine ").BR;                                          // I'm fine Hello, World!How are you?
echo $string->replace("how are you?", "").BR;                                       // I'm fine Hello, World!How are you?
echo $string->replace("I'm fine ", "").BR;                                          // Hello, World!How are you?
echo $string->replaceIgnoreCase("how are you?", "").BR;                             // Hello, World!
var_dump($string->split(", "));                                                     // ArrayList(2){(String)"Hello", (String)"World!"}
echo ($string->startsWith("hello")?"true":"false").BR;                              // false
echo ($string->startsWithIgnoreCase("hello")?"true":"false").BR;                    // true
echo $string->substring(7).BR;                                                      // World!
echo $string->toLowerCase().BR;                                                     // hello, world!
echo $string->toUpperCase().BR;                                                     // HELLO, WORLD!
echo $string->trim().BR;                                                            // Hello, World!
echo $string->valueOf(true).BR;                                                     // (String)true
echo String::parse(null).BR;                                                        // NULL

$string = new String("12.5");
echo $string->parseInt().BR;                                                        // 12
echo $string->parseFloat().BR;                                                      // 12.5
echo $string->concat("123")->parseFloat(2, ",", "").BR;                             // 12,51

$string = new String("   Testing trim   ");
echo $string->trim().BR;                                                            // Testing trim