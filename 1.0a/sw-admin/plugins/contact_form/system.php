<?php 
/* frontend functions */	
	

if(isset($_GET['contactpusheddatas'])){
	/*  En cas de besoin, on peut sauver les données $sw->saveform('contactform'); */
	
	$contactmail = '';
	if (!empty($sw -> plugin_datas('contact_form','contact_form','')['contactmail'])) 
	$contactmail = $sw -> plugin_datas('contact_form','contact_form','')['contactmail'];
	
	 if($sw->mailform('contactform',$contactmail)) {
				//$sw-> setmessage('your message has been sent');
				echo '<p class="alert alert-success alert-dismissible">'.$sw->_('your message has been sent').'</p>';
				
	 }	else echo '<p class="alert alert-warning alert-dismissible">'.$sw->_('Your message has not been sent. Please fill in all fields').'</p>'; 
		exit();

}
	
	
	

function showContactform($btnname="Send")
	{	
		global $swcnt_plugins;
		global $swcnt_options;
		global $swcnt_form;
		global $sw_vars;
		
		
		
		
		$action = $sw_vars['site_url'].'?contactpusheddatas';
		
		$form = $swcnt_form['contactform'];
		
		echo $sw_vars['returnmessage'];

		
		echo ' <form name="sentMessage" id="contactForm" method="post" action="'.$action.'" novalidate>';
		
		foreach ($form as $k => $v ) {
			echo ' <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label>'.$v['label'].'</label>';
                            
                            
                            if(!empty($v['required'])) $req = 'required data-validation-required-message="'.$v['required'].'"'; else $req =''; 
                            
                       if($v['type']== 'input_txt')   echo ' <input type="text" name="'.$k.'"  class="form-control" placeholder="'.$v['label'].'" id="inp_'.$k.'" '.$req.' />  ';
                            
                            
                              if($v['type']== 'textarea')   echo ' <textarea rows="5" name="'.$k.'"  class="form-control" placeholder="'.$v['label'].'" id="inp_'.$k.'" '.$req.'></textarea>';

                            
                            echo '<p class="help-block text-danger"></p>
                        </div>
                    </div>
                    ';
			
			}
			
			echo '                  <br>
                    <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default">'.$btnname.'</button>
                        </div>
                    </div>
                </form>';
		
		
		
				
}
	


	
	
?>