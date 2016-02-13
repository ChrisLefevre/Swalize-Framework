<?php
$swcnt_form = array();
$swcnt_plugins = array();
$swcnt_options = array(
	/* liste des langues  */
	'languages' => array(
		'fr',
		'en'

	) ,
	'languages_names' => array(
		'fr' => "Français",
		'en' => "English",
		'nl' => "Nederlands",
		'de' => "Deutsch"
	) ,
	/* Clé de sécurité, doit être modifiée */
	'secure_key' => '22voilalademo',
	/* true si url_rewiting */
	'urlrewriting' => true,
	/* your email */
	'contact_email' => '',
	/* complex crypt mode  1 or 0 */
	'crypt' => 0,
	
	/* 1 pour activer les fonctions de blogging (catalog ou portfolio) */
	'blog' => 1,
	'catalog' => 0,
	'portfolio' => 0
);
$swcnt_plugins = array(

	//'add_newsletter',
	'contact_form',
);
/* liste et structure des blogs   */
$swcnt_blog = array(
	'sw_title' => 'Blog',
	'sw_cat_title' => 'Categories',
	
	'sw_blocks' => array(
		'title' => array(
			'label' => _('Title') ,
			'type' => 'input_txt',
			'placeholder' => '',
		) ,
		'headline' => array(
			'label' => _('Headline') ,
			'type' => 'input_txt',
			'placeholder' => '',
		) ,
		'author' => array(
			'label' => _('Author') ,
			'type' => 'user',
			'placeholder' => '',
		) ,
		'article' => array(
			'label' => _('Post') ,
			'type' => 'htmlarea',
			'placeholder' => '',
		) ,
		'keyword' => array(
			'label' => _('Keywords') ,
			'type' => 'tags',
			'placeholder' => '',
		) ,
		'pubdate' => array(
			'label' => _('Published date') ,
			'type' => 'datetime',
			'placeholder' => '',
			'default' => date("Y-m-d H:i:s") ,
			'sidebar' => true
		) ,

		'cover' => array(
			'label' => _('Cover') ,
			'type' => 'picture',
			'placeholder' => '',
			'sidebar' => true
		) ,


		'status' => array(
			'label' => _('Status') ,
			'type' => 'select',
			'placeholder' => '',
			'options' => array(
				1 => _('Published') ,
				0 => _('Draft') ,
				2 => _('Deleted') ,
			) ,
			'sidebar' => true
		) ,
		'category' => array(
			'label' => _('Category') ,
			'type' => 'select',
			'placeholder' => '',
			'options' => array(
				'' => _('None') ,
			) ,
			'sidebar' => true
		) ,
		'gallery' => array(
			'label' => _('Photo Gallery') ,
			'type' => 'list',
			'placeholder' => '',
			'submenu' => array(
				'photo' => array(
					'label' => _('photo') ,
					'type' => 'picture',
					'placeholder' => ''
				)
			)
		) ,


		
		
	)
);




$swcnt_portfolio = array(
	'sw_title' => 'Portfolio',
	'sw_cat_title' => 'Groups',
	'sw_blocks' => array(
		'title' => array(
			'label' => 'Project' ,
			'type' => 'input_txt',
			'placeholder' => '',
		) ,

	
		'illustration' => array(
			'label' => _('Illustration') ,
			'type' => 'picture',
			'placeholder' => ''
		) ,
		
			'category' => array(
			'label' => 'Group'  ,
			'type' => 'select',
			'placeholder' => '',
			'options' => array(
				'' => _('None') ,
			) ,
			'sidebar' => true
		) ,

	)
);


/* liste et structure des catalogues   */
$swcnt_catalog = array(
	'sw_title' => 'Catalog',
	'sw_cat_title' => 'Topics',
	'sw_blocks' => array(
		'title' => array(
			'label' => 'Product Name' ,
			'type' => 'input_txt',
			'placeholder' => '',
		) ,

		'gallery' => array(
			'label' => _('Photo Gallery') ,
			'type' => 'list',
			'placeholder' => '',
			'submenu' => array(
				'photo' => array(
					'label' => _('photo') ,
					'type' => 'picture',
					'placeholder' => ''
				)
			)
		) ,



		'description' => array(
			'label' => 'Description' ,
			'type' => 'htmlarea',
			'placeholder' => '',
		) ,


		'status' => array(
			'label' => _('Status') ,
			'type' => 'select',
			'placeholder' => '',
			'options' => array(
				1 => _('Published') ,
				0 => _('Draft') ,
				2 => _('Deleted') ,
			) ,
			'sidebar' => true
		) ,
		'category' => array(
			'label' => 'Type de produit'  ,
			'type' => 'select',
			'placeholder' => '',
			'options' => array(
				'' => _('None') ,
			) ,
			'sidebar' => true
		) ,













	)
);




/* Formulaires pour le site et admin  */
$swcnt_form[] = array();

$swcnt_form['add_newsletter'] = array(

	'email' => array(
		'label' => 'Email',
		'type' => 'input_txt',
		'required'  => 'Please enter your name.'
	)

);



$swcnt_form['contactform'] = array(

	'firstname' => array(
		'label' => 'Firstname',
		'type' => 'input_txt',
		'required'  => 'Please enter your name.'
	),

	'lastname' => array(
		'label' => 'Lastname',
		'type' => 'input_txt',
		'required'  => 'Please enter your name.'
	),

	'email' => array(
		'label' => 'Email Adress',
		'type' => 'input_txt',
		'required'  => 'Please enter your email address.'
	),
	'message' => array(
		'label' => 'Message',
		'type' => 'textarea',
		'required'  => 'Please enter your message.'
	)

);








/* liste des pages et blocks  */





$swcnt_tree['siteinfos'] = array(
		
			'sw_title' => 'site infos',
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
				
			'hp_text' => array(
			'label' => 'HP Text' ,
			'type' => 'htmlarea',
			'placeholder' => '',
			) ,

				
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
												'placeholder' => 'mapage'
							)
					
						)				
				),
				 
				 'cover' => array(
			'label' => _('Cover') ,
			'type' => 'picture',
			'placeholder' => '',
			'sidebar' => false
		) ,
				
				
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
				
				'github' => array(
				'label' => 'Page Github',
				'type' => 'input_txt',
				'placeholder' => 'https://github.com/ChrisLefevre/Swalize-Framework'
				
				),							
				
							
			)
		);
	
	
	



?>
