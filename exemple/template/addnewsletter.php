<?php 
	


if($sw->saveform('newslettermail')) {
				 
				$sw-> setmessage('your email is registred');
		 
		 
	 }	

	 
$ref = $_SERVER['HTTP_REFERER']; 
header("Location: ".$ref);
exit();

?>