<?php 
/* frontend functions */	
	

if(isset($_GET['contactpusheddatas'])){
	/*  En cas de besoin, on peut sauver les données $sw->saveform('contactform'); */
	
	$contactmail = '';
	if (!empty($sw -> plugin_datas('contact_form','contact_form','')['contactmail'])) 
	$contactmail = $sw -> plugin_datas('contact_form','contact_form','')['contactmail'];
	
	 if($sw->mailform('contactform',$contactmail)) 	$sw-> setmessage($sw->_m('your message has been sent'),'success');
	 else $sw-> setmessage($sw->_m('Your message has not been sent. Please fill in all fields'),'danger');
	
	header('Location: '.$_SERVER['HTTP_REFERER']); 
	exit();

}
	
	
	

function showContactform($btnname="Send")
	{	
		global $swcnt_plugins;
		global $swcnt_options;
		global $swcnt_form;
		global $sw_vars;
		
		
		
		
		$action = SITE_URL.'?contactpusheddatas';
		
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
	
	
	
/* exemple d'un formulaire ecrit directement en HTML, attention de bien adapter les champs du $swcnt_form['contactform'] pour qu'ils correspondent aux champs du formulaire  */ 	

function showCustomContactform()
	{	
	
		
		global $swcnt_plugins;
		global $swcnt_options;
		global $swcnt_form;
		global $sw_vars;
		global $sw;
		
		
		
		$action = SITE_URL.'?contactpusheddatas';
		
		$form = $swcnt_form['contactform'];
		
		echo $sw_vars['returnmessage'];

		
		echo ' <form name="sentMessage" id="contactForm" method="post" action="'.$action.'" novalidate>';
		
		?>
		<div class="form-group input-group">
                   
        <input name="company" class="form-control hspeedform_30" placeholder="<?php echo $sw->_m('company'); ?>" type="text" ><span class="sp-vert"></span>
	 <input name="name" class="form-control hspeedform_30" placeholder="<?php echo $sw->_m('name'); ?>" type="text"><span class="sp-vert"></span>
	 <input name="email" class="form-control hspeedform_30" placeholder="<?php echo $sw->_m('email'); ?>" type="text">
	 
	 </div>
             
	 <textarea rows="8" name="message" placeholder="<?php echo $sw->_m('message'); ?>" class="form-control"></textarea> 
	 
	  <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-default"><i class="fa fa-lg fa-arrow-right pull-right"></i> <?php echo $sw->_m('send'); ?></button>
                        </div>
                    </div>

	 <?php		
			
			echo '</form>';
		
		
		
				
}

	
	
?>