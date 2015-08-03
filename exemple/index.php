<?php 
	
	
	define('ADMIN_URL','sw-admin/');
	include ADMIN_URL.'inc/system.php';
	
	$page = 'hp';
	if (!empty($_GET['page'])) $page = htmlentities($_GET['page']);
	
	$sw = new sw();
	
	$returnmessage = $sw-> getmessage();
	
	$blocks = $sw -> block($page);
	
	$siteinfo = $sw -> block('siteinfos');
	$site_url = $siteinfo['site_url'];

	define('TEMPLATE_URL',$site_url.'/template');
	
	$listnav = [
		'hp' => 'template/hp.php',
		'article' => 'template/post.php',
		'about' => 'template/about.php',
		'contact' => 'template/contact.php',
		'sendmail' => 'template/sendmail.php',
		'addnewsletter' => 'template/addnewsletter.php', 
	];
	
	
	
if (file_exists($listnav[$page])) include ($listnav[$page]);
		

	
	
	
?>
