<?php
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    require_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php');
    global $wpdb;
    $requestType = $_POST['requestType'];
    switch ($requestType) {
    	case 'getGenerData':
    		$term_id = $_POST['term_id'];
    		$termname = $_POST['termname'];
    		$gener_args = array();
			$k=0;
			$html='';
			$all_products = get_posts( array(
			    'post_type' => 'product',
			    'post_status' => 'publish',
			    'tax_query' => array(
			        array(
			            'taxonomy' => 'genres',
			            'field' => 'slug',
			            'terms' => $termname, /*category name*/
			            'operator' => 'IN',
			            )
			        ),
		    	));
				$html.='<div class="container">
				  		<div class="row">';
				  			foreach ($all_products as $product): 
				  				$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );
				  				$proImage = (!empty($image_url[0]))? $image_url[0] : '/wp-content/uploads/woocommerce-placeholder.png';
							$html.='<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
								<div>
									<img src="'.$proImage.'" alt="" width="247" height="247">
								</div>
								<div class="d_flex">
									<a href="/'.$product->post_name.'"><svg xmlns="http://www.w3.org/2000/svg" id="play" width="42" height="42" viewBox="0 0 42 42"><g id="Ellipse_9" data-name="Ellipse 9" fill="none" stroke="#3d3d3d" stroke-width="2"><circle cx="21" cy="21" r="21" stroke="none"></circle><circle cx="21" cy="21" r="20" fill="none"></circle></g><path id="Polygon_1" data-name="Polygon 1" d="M6.136,1.481a1,1,0,0,1,1.728,0L13.123,10.5a1,1,0,0,1-.864,1.5H1.741a1,1,0,0,1-.864-1.5Z" transform="translate(28 14) rotate(90)" fill="#fff"></path></svg></a>
									<h2><a href="/'.$product->post_name.'" class="genre-heading">'.$product->post_title.'</a></h2>
								</div>
							</div>';
							endforeach;
							$html.='</div>
						</div>
					  	</div>
					</div>
				';
			$payload = array(
				'view' => $html
			);
			echo json_encode($payload);
		break;
    	
    	default:
		# code...
		break;
    }
?>