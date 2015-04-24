<?php

require_once(__DIR__ ."/../PHPMethodsExtension.php");

const BR = "<br>";

// ArrayList class test
$arrayList = new ArrayList(array("hello", 1, 12.5, true));
echo $arrayList.BR;                                                                 // hello,1,12.5,1
$arrayList = new ArrayList(["hello", 1, 12.5, true]);
echo $arrayList.BR;                                                                 // hello,1,12.5,1
$arrayList = new ArrayList("hello", 1, 12.5, true);
echo $arrayList.BR;                                                                 // hello,1,12.5,1
echo $arrayList->add("world").BR;                                                   // hello,1,12.5,1,world
echo $arrayList->add("words", 2).BR;                                                // hello,1,12.5,1,world,2

$arrayList->each(function($value, $key) {
    echo $key." => ".$value.BR;
});

$arrayList->each(function($value) {
    echo $value.BR;
});

foreach($arrayList as $key => $value) {
    echo $key." => ".$value.BR;
}

echo $arrayList->get(0).BR;                                                         // hello
echo $arrayList[0].BR;                                                              // hello
echo String::parse(isset($arrayList[0])).BR;                                        // (String)true
echo $arrayList->get("words").BR;                                                   // 2
echo $arrayList["words"].BR;                                                        // 2
echo $arrayList->indexOf("world").BR;                                               // 3 (if i don't use an strict search, returns the index of true)
echo $arrayList->indexOf(2, true).BR;                                               // words
echo $arrayList->lastIndexOf(1).BR;                                                 // 3
echo $arrayList->join("-").BR;                                                      // hello-1-12.5-1-world-2
echo $arrayList->length().BR;                                                       // 6
echo count($arrayList).BR;                                                          // 6
echo $arrayList->remove("words").BR;                                                // hello,1,12.5,1,world
echo $arrayList->remove(3).BR;                                                      // hello,1,12.5,world
echo $arrayList->set(3, "true").BR;                                                 // hello,1,12.5,true,world
unset($arrayList[3]);
echo $arrayList.BR;                                                                 // hello,1,12.5,world
$arrayList[3] = "true";
echo $arrayList.BR;                                                                 // hello,1,12.5,true,world
echo $arrayList->subList(2).BR;                                                     // 12.5,true,world
echo $arrayList->toJson().BR;                                                       // {"0":"hello","1":1,"2":12.5,"4":"world","3":"true"}

$arrayList = new ArrayList(["a" => 0, "b" => 1, "c" => 2, "d" => 10]);
echo $arrayList->keySort().BR;                                                      // 0,1,2,10
echo $arrayList->keySort(SORT_DESC).BR;                                             // 10,2,1,0
echo $arrayList->keySort(SORT_ASC, SORT_NATURAL).BR;                                // 0,1,2,10
echo $arrayList->keySortInverse().BR;                                               // 10,2,1,0
echo $arrayList->keySortInverse(SORT_NATURAL).BR;                                   // 10,2,1,0
echo $arrayList->sort().BR;                                                         // 0,1,10,2
echo $arrayList->sort(SORT_DESC).BR;                                                // 2,10,1,0
echo $arrayList->sort(SORT_ASC, SORT_NATURAL).BR;                                   // 0,1,2,10
echo $arrayList->sort(SORT_ASC, SORT_NATURAL, false).BR;                            // 0,1,2,10 (without maintain keys)
echo $arrayList->sortInverse().BR;                                                  // 2,10,1,0
echo $arrayList->sortInverse(SORT_NATURAL).BR;                                      // 10,2,1,0
echo $arrayList->sortInverse(SORT_NATURAL, false).BR;                               // 10,2,1,0 (without maintain keys)
echo $arrayList->randomSort().BR;                                                   // ??? sorts randomly
echo $arrayList->randomSort(false).BR;                                              // ??? sorts randomly (without maintain keys)

$arrayList = new ArrayList(["a" => "Hello", "b" => "hello", "c" => "World", "d" => "world"]);
echo $arrayList->naturalSort().BR;                                                  // Hello,World,hello,world
echo $arrayList->naturalSort(true).BR;                                              // hello,Hello,world,World
echo $arrayList->naturalSort().BR;                                                  // Hello,World,hello,world
echo $arrayList->naturalSortIgnoreCase().BR;                                        // hello,Hello,world,World

/*
 * ArrayList dynamic methods
 * You can get and set values using methods with the same name that the key
 * Example:
 * "name" => "rubengc" || "NAME" => "rubengc"
 * You can get this value using getName, getname or getNAME
 * You can set this value using setName, setname or setNAME
 * "Name" => "rubengc"
 * You can get this value using getName only
 * You can set this value using setName only
 * "myName" => "rubengc"
 * You can get this value using getMyName or getmyName
 * You can set this value using setMyName or setmyName
 * "MyName" => "rubengc"
 * You can get this value using getMyName only
 * You can set this value using setMyName only
 */
$arrayList = new ArrayList(["hello" => 1, "Hello" => "Hi", "world" => 2, "World" => "Hi", "something" => 3]);
echo $arrayList->getHello().BR;                                                     // Hi
echo $arrayList->gethello().BR;                                                     // 1
echo $arrayList->getHELLO().BR;                                                     // 1
echo $arrayList->getSomething().BR;                                                 // 3
echo $arrayList->setWorld("hello").BR;                                              // 1,Hi,2,hello,3
echo $arrayList->setworld("hello").BR;                                              // 1,Hi,hello,hello,3
echo $arrayList->setSomething("world").BR;                                          // 1,Hi,hello,hello,world
echo $arrayList->setsomething("hello").BR;                                          // 1,Hi,hello,hello,hello