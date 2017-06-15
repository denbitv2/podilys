<?php
/**
 * Created by PhpStorm.
 * User: d.barsuk
 * Date: 29.05.2017
 * Time: 10:36
 */
const DB='sqlite:dbs/mysqlitedb.db';
function add($subject,$x){
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "insert into  {$subject}(`name`,`content`) values('".$x[0]."','".$x[1]."')";
    $dbhandle->query($query);
    print_r( $dbhandle->errorInfo());

}


function create(){

$dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "create table problems(id int NOT NULL PRIMARY KEY, name VARCHAR(25),content text)";
    $dbhandle->query($query);
	print_r( $dbhandle->errorInfo());
	$query  = "create table secrets(id int NOT NULL PRIMARY KEY, name VARCHAR(25),content text)";
	$dbhandle->query($query);
   print_r( $dbhandle->errorInfo());
//sqlite_exec($dbhandle,$query);
 // sqlite_close($dbhandle);
}
$problems='';
$issues='';
function show($limit=true){
global $problems,$issues;
$qlimit=$limit?'limit 0,5':'';
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "select name,content from problems ORDER  by id desc $qlimit ";
    $x=$dbhandle->query($query);
    //print_r( $dbhandle->errorInfo());
    $result=$x->fetchAll();
    $generate='';
    foreach ($result as $key){
        $generate.="<h3>{$key['name']}</h3><p style='font-size:10px;'>{$key['content']}</p>";
    }
    $problems=$generate;
	 $query  = "select name,content from secrets ORDER  by id desc $qlimit";
    $x=$dbhandle->query($query);
    //print_r( $dbhandle->errorInfo());
    $result=$x->fetchAll();
    $generate='';
    foreach ($result as $key){
        $generate.="<h3>{$key['name']}</h3><p style='font-size:10px;'>{$key['content']}</p>";
    }
    $issues=$generate;
    //include_once 'map..html';
//sqlite_exec($dbhandle,$query);
    // sqlite_close($dbhandle);
}


?>