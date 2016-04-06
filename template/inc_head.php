<?php 	?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $siteinfo['baseline']; ?>">
    <meta name="author" content="">

    <title><?php echo $title ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo SITE_URL; ?>template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>template/css/clean-blog.css" rel="stylesheet">
  
    

    <!-- Custom Fonts -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php  echo SITE_URL; ?>"><?php echo $siteinfo['title'] ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
	             <?php
	                     							 foreach($siteinfo['navigation'] as $av) { 
													 if(substr($av['url'],-4,5)==substr($_SERVER['REQUEST_URI'],-4,4)) echo '<li class="active">';
													 else echo '<li>';
													 if (false === strpos($av['url'], '://'))
													 	echo '<a href="'.SITE_URL.$sw -> lang.'/'.$av['url'].'">'.$av['name'].'</a></li>';
													 else  echo '<a href="'.$av['url'].'">'.$av['name'].'</a></li>';
													 
													 }
													
													?>
                     
                                          
                     <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes" aria-expanded="false"><?php echo $sw->lang; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <?php foreach($swcnt_options['languages'] as $l) {
	                     echo '<li><a href="'.SITE_URL.$l.'/">'.$l.'</a></li> ';  
	                     
	                     
                     } ?>
</ul>
            </li>
	                
                                   </ul>
                                              </div>
            <!-- /.navbar-collapse -->
            
                 </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->