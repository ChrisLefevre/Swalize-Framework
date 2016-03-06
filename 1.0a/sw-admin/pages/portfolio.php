<?php 
	

	
	if ($sportfolio->page=='new' or $sportfolio->page=='edit') { 
			$sportfolio -> save();
	?>
<section class="content-header">
    <h1>Portfolio <?php echo $sportfolio -> lang; ?><small><?php echo _("Add a new item"); ?></small></h1>

    <ol class="breadcrumb">
        <li>
            <a href="./"><?php echo _("Edition"); ?> </a>
        </li>

        <li class="active"><?php echo _("Items"); ?> </li>
    </ol>
</section>

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php    $sportfolio -> showform(); ?>
        </div>
    </div>
</section>
<?php } else if ($sportfolio->page=='cats' ) { 
	$sportfolio_cat -> save();
	?>
	

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php  $sportfolio_cat  -> showform(); ?>
        </div>
    </div>
</section>
	
	
	
	
	
	
	
<?php	}else { 
		
		$portfolioproducts = $adm ->  loadDatastore('portfolioposts_'.$sportfolio -> lang);  
		
		krsort($portfolioproducts);
		 
			
?>



<section class="content-header">
   
    
    
    <div class="pull-right"><a href="?portfolio=new&amp;lang=<?php echo $sportfolio -> lang; ?>" title="Add" class="btn  btn-sm bg-aqua color-palette"><i class="fa fa-plus"></i> <?php echo _("Add a new project"); ?> </a></div>
     <h1>Portfolio <small><?php echo _("projects list"); ?>  <?php echo $sportfolio -> lang; ?></small></h1>

    
</section><!-- Main content -->

<section class="content">

 
    
     <div class="box">
          
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                     
                      <th><?php echo _("Date"); ?> </th>
                      <th><?php echo _("Product"); ?> </th>
                      <th></th>
              
                    </tr>
                    
                    <?php foreach($portfolioproducts as $k => $v) { 
	                    
	                    if($v['status']!=2) {
	               
	                    if($v['status']==1) $stat = _('visible'); else $stat = _('closed'); 
	                    
	                     ?>
	                    
	                    
	                 <tr>
                     
                      <td><?php echo $v['dateupdate']; ?></td>
                      <td><a href="?portfolio=edit&lang=<?php echo $v['lang']; ?>&post=<?php echo $k; ?>"><?php echo ucwords($v['title']); ?> - <?php echo ucwords($stat); ?></a></td>
                      <td></td>
                    <td>
	                </td>  </tr>
    
                    <?php } } ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
    
    
    
    
    
</section>



<?php }