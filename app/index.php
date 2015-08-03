<?php
		
	include 'controls/config.php';
	include 'controls/models.php';
	include 'inc/funcs.php';
	
	
	

	
	






/* 
	$_SESSION['language']=$lang;
	setcookie("language", $lang, time()+(3600*60*300), "/");

	
	*/








	
	
	
	$smod = new swcnt_smod();
	$adm = new swcnt_sadmin();
	$sblog = new swcnt_sblog();	
	


$adm -> setMylang();	
	

//if ($_POST) 

	
if(!$adm->islogged()) {
	
	
	
	$adm->login();
	include 'inc/tmp_login.php';
	
	
}
else
	{
		if(!empty($smod->mod) and $smod->mod=='update') include('inc/update.php');
		else if(!empty($smod->mod) and $smod->mod=='uploader') include('inc/uploader.php');
		else {
		
		
		include 'inc/header.php';
		if(!empty($smod->mod)) include('pages/'.$smod->mod.'.php');
	 
		 include 'inc/footer.php';
		 	}
		 }
	

?>