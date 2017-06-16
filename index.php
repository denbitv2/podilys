<?php include 'engine.php';
//var_dump($_GET); die;

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
	
    default:show();
}


include_once 'tpl.html';

?>