<?php require_once '../controls/modules.php';

require_once 'modules/data-manager.php';
require_once 'modules/page-manager.php';
require_once 'modules/input_manager.php';
$input_manager = new input_manager();

$page_manager = new page_manager();

$input_manager->responce;


?><!DOCTYPE html>
<html lang="en">
<!-- Mirrored from themepixels.com/demo/webpage/bracket/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 22 Apr 2014 10:30:40 GMT -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../views/images/title-icon.png" type="image/png">
  <title>Social Inteligence Reporting </title>
  <link href="views/template/css/style.default.css?page=100" rel="stylesheet">
  <link href="views/template/css/jquery.datatables.css?page=100" rel="stylesheet">
    <link rel="stylesheet" href="views/template/css/bootstrap-wysihtml5.css" />

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
  	.padder { padding:10px;}
	.noresize,.no-resize { resize:none;}
  </style>
</head>

<body class="stickyheader">
<iframe name="post_iframe" id="post_iframe" class="hidden"></iframe>
<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
<section>
  <!-- leftpanel -->
  <?php $page_manager->include_file('left-panel');?>
  <div class="mainpanel">
    
    <?php $page_manager->include_file('header.php');?><!-- headerbar -->
   <div class='' id="main-page-header"> <?php $page_manager->include_file('page-header.php');?></div><!-- page-header -->
    <div class="contentpanel bg-white" id="page-content">LOADING</div>
    <!-- contentpanel -->
    
  </div><!-- mainpanel -->
  
  <?php $page_manager->include_file('right-panel')?><!-- rightpanel -->
  
  
</section>

<style>
	.panel.border { border:1px solid #eee;}
</style>
<script src="views/template/js/jquery-1.10.2.min.js"></script>
<script src="views/template/js/jquery-migrate-1.2.1.min.js"></script>
<script src="views/template/js/jquery-ui-1.10.3.min.js"></script>
<script src="views/template/js/bootstrap.min.js"></script>
<script src="views/template/js/modernizr.min.js"></script>
<script src="views/template/js/jquery.sparkline.min.js"></script>
<script src="views/template/js/toggles.min.js"></script>
<script src="views/template/js/retina.min.js"></script>
<script src="views/template/js/jquery.cookies.js"></script>

<script src="views/template/js/flot/flot.min.js"></script>
<script src="views/template/js/flot/flot.resize.min.js"></script>
<script src="views/template/js/morris.min.js"></script>
<script src="views/template/js/raphael-2.1.0.min.js"></script>

<script src="views/template/js/jquery.datatables.min.js"></script>
<script src="views/template/js/chosen.jquery.min.js"></script>
<script src="views/template/js/custom.js"></script>

<script>


function loading(){
	$('#main-page-header').html("<div class='pageheader'> <h2><i class='fa fa-spinner fa-spin'></i> Loading <span>Please wait</span></h2></div>");
	}
$(document).ready(function(e) {
	$('a').click(function(e) {
		if($(this).data("page")){
			loading();
			var pagename = $(this).data("page");
			$.post('index.php',{
				request_type:'ajax_page',
				pagename:pagename
				},function(data,status){
					open_title(pagename,1);
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
		
		open_title('dashboard',1);
		$('#page-content').html(data);
		});
	}),1000);
	
 });
 
function delete_table_record(table,key,id){
	
	}

function delete_album(album_id){
	$.post('index.php',{
		request_type:'ajax_post',
		frm_action:'delete_album',
		id:album_id,
		},function(data,status){
			open_page('albums');	
			});	
	}

function delete_image(image_id){
	$.post('index.php',{
		request_type:'ajax_post',
		frm_action:'delete_image',
		id:image_id,
		},function(data,status){
			$('#image_'+image_id).hide('fast');
			});
		
	}


 
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

 
function open_template_page(resource_id){
	loading();
	$.post('index.php',{
		request_type:'ajax_page',
		pagename:'data-template',
		resource_id:resource_id,
		},function(data,status){
			open_title('data-template',1);
			$('#page-content').html(data);
			});
	
	} 

function open_template_editor(facility_id){
	loading();
	$.post('index.php',{
		request_type:'ajax_page',
		pagename:'data-template',
		facility_id:facility_id,
		},function(data,status){
			open_title('data-template',1);
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
 	function open_image_form(target,filename,album,image){
		
		// THE ABOVE PARAMETERS SHULD BE 
		// TARGET = element id where results shuld be displayed
		// FILENAME = the filename to be accessed e.g. file.php / file
		// PARAM = the filed name to be acceded in tha table of concerned e.g. id
		// VALUE = the record value need
		$.post('index.php',{
			request_type:'ajax_form',
			filename:filename,
			album:album,
			id:image
			},function(data,status){
				$('#'+target).html(data);
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
	
					
	function open_nav_facility_info(filename,ref_no){
		// THE ABOVE PARAMETERS SHULD BE 
		// TARGET = element id where results shuld be displayed
		// FILENAME = the filename to be accessed e.g. file.php / file
		// PARAM = the filed name to be acceded in tha table of concerned e.g. id
		// VALUE = the record value need
		$.post('index.php',{
			request_type:'ajax',
			filename:filename,
			re_no:ref_no
			},function(data,status){
				alert(data);
				$('#'+filename).html(data);
				});
		}
	
	
	function open_facility_data(facility_id){
		open_ajax_file()
		
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
	
	function delete_record(target,table_name,value_id){
		// THE ABOVE PARAMETERS SHULD BE 
		// TARGET = element id where results shuld be displayed
		// TABLE NAME = the table from which you want to delete a record
		// VALUE ID = the value of the parameter you need to delete
		$.post('index.php',{
			frm_action:'del_'+table_name,
			request_type:'ajax_post',
			id:value_id
		},function(data,status){
				$('#'+table_name+'_'+value_id).slideUp('fast');
			    $('#'+target).removeClass('hidden');
				$('#'+target).html(data);
			});
		}
	
	function close_file(call_back,element_id){}
	
	function delete_content(type,target,id){
		if(!confirm("Are you sure")){return false;}
		$.post('index.php',{
			frm_action:'delete_content',
			request_type:'ajax_post',
			id:id,
			},function(data,status){
				if(document.getElementById(target)){
					$('#'+target).hide('fast');
					}else {open_page(type,0,type);}
				});
		
		
		}
	 function add_remark(id_1,id_2,remark){
		   $.post('index.php',{
			   request_type:'ajax_post',
			   frm_action:'set_remark',
			   data_1:id_1,
			   data_2:id_2,
			   remark:remark,
			   
			   },function(data,status){
				   
				   });
		   
		   }
    </script>

</body>
<!-- Mirrored from themepixels.com/demo/webpage/bracket/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Tue, 22 Apr 2014 10:31:49 GMT -->
</html>
