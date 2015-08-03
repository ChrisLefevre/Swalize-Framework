<?php 
	
	$swcnt_options = [
		
		/* liste des langues  */
		'languages' => ['fr','en','de'],
		
		/* Clé de sécurité, doit être modifiée */
		'secure_key' => '4784yhqs%$',  
		
		/* true si url_rewiting */
		'urlrewriting' => true,
		
		/* your email */
		'contact_email' => 'website@yoursite.com'
		
		
	];
	

		/* liste et structure des blogs   */
	
	
	$swcnt_blog = array(
		
			'sw_title' => 'Blog',
			'sw_blocks' => array(
		
				'title' => array(
				'label' => _('Title'),
				'type' => 'input_txt',
				'placeholder' => '',
				
				),
				'headline' => array(
				'label' => _('Headline'),
				'type' => 'input_txt',
				'placeholder' => '',
				
				),
				
				'author' => array(
				'label' => _('Author'),
				'type' => 'user',
				'placeholder' => '',	
				),
				
				'article' => array(
				'label' => _('Post'),
				'type' => 'htmlarea',
				'placeholder' => '',	
				),
				
				
				'pubdate' => array(
				'label' => _('Published date'),
				'type' => 'datetime',
				'placeholder' => '',
				'default' => date("Y-m-d H:i:s"),
				'sidebar' => true
				
				),
				'preview' => array(
				'label' => _('Illustration'),
				'type' => 'picture',
				'placeholder' => '',
				'sidebar' => true
				
				),
			
			
			)
		);
	
		/* Formulaires pour le site  */
	
		$swcnt_form['contact'] = array(
	
				'name' => array(
				'label' => _('Name'),
				'type' => 'input_txt',
				'required'  => _('Please enter your name.')
				),
				
				'email' => array(
				'label' => _('Email Adress'),
				'type' => 'input_txt',
				'required'  => _('Please enter your email address.')
				),
				
				'phone' => array(
				'label' => _('Phone Number'),
				'type' => 'input_txt',
				'required'  => false
				),
				
				'message' => array(
				'label' => _('Message'),
				'type' => 'textarea',
				'required'  => _('Please enter a message.')
				),
	
				
	
	
		);


	$swcnt_form['newslettermail'] = array(
	
				'name' => array(
				'label' => _('Name'),
				'type' => 'input_txt',
				'required'  => _('Please enter your name.')
				),
				
				'email' => array(
				'label' => _('Email Adress'),
				'type' => 'input_txt',
				'required'  => _('Please enter your email address.')
				)

	
		);

	
		/* liste des pages et blocks  */
	
	
	
	
	
	
	$swcnt_tree['siteinfos'] = array(
		
			'sw_title' => _('Site infos'),
			'sw_blocks' => array(
		
				'title' => array(
				'label' => _('Site title'),
				'type' => 'input_txt',
				'placeholder' => 'Mon site'
				
				),
				'baseline' => array(
				'label' => _('Site baseline'),
				'type' => 'input_txt',
				'placeholder' => 'Un site cool pour tout le monde'
				
				),
				
				'site_url' => array(
				'label' => _('Site URL'),
				'type' => 'input_txt',
				'placeholder' => 'http://mysite.com'
				
				),

				
				'navigation' => array(
				'label' => 'Navigation',
				'type' => 'list',
				'placeholder' => '',
				'submenu' => array(
							'name' => array( 
												'label' => _('Page name'),
												'type' => 'input_txt',
												'placeholder' => 'Mon page'
							),
							'url' => array( 
												'label' => _('URL'),
												'type' => 'input_txt',
												'placeholder' => 'http://monsite.com/mapage'
							)
					
						)				
				),
				 
				
				
				'twitter' => array(
				'label' => 'Profil twitter',
				'type' => 'input_txt',
				'placeholder' => 'http://twitter.com/swalize'
				
				),	
				
				'facebook' => array(
				'label' => 'Profil facebook',
				'type' => 'input_txt',
				'placeholder' => 'http://facebook.com/swalize'
				
				),				
				
				
				
							
			)
		);
	
	
	
	
	$swcnt_tree['hp'] = array(
		
			'sw_title' => _('Home Page'),
			'sw_blocks' => array(
		
				'title' => array(
				'label' => _('Title'),
				'type' => 'input_txt',
				'placeholder' => ''
				
				),
				'text' => array(
				'label' => _('About'),
				'type' => 'textarea',
				'placeholder' => ''
				
				),
				
				
				'preview' => array(
				'label' => _('Illustration'),
				'type' => 'picture',
				'placeholder' => '',
				'sidebar' => true
				),
			
				'article' => array(
				'label' => _('Body'),
				'type' => 'htmlarea',
				'placeholder' => ''
				
				),
			
			)
		);
		
		
		
		$swcnt_tree['contact'] = array(
		
			'sw_title' => _('Contact Form'),
			'sw_blocks' => array(
		
			'title' => array(
				'label' => _('Title'),
				'type' => 'input_txt',
				'placeholder' => ''
				),
				'headline' => array(
				'label' => _('Headline'),
				'type' => 'input_txt',
				'placeholder' => '',
				
				),

			
				'article' => array(
				'label' => _('Body'),
				'type' => 'htmlarea',
				'placeholder' => ''
				
				),

			
			)
		);		
		
		
	$swcnt_tree['about'] = array(
		
			'sw_title' => _('About'),
			'sw_blocks' => array(
		
				'title' => array(
				'label' => _('Title'),
				'type' => 'input_txt',
				'placeholder' => ''
				),
				'headline' => array(
				'label' => _('Headline'),
				'type' => 'input_txt',
				'placeholder' => '',
				
				),

			
				'article' => array(
				'label' => _('Body'),
				'type' => 'htmlarea',
				'placeholder' => ''
				
				),
			
			)
		);	
	
	
	?>