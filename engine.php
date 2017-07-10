<?php
/**
 * Created by PhpStorm.
 * User: d.barsuk
 * Date: 29.05.2017
 * Time: 10:36
 */
const DB = 'sqlite:dbs/real.db';
function add($subject, $x)
{
    if (!empty($_COOKIE['author'])) {
        $author = $_COOKIE['author'];

    } else {
        $author = md5(time() . "i_am");
        setcookie("author", $author, strtotime("+ 3 week"));
    }
    $ip = getenv('HTTP_CLIENT_IP') ?:
        getenv('HTTP_X_FORWARDED_FOR') ?:
            getenv('HTTP_X_FORWARDED') ?:
                getenv('HTTP_FORWARDED_FOR') ?:
                    getenv('HTTP_FORWARDED') ?:
                        getenv('REMOTE_ADDR');
    $mkt = time();
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query = "insert into  {$subject}(`name`,`content`,`author`,`date`,`ip`) values('" . $x[0] . "','" . $x[1] . "','{$author}','{$mkt}','{$ip}')";
    $dbhandle->query($query);
    print_r($dbhandle->errorInfo());

}

function find($from, $what)
{
    $dbhandle = new PDO(DB);
    $q = "SELECT name,content FROM $from where name like '%{$what}%' OR content like '%{$what}%'  ORDER BY name asc";

    $answ = $dbhandle->query($q);

    $result = $answ->fetchAll();
    $generate = "<h4 style='    color: #07c8d2;
    text-decoration: underline;    
    text-transform: uppercase;
    text-align: center;'>Результати пошуку '$what'</h4>";
    if (!count($result)) {
        $generate .= '<h3>Нічого не знайдено</h3>';
        return $generate;
    }
    foreach ($result as $key) {
        $generate .= "<h3>{$key['name']}</h3><p style='font-size:10px;'>{$key['content']}</p>";

    }
    return $generate;
}


function create()
{
    $log = '';
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $log .= $query = "CREATE TABLE problems(id INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT, name VARCHAR(25),content TEXT,author VARCHAR (20), date INTEGER ,ip VARCHAR(15) )";
    $dbhandle->query($query);
    $log .= print_r($dbhandle->errorInfo(), 1);
    $log .= $query = "CREATE TABLE secrets(id INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT, name VARCHAR(25),content TEXT, author VARCHAR (20), date INTEGER ,ip VARCHAR(15) )";
    $dbhandle->query($query);
    $log .= print_r($dbhandle->errorInfo(), 1);
    file_put_contents('log', $log);
//sqlite_exec($dbhandle,$query);
    // sqlite_close($dbhandle);
}

$problems = '';
$issues = '';

function show($limit = true)
{
    global $problems, $issues;
    $qlimit = $limit ? 'limit 0,5' : '';
    $dbhandle = new PDO(DB);// sqlite_open('mysqlitedb', 0666, $sqliteerror);
    $query = "select id,name,content,author,date from problems ORDER  by id desc $qlimit ";
    $x = $dbhandle->query($query);
    $needcreate = $dbhandle->errorInfo();
    if ($needcreate[0] == 'HY000') {
        create();

    } else {
        setlocale(LC_TIME, 'pl_PL');

        $result = $x->fetchAll();
        $generate = '';
        $edited = '';
        foreach ($result as $key) {
            if ($key['author'] == $_COOKIE['author']) {
                $edited = ' You can Edit.';
            } else {
                $edited = '';
            }
            $d = ($key[date])?date_create("@" . $key['date'])->format("d F Y H:i:s "):"deprecated";
            $generate .= "<h3 data-id='{$key['id']}'>{$key['name']}{$edited}</h3><span class='date'>{$d}</span><p class='post'>{$key['content']} </p>";
        }
        $problems = $generate;
        $query = "select id,name,content,author,date from secrets ORDER  by id desc $qlimit";
        $x = $dbhandle->query($query);
        //print_r( $dbhandle->errorInfo());
        $result = $x->fetchAll();
        $generate = '';
        foreach ($result as $key) {
            $d = ($key[date])?date_create("@" . $key['date'])->format("d F Y H:i:s "):"deprecated";
            $generate .= "<h3 data-id='{$key['id']}'>{$key['name']}</h3> <span class='date'>{$d}</span><p class='post'>{$key['content']}</p>";
        }
        $issues = $generate;
    }
    //include_once 'map..html';
//sqlite_exec($dbhandle,$query);
    // sqlite_close($dbhandle);
}

function edit($id,$author,$section,$content,$name)
{
    $dbhandle = new PDO(DB);
    $q="UPDATE $section  SET `name`='{$name}',`content`={$content} WHERE `id`='{$id}' and `author`='{$author}'";
    $dbhandle->query($q);
    print_r($dbhandle->errorInfo());

}

function detect()
{


    require_once 'libs/mbdetect/Mobile_Detect.php';
    $detect = new Mobile_Detect;

// Any mobile device (phones or tablets).
    if ($detect->isMobile()) {
        return true;
    }

// Any tablet device.
    if ($detect->isTablet()) {
        return true;
    }

// Exclude tablets.
    if ($detect->isMobile() && !$detect->isTablet()) {

    }

// Check for a specific platform with the help of the magic methods:
    if ($detect->isiOS()) {

    }

    if ($detect->isAndroidOS()) {

    }

// Alternative method is() for checking specific properties.
// WARNING: this method is in BETA, some keyword properties will change in the future.
    echo $detect->is('Chrome');
    echo $detect->is('iOS');
    echo $detect->is('UC Browser');
// [...]

// Batch mode using setUserAgent():
    $userAgents = array(
        'Mozilla/5.0 (Linux; Android 4.0.4; Desire HD Build/IMM76D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19',
        'BlackBerry7100i/4.1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/103',
// [...]
    );
    foreach ($userAgents as $userAgent) {

        $detect->setUserAgent($userAgent);
        $isMobile = $detect->isMobile();
        $isTablet = $detect->isTablet();
        // Use the force however you want.

    }

// Get the version() of components.
// WARNING: this method is in BETA, some keyword properties will change in the future.
    $detect->version('iPad'); // 4.3 (float)
    $detect->version('iPhone'); // 3.1 (float)
    $detect->version('Android'); // 2.1 (float)
    $detect->version('Opera Mini'); // 5.0 (float)
}


?>