 </div>
 
 <div id="demoLightbox" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
	<div class='lightbox-content'>
		<img src="image.png">
		<div class="lightbox-caption"><p>Your caption here</p></div>
	</div>
</div>
 
	 <footer class="main-footer">
	 <div class="pull-right hidden-xs">
          Create by <a target="_blank" href="http://twitter.com/chrislefevre">Christophe Lefevre</a> with <i class="fa fa-heart text-red"></i>  
        </div>

        <strong>Copyright &copy; <?php echo date("Y"); ?> <a target="_blank" href="http://swalize.com">Swalize</a>.</strong> All rights reserved.
      </footer>
     </div>
	<script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/plugins/summernote-master/dist/summernote.js"></script>
    <script type="text/javascript" src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/plugins/external/jquery.hotkeys.js"></script>
    <script type="text/javascript" src="assets/plugins/lightbox/ekko-lightbox.min.js"></script>
    
    <script src="assets/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
    <script src="assets/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
    <script src="assets/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
    <script src="assets/plugins/rowsorter/jquery.rowsorter.js" type="text/javascript"></script>
     <script src="assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(function () {

        $("[data-mask]").inputmask();
        
        
        $( ".dtable > tbody > tr:last-child" ).each(function(index, value) { 
	    var temptableelem = $(this);
        $(this).remove();   
	    $("#addelemdtable").click(function(index, value) { 
		      $( ".dtable > tbody").append(temptableelem); 
		      $(this).remove(); 
		      
		   }); 
	        
	        });
            
        
        });
        
        
     </script>   
     
     
     <script type="text/javascript">


	  




	$(".dtable").rowSorter({
		handler: "td.movable",
		onDrop: function(tbody, row, index, oldIndex) {
			$(tbody).parent().find("tfoot > tr > td").html((oldIndex + 1) + ". row moved to " + (index + 1));
			
			
			$(tbody).find('tr td.movable input').each(function(index, value) { 
				$(this).val(index); 
			
			});	
		}
	});

	
</script>
        
    
    
    <script type="text/javascript">
      $(function () {
        $("#datatable").dataTable();
              });
    </script>
    
    <script src="assets/dist/js/app.js" type="text/javascript"></script>  
</body>
</html>