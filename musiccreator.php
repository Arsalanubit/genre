<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet"/>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<style>
	@media (min-width: 1400px){
		.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
		    max-width: 1140px !important;
		}
	}
	a.genre-heading {
		color: #fff;
		font-size: 22px;
	}
	a.genre-heading:hover {
		color: #cc7d58;
	}
	a.nav-link:hover {
		color: #fff;
	}
	.d_flex{
		display: flex!important;
	    flex-direction: row;
	    align-items: center;
	    justify-content: center;
	    margin-top: 20px;
	}
	.d_flex svg{
		margin-left: -30px;
	}
	.d_flex h2{
		font-family: "Gilroy", Sans-serif;
		font-weight: 600;
		margin-left: 20px !important;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
		color: #fff !important;
	    border-color: #cc7d58;
	}
	.nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active:hover {
	    color: white !important;
	    border-color: #cc7d58 !important;
	}
	.nav-tabs .nav-link:hover {
	    color: white !important;
	    border-color: #cc7d58 !important;
	}
</style>
<body style="background-color: #141618;">
<div class="container">
<!-- Tabs navs -->
<?php
	$cat_args = array(
	    'orderby'    => $orderby,
	    'order'      => $order,
	    'hide_empty' => $hide_empty,
	);
 
$product_categories = get_terms( 'product_cat', $cat_args );
if(count($product_categories)!=0){
?>
<ul class="nav nav-tabs mb-3 justify-content-center" id="ex1" role="tablist">
	<?php 
		$i=0;
		foreach ($product_categories as $category) {  
		$i++;
		$activeClass='';
		if ($i==1) {
			$activeClass = 'active';
		}
	?>
  	<li class="nav-item <?= $activeClass?>" role="presentation">
    	<a class="nav-link <?= $activeClass?>" href="#category_<?= $category->term_id ?>" id="ex1-tab-<?= $category->term_id ?>" data-mdb-toggle="tab" role="tab" aria-controls="ex1-tabs-1" aria-selected="true" style="color: #FFFFFF5E; background: none;"><?php echo $category->name; ?></a>
  	</li>
	<?php } ?>
	<li class="nav-item" role="presentation">
	  	<a class="nav-link dropdown-toggle" id="generDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="color: #FFFFFF5E;background: none;">Browse by genre</a>
		<div class="dropdown">
		  <ul class="dropdown-menu" aria-labelledby="generDropdown">
		  	<?php
			  	$gener_args = array(
				    'orderby'    => $orderby,
				    'order'      => $order,
				    'hide_empty' => $hide_empty,
				);
				$product_geners = get_terms( 'genres', $gener_args );
				foreach($product_geners as $product_gener) { 
			?>
			    <li><a class="dropdown-item getgenerData" href="javascript:;" termName="<?= $product_gener->name ?>" termId="<?= $product_gener->term_id ?>"><?= $product_gener->name?></a></li>
		   	<?php } ?>
		  </ul>
		</div>
	</li>
</ul>
<!-- Tabs navs -->
<!-- Tabs content -->
<div class="tab-content" id="category_item">
<?php
	$k=0;
	foreach ($product_categories as $category) { 
	$k++;
	$activeTab='';
	if ($k==1) {
		$activeTab = 'show active';
	}
?>
<div class="tab-pane fade <?= $activeTab ?>" id="category_<?= $category->term_id ?>" role="tabpanel" aria-labelledby="ex1-tab-1">
  	<?php
	  	$all_products = get_posts( array(
		    'post_type' => 'product',
		    'numberposts' => -1,
		    'post_status' => 'publish',
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'product_cat',
		            'field' => 'slug',
		            'terms' => $category->name, /*category name*/
		            'operator' => 'IN',
		            )
		        ),
	    ));
  	?>
  	<div class="container">
  		<div class="row">
  			<?php foreach ($all_products as $product): ?>
			<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
				<div>
					<?php
						$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );
						$proImage = (!empty($image_url[0]))? $image_url[0] : '/wp-content/uploads/woocommerce-placeholder.png';
					?>
					<img src="<?php echo $proImage; ?>" alt="" width="247" height="247">
				</div>
				<div class="d_flex">
					<a href="<?= $product->guid ?>"><svg xmlns="http://www.w3.org/2000/svg" id="play" width="42" height="42" viewBox="0 0 42 42"><g id="Ellipse_9" data-name="Ellipse 9" fill="none" stroke="#3d3d3d" stroke-width="2"><circle cx="21" cy="21" r="21" stroke="none"></circle><circle cx="21" cy="21" r="20" fill="none"></circle></g><path id="Polygon_1" data-name="Polygon 1" d="M6.136,1.481a1,1,0,0,1,1.728,0L13.123,10.5a1,1,0,0,1-.864,1.5H1.741a1,1,0,0,1-.864-1.5Z" transform="translate(28 14) rotate(90)" fill="#fff"></path></svg></a>
					<h2><a href="<?= $product->guid ?>" class="genre-heading"><?= $product->post_title ?></a></h2>
				</div>
			</div>
			<?php endforeach ?>
		</div>
  	</div>
</div>
<?php } ?>
<div class="tab-pane fade" id="generTab" role="tabpanel" aria-labelledby="ex1-tab-gener">
</div>
</div>
<?php } ?>
<!-- MDB -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
<script>
jQuery(document).ready(function($) {
	$(document).on('click','.getgenerData',function(){
		$this = $(this);
		getTermId = $(this).attr('termId');
		gettermName = $(this).attr('termName');
		$.ajax({
		    url: '<?= get_template_directory_uri() ?>/datafiles.php',
		    method: "POST",
		    data: {
		      term_id: getTermId,
		      termname: gettermName,
		      requestType: 'getGenerData'
		    },
		    success: function(result){
		      let res = JSON.parse(result);
		      $(".tab-pane").removeClass('active show');
		      $(".nav-item").removeClass('active show');
		      $(".nav-link").removeClass('active show');
		      $("#generTab").html(res.view);
		      $("#generTab").addClass('active show');
		      $("#generDropdown").addClass('active show');
		      $("#generDropdown").html(gettermName);
		    }
	  	});
	});
});
</script>
</body>
</html>