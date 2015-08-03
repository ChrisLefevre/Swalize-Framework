 <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
<?php $ul = $adm->userlogged();
	/*
		
		
Toggle navigation
4
10
9
User ImageAlexander Pierce
array(2) { ["mail"]=> string(17) "bleebot@gmail.com" ["user"]=> array(3) { ["pass"]=> string(25) "575b38040f854244021835209" ["username"]=> string(7) "bleebot" ["role"]=> int(2) } }
User Image
Alexander Pierce

*/
	
 ?>
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $ul["avatar"]; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo ucFirst($ul['user']["username"]); ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> <?php echo _("Online"); ?> </a>
            </div>
          </div>

		  <?php 
          /*
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
         */
         ?>
         
         <ul class="sidebar-menu">
	        <li class="header"><?php echo _("EDITION"); ?> </li>
            
           <?php //if (!empty($swcnt_blog)) { } ?> 
           
              
               <?php foreach($swcnt_options['languages'] as $k) {
	               ?>
	                <li class="treeview <?php echo ($sblog-> lang==$k and $smod->mod=='blog') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE0C9;</i> <span>Blog  - <?php echo strtoupper($k); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
	               <li class="<?php echo ($sblog-> lang==$k and $sblog->page=='new') ?  'active' : '';  ?>"> <a href="?blog=new&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE150;</i> <?php echo _("New post"); ?> </a></li>
	               <li class="<?php echo ($sblog-> lang==$k and $sblog->page=='list') ?  'active' : '';  ?>"><a href="?blog=list&lang=<?php echo $k; ?>"><i class="material-icons">&#xE3C7;</i> <?php echo _("All posts"); ?> </a></li>
	               
                            </ul>
            </li>
	               <?php
	               
	               
		          
	            	}
	            
	            
	            
						?>
               
               
               
             
              
              
            
            
            <li class="treeview <?php echo ($smod->mod=='editor') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE051;</i> <span><?php echo _("Editor"); ?> </span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              
              
              <?php
	      
	              
	              
	              $smod -> listpages();
	              
	              
	               ?>
              
              
              
                            </ul>
            </li>
            
             <li class="header"><?php echo _("ADMINISTRATION");  ?> </li>
            <!-- Optionally, you can add icons to the links -->
          
           
           
           
            <li class=" <?php echo ($smod->mod=='users') ?  'active' : '';  ?>">
              <a href="?users=list"><i class="material-icons">&#xE853;</i> <span><?php echo _("Users"); ?> </span> </a>
            </li>
            
            
              <li class=" <?php echo ($smod->mod=='contact') ?  'active' : '';  ?>">
              <a href="?contact=list"><i class="material-icons">&#xE560;</i> <span><?php echo _("Contact Form"); ?> </span> </a>
            </li>
            
                        
              <li class=" <?php echo ($smod->mod=='newsregisters') ?  'active' : '';  ?>">
              <a href="?newsregisters=list"><i class="material-icons">&#xE0BE;</i> <span><?php echo _("Mailing list"); ?> </span> </a>
            </li>
            
            
            
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
