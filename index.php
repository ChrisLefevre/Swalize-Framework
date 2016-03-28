<?php header('Content-Type: text/html; charset=utf-8');
if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
    exit;
}
	
	
/* paramettrer site */
$sitelang = 'fr';

define('ADMIN_URL', 'sw-admin/');
include ADMIN_URL.'inc/system.php';



$listnav = [
		'hp' => 'template/hp.php',
		'article' => 'template/post.php',
		'about' => 'template/about.php',
		'contact' => 'template/contact.php',
		'blog' => 'template/blog.php',
		'tag' => 'template/tag.php',
		'cat' => 'template/cat.php',
			'sendmail' => 'template/sendmail.php',
	];


if (file_exists($listnav[$page])) include ($listnav[$page]);
		

?>
    
    
    
    


     