<?php

require_once 'controls/modules.php';



require_once 'modules/data-manager.php';
require_once 'modules/input_manager.php';
require_once 'modules/page-manager.php';

//$input_manager = new input_manager();

$page_manager = new page_manager();

//$input_manager->responce;
?>
<!DOCTYPE html>
<html>
<?php $page_manager->include_file('head.php');?>
<body class="sticky_menu">
<!--side menu--> 

		
<!--layout-->
<div class="wide_layout bg_light"> 
  <!--header markup-->
  <?php $page_manager->include_file('header.php');?>
  
  <!--content-->
  <div class="page-cont" id="page-content"> </div>
  
  <hr class="divider_type_2">
  <!--footer-->
  <?php $page_manager->include_file('footer.php');?>
</div>

<!--back to top button-->
<button id="back_to_top" class="circle icon_wrap_size_2 color_blue_hover color_grey_light_4 tr_all d_md_none"> <i class="icon-angle-up fs_large"></i> </button>
<!--libs-->
<?php $page_manager->include_file('scripts.php');?>
<script>


	$(document).ready(function(e) {
	$('a').click(function(e) {
		if($(this).data("page")){
			//loading();
			var pagename = $(this).data("page");
			$.post('index.php',{
				request_type:'ajax_page',
				pagename:pagename
				},function(data,status){
					//open_title(pagename,1);
					//alert(me);
					$('#page-content').html(data);
					});
			return false;
			}
			
		if($(this).data("name") ){
			//loading();
			var filename = $(this).data("filename");
			var contentid = '';
			var htmltagid = '';
			
			$.post('index.php',{
				request_type:'ajax_file',
				filename:filename,
				param:contentid
				},function(data,status){
					//open_title(pagename,1);
					//alert(data);
					$('#'+htmltagid).html(data);
					});
			return false;
			}
	});
	setTimeout((function(){
	$.post('index.php',{
	request_type:'ajax_page',
	pagename:'<?php echo isset($_GET['page']) ? $_GET['page'] : NULL ?>'
	},function(data,status){
		$('#page-content').html(data);
		});
	}),1000);
	
 });
 
function open_page(pagename){
	loading();
	$.post('index.php',{
		request_type:'ajax_page',
		pagename:pagename
		},function(data,status){
			open_title(pagename,1);
			$('#page-content').html(data);
			});
	
	} 
function open_file(filename,contentid,htmltagid){

	$.post('index.php',{
		request_type:'ajax_file',
		filename:filename,
		param:contentid
		},function(data,status){
			//open_title(pagename,1);
			//alert(data);
			$('#'+htmltagid).html(data);
			});
	 }
	 
 function open_title(page_name,param){
	 $.post('index.php', {
				request_type:'ajax_file',
				filename:'page-header',
				page_name:page_name,
				param:param
		 
		 } , function(data,status){
			 $('#main-page-header').html(data);
			 });
	 }
function open_ajax_file(target,filename,param,value){

		// THE ABOVE PARAMETERS SHULD BE 
		// TARGET = element id where results shuld be displayed
		// FILENAME = the filename to be accessed e.g. file.php / file
		// PARAM = the filed name to be acceded in tha table of concerned e.g. id
		// VALUE = the record value need
		$.post('index.php',{
			request_type:'ajax_file',
			filename:filename,
			param:param,
			value:value
			},function(data,status){
				$('#'+target).html(data);
				});
		}
	
					
function open_ajax_form(filename,value_id){
		
		// THE ABOVE PARAMETERS SHULD BE 
		// TARGET = element id where results shuld be displayed
		// FILENAME = the filename to be accessed e.g. file.php / file
		// PARAM = the filed name to be acceded in tha table of concerned e.g. id
		// VALUE = the record value need
		$.post('index.php',{
			request_type:'ajax_form',
			filename:filename,
			id:value_id
			},function(data,status){
				$('#'+filename).html(data);
				
				});
		}
	
    </script>
</body>
<script>

</body>
</html>