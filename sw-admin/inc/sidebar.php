 <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
<?php $ul = $adm->userlogged();
	
	if (!empty($ul['user'])) {
 ?>
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $ul["avatar"]; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo ucFirst($ul['user']["username"]); ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> <?php echo _t("Online"); ?> </a>
            </div>
          </div>

		  <?php 
			  
			  }
              
         ?>
         
         <ul class="sidebar-menu">
	            	         <?php   if ($adm->blogmode==1) { ?>
	         
	     <li class="header"><?php echo _t("PUBLICATION"); ?> </li>

            
           <?php //if (!empty($swcnt_blog)) { } ?> 
           
              
               <?php
	              
	               
	                foreach($swcnt_options['languages'] as $k) {
	               ?>
	                <li class="treeview <?php echo ($sblog-> lang==$k and $smod->mod=='blog') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE0C9;</i> <span>Blog  - <?php echo strtoupper($k); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
	               <li class="<?php echo ($sblog-> lang==$k and $sblog->page=='new') ?  'active' : '';  ?>"> <a href="?blog=new&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE150;</i> <?php echo _tr("New post"); ?> </a></li>
	               <li class="<?php echo ($sblog-> lang==$k and $sblog->page=='list') ?  'active' : '';  ?>"><a href="?blog=list&lang=<?php echo $k; ?>"><i class="material-icons">&#xE3C7;</i> <?php echo _tr("All posts"); ?> </a></li>
	              <li class="<?php echo ($sblog-> lang==$k and $sblog->page=='cats') ?  'active' : '';  ?>"> <a href="?blog=cats&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE2C8;</i> <?php echo _tr("Categories"); ?> </a></li>  
                            </ul>
            </li>
	               <?php
	               
	               		}
	               		
	               		
	               		?>
	               		
	               		
	               		
	               		<?php 
		          
	            	}
	            
	            
	            
	            /* Catalog */  
	            
	 
	             if ($adm->catalogmode==1) { ?>
	         
 <li class="header"><?php echo _t("SHOP"); ?> </li>

            

           
              
               <?php
	              
	               
	                foreach($swcnt_options['languages'] as $k) {
	               ?>
	                <li class="treeview <?php echo ($scatalog-> lang==$k and $smod->mod=='catalog') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE547;</i> <span>Catalog  - <?php echo strtoupper($k); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
	               <li class="<?php echo ($scatalog-> lang==$k and $scatalog->page=='new') ?  'active' : '';  ?>"> <a href="?catalog=new&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE148;</i> <?php echo _tr("New product"); ?> </a></li>
	               <li class="<?php echo ($scatalog-> lang==$k and $scatalog->page=='list') ?  'active' : '';  ?>"><a href="?catalog=list&lang=<?php echo $k; ?>"><i class="material-icons">&#xE8D1;</i> <?php echo _tr("All products"); ?> </a></li>
	              <li class="<?php echo ($scatalog-> lang==$k and $scatalog->page=='cats') ?  'active' : '';  ?>"> <a href="?catalog=cats&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE8D8;</i> <?php echo _tr("Topics"); ?> </a></li>  
                            </ul>
            </li>
	               <?php
	               
	               		}
	               		
	               		
	               		?>
	               		
	               		
	               		
	               		<?php 
		          
	            	}

	    
               
               
          
              
              
                /* Portfolio */ 
	            
	 
	             if ($adm->portfoliomode==1) { ?>
	         
				  <li class="header"><?php echo _tr("STUDIO"); ?> </li>

            

           
              
               <?php
	              
	               
	                foreach($swcnt_options['languages'] as $k) {
	               ?>
	                <li class="treeview <?php echo ($sportfolio-> lang==$k and $smod->mod=='portfolio') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE8F9;</i> <span>Portfolio  - <?php echo strtoupper($k); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
	               <li class="<?php echo ($sportfolio-> lang==$k and $sportfolio->page=='new') ?  'active' : '';  ?>"> <a href="?portfolio=new&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE3F4;</i> <?php echo _tr("New project"); ?> </a></li>
	               <li class="<?php echo ($sportfolio-> lang==$k and $sportfolio->page=='list') ?  'active' : '';  ?>"><a href="?portfolio=list&lang=<?php echo $k; ?>"><i class="material-icons">&#xE3B6;</i> <?php echo _tr("All projects"); ?> </a></li>
	              <li class="<?php echo ($sportfolio-> lang==$k and $sportfolio->page=='cats') ?  'active' : '';  ?>"> <a href="?portfolio=cats&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE8A7;</i> <?php echo _tr("Groups"); ?> </a></li>  
                            </ul>
            </li>
	               <?php
	               
	               		}
	               		
	               		
	               		?>
	               		
	               		
	               		
	               		<?php 
		          
	            	}








     
                /* Page */ 
	            
	 
	             if ($adm->pagemode==1) { ?>
	         
				  <li class="header"><?php echo _tr("PAGES"); ?> </li>

            

           
              
               <?php
	           
	               
	                foreach($swcnt_options['languages'] as $k) {
	               ?>
	                <li class="treeview <?php echo ($spages-> lang==$k and $smod->mod=='pages') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE873;</i> <span>Pages  - <?php echo strtoupper($k); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
	               <li class="<?php echo ($spages-> lang==$k and $spages->page=='new') ?  'active' : '';  ?>"> <a href="?pages=new&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE89C;</i> <?php echo _tr("New page"); ?> </a></li>
	               <li class="<?php echo ($spages-> lang==$k and $spages->page=='list') ?  'active' : '';  ?>"><a href="?pages=list&lang=<?php echo $k; ?>"><i class="material-icons">&#xE02F;</i> <?php echo _tr("All pages"); ?> </a></li>
	              <li class="<?php echo ($spages-> lang==$k and $spages->page=='cats') ?  'active' : '';  ?>"> <a href="?pages=cats&lang=<?php echo $k; ?>" ><i class="material-icons">&#xE8F1;</i> <?php echo _tr("Templates"); ?> </a></li>  
                            </ul>
            </li>
	               <?php
	               
	               		}
	               		
	               		
	               		?>
	               		
	               		
	               		
	               		<?php 
		          
	            	}

	            ?>
              


              
              
              
                  <li class="header"><?php echo _tr("EDITION"); ?> </li>
              
              
              
              
              
              
            
            
            <li class="treeview <?php echo ($smod->mod=='editor') ?  'active' : '';  ?>">
              <a href="#"><i class="material-icons">&#xE051;</i> <span><?php echo _tr("Editor"); ?> </span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
              
              
              <?php
	      
	              
	              
	              $smod -> listpages();
	              
	              
	               ?>
              
              
              
                            </ul>
            </li>




<?php 
	
	 $smod -> listplugins();
	
	
	?>   
	
	         
            
         
            
            
            
             <li class="header"><?php echo _tr("ADMINISTRATION");  ?> </li>
            <!-- Optionally, you can add icons to the links -->
          
           
           
           
            <li class=" <?php echo ($smod->mod=='users') ?  'active' : '';  ?>">
              <a href="?users=list"><i class="material-icons">&#xE853;</i> <span><?php echo _tr("Users"); ?> </span> </a>
            </li>
            
            
            
                 
                 <li class=" <?php echo ($smod->mod=='translate') ?  'active' : '';  ?>">
              <a href="?translate=home"><i class="material-icons">&#xE894;</i><span><?php echo _tr("Translate"); ?> </span> </a>
            </li>
            

                      
            
            
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>
