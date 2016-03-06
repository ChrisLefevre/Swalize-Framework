<?php 
	

	
	if ($scatalog->page=='new' or $scatalog->page=='edit') { 
			$scatalog -> save();
	?>
<section class="content-header">
    <h1>Catalog <?php echo $scatalog -> lang; ?><small><?php echo _("Add a new product"); ?></small></h1>

    <ol class="breadcrumb">
        <li>
            <a href="./"><?php echo _("Edition"); ?> </a>
        </li>

        <li class="active"><?php echo _("Product"); ?> </li>
    </ol>
</section>

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php    $scatalog -> showform(); ?>
        </div>
    </div>
</section>
<?php } else if ($scatalog->page=='cats' ) { 
	$scatalog_cat -> save();
	?>
	

<section class="content">
    <div class='box box-primary'>
       

        <div class='box-body'>
            <?php  $scatalog_cat  -> showform(); ?>
        </div>
    </div>
</section>
	
	
	
	
	
	
	
<?php	}else { 
		
		$catalogproducts = $adm ->  loadDatastore('catalogposts_'.$scatalog -> lang);  // getConfig('catalogproducts');
		
		krsort($catalogproducts);
		 
			
?>



<section class="content-header">
   
    
    
    <div class="pull-right"><a href="?catalog=new&amp;lang=<?php echo $scatalog -> lang; ?>" title="Add" class="btn  btn-sm bg-aqua color-palette"><i class="fa fa-plus"></i> <?php echo _("Add a new product"); ?> </a></div>
     <h1>Catalog <small><?php echo _("products list"); ?>  <?php echo $scatalog -> lang; ?></small></h1>

    
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
                    
                    <?php foreach($catalogproducts as $k => $v) { 
	                    
	                    if($v['status']!=2) {
	               
	                    if($v['status']==1) $stat = _('visible'); 
	                    else if($v['status']==3) $stat = _('showcase'); 
	                    else $stat = _('closed'); 
	            
	                    
	                     ?>
	                    
	                    
	                 <tr>
                     
                      <td><?php echo $v['dateupdate']; ?></td>
                      <td><a href="?catalog=edit&lang=<?php echo $v['lang']; ?>&post=<?php echo $k; ?>"><?php echo ucwords($v['title']); ?> - <?php echo ucwords($stat); ?></a></td>
                      <td></td>
                    <td>
	                </td>  </tr>
    
                    <?php } } ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
    
    
    
    
    
</section>



<?php }