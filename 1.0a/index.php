<?php header('Content-Type: text/html; charset=utf-8');
/* paramettrer site */
$sitelang = 'fr';

define('ADMIN_URL', 'sw-admin/');
include ADMIN_URL.'inc/system.php';



$listnav = [
		'hp' => 'template/hp.php',
		'article' => 'template/post.php',
		'about' => 'template/about.php',
		'contact' => 'template/contact.php',
		'tag' => 'template/tag.php',
		'cat' => 'template/cat.php',
	];


if (file_exists($listnav[$page])) include ($listnav[$page]);
		

?>
    
    
    
    


     