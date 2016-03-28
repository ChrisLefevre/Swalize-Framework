<?php 
/*
	error_reporting(E_ALL); 
	ini_set('display_errors', 1);
*/	
	
	include '../models.php';
	include 'inc/funcs.php';
	

	
	$smod = new swcnt_smod();
	$adm = new swcnt_sadmin();
	
	$sblog = new swcnt_sblog();	
	$sblog_cat = new swcnt_sblog_cat();
	
	$scatalog = new swcnt_sblog('catalog');	
	$scatalog_cat = new swcnt_sblog_cat('catalog');
	
	$sportfolio = new swcnt_sblog('portfolio');	
	$sportfolio_cat = new swcnt_sblog_cat('portfolio');
	
	$spages = new swcnt_sblog('pages');	
	$spages_cat = new swcnt_sblog_cat('pages');	
	

$adm -> setMylang();	
	
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