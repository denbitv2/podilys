<?php
/**
 * Created by PhpStorm.
 * User: d.barsuk
 * Date: 29.05.2017
 * Time: 10:36
 */

function add($x){
    $dbhandle = new PDO('sqlite:mysqlitedb.db');// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "insert into  problems(`name`,`content`) values('".$x[0]."','".$x[1]."')";
    $dbhandle->query($query);
    print_r( $dbhandle->errorInfo());

}


function create(){

$dbhandle = new PDO('sqlite:mysqlitedb.db');// sqlite_open('mysqlitedb', 0666, $sqliteerror);
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
function show(){
global $problems,$issues;
    $dbhandle = new PDO('sqlite:mysqlitedb.db');// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "select name,content from problems";
    $x=$dbhandle->query($query);
    //print_r( $dbhandle->errorInfo());
    $result=$x->fetchAll();
    $generate='';
    foreach ($result as $key){
        $generate.="<h3>{$key['name']}</h3><p style='font-size:10px;'>{$key['content']}</p>";
    }
    $problems=$generate;
	 $query  = "select name,content from secrets";
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
show();
if($_GET['action']=='add'){
	$x[0]=$_POST['topic'];
	$x[1]=$_POST['content'];
	if(!empty($x[0])&&!empty($x[1])){
	add($x);
	}
}

?>