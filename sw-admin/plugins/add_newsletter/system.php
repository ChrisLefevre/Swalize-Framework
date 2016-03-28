<?php 
/* frontend functions */	
	

if(isset($_GET['addnewsletterpusheddatas'])){


	


$sw -> saveform('add_newsletter');


//	$sw->saveData('add_newsletter', date("Y-m-d H:i:s"), array('email'=>htmlspecialchars($_POST['email'])));
	echo $sw->_('Sent');
	exit();



}
	
	
		
	
?>