<?php 


$id = htmlentities($_GET['id']);
$bpost = $sw->blogpost($id) ; 



if (!empty($bpost)) {

$title = $bpost['title'].' - '.$siteinfo['title'];

include 'template/inc_head.php';




//print_r($bpost);
?>

    <!-- Page Header -->
    <!-- Set your background image for this header on the line below. -->
    <header class="intro-header" style="background-image: url('<?php if(!empty($bpost['cover'])) echo SITE_URL . ADMIN_URL.'upload/full/'.$bpost['cover'];  else echo TEMPLATE_URL.'/img/post-bg.jpg'; ?>')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1><?php echo $bpost['title']; ?></h1>
                        <h2 class="subheading"><?php echo $bpost['headline'];  ?></h2>
                        <span class="meta"><?php echo $sw->_("Posted by"); ?>  <?php echo ucFirst($bpost['author']); ?> <?php echo $sw->_("on"); ?> <?php echo  $sw->dateTime($bpost['pubdate']); ?> | <a href="<?php echo SITE_URL.$sw->uri('cat',$bpost['category']); ?>" class="catlink catlink_c<?php echo $bpost['category']; ?>"><?php echo $bpost['categoryName']; ?></a> </span>
                        
                        
                                               
                        
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 body_text">
                   
                   <?php echo $bpost['article']; ?>
                   
                   
                   
                   <div class="tags pull-left">
									 <i class="fa fa-tags"></i> <?php 
			$tags = explode(',',$bpost['keyword']);
			$i = 0;
			foreach($tags as $gt) {
			if($i > 0)	echo ', '; $i ++;
			echo ' <a href="'.SITE_URL.$sw->uri('tag',$sw->format_url($gt)).'">'.$gt.'</a>';
				
			}
														
								?></div>

                   
                                   </div>
            </div>
        </div>
    </article>

    <hr>

   <?php include 'template/inc_foot.php'; } ?>