<?php
/**
 * Created by PhpStorm.
 * User: d.barsuk
 * Date: 29.05.2017
 * Time: 10:36
 */
const DB='sqlite:dbs/real.db';
function add($subject,$x){
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query  = "insert into  {$subject}(`name`,`content`) values('".$x[0]."','".$x[1]."')";
    $dbhandle->query($query);
    print_r( $dbhandle->errorInfo());

}


function create(){
$log='';
$dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $log.= $query  = "create table problems(id INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT, name VARCHAR(25),content text)";
    $dbhandle->query($query);
    $log.=print_r( $dbhandle->errorInfo(),1);
    $log.=$query  = "create table secrets(id INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT, name VARCHAR(25),content text)";
	$dbhandle->query($query);
    $log.= print_r( $dbhandle->errorInfo(),1);
    file_put_contents('log',$log);
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
    $needcreate=$dbhandle->errorInfo();
    if ($needcreate[0]=='HY000'){
       create();

    }else{


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
    }
    //include_once 'map..html';
//sqlite_exec($dbhandle,$query);
    // sqlite_close($dbhandle);
}


?>