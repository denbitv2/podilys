<?php 
 include 'engine.php';

$tpl=detect()?'tplmbl.html':'tpl.html';
$action=$_GET['action'];
switch ($action){
    case 'find':
	show();
	
	$where=$_GET['where'];; $what=$_GET['what'];;
	if($where=='secrets'){
		$issues=find($where,$what);
	} elseif($where=='problems'){
		$problems=find($where,$what);
	}
	
	break;
	case 'all':
        show(0);
        break;
    case 'add':
        $x[0]=$_POST['topic'];
        $x[1]=$_POST['content'];

        if(!empty($x[0])&&!empty($x[1])&&(($_POST['subject']=='secrets')||($_POST['subject']=='problems'))){

            add($_POST['subject'],$x);
        }
        show();
        break;
	
    default:
       $edit_rec= $_SERVER['REQUEST_URI'];
       $edit_rec=ltrim($edit_rec,"/");
       $edit=explode("/",$edit_rec);
        if ($edit[0] == "edit") {
            edit(substr($edit[1],1),$_COOKIE[author],substr($edit[1],0,1)=="s"?"secrets":"problems",$_POST['content'],$_POST['name']);

            show();
        } else {
            show();
        }


}
log_visits();

include_once $tpl;

?>