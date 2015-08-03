<?php 
	
	
	 $sw->saveform('contact');
	 if($sw->mailform('contact')) {
				 
				$sw-> setmessage('your message has been sent');
		 
		 
	 }	 

$ref = $_SERVER['HTTP_REFERER']; 
header("Location: ".$ref);
exit();

?>