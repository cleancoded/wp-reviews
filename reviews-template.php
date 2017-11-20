<?php
/**
 * Template Name: Reviews Page
 * The template for displaying doctor list with review link
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage wp
 * @since 1.0
 * @version 1.0
 */

get_header();

?>
<?php 
//get doctors
$doctors = '';
$max_num_pages = 0;
global $paged;
$doc_with_reviews = 0;
if(isset($_GET['searchsubmit'])  &&  isset($_GET['physcian_name'])){
  	$_doctors_last_name = $_GET['physcian_name'];
if(	$_doctors_last_name !== ' ' && !empty(	$_doctors_last_name)){
  $doctors = new WP_Query(array(
    'post_type'=>'doctors',
    'posts_per_page' => 12,
    'meta_query' => array(
    'relation' => 'OR',
    array(
    'key'=>'doctors_last_name',
    'compare' => 'LIKE',
    'value'=>$_doctors_last_name
     ),
  array(
    'key'=>'doctor_name',
    'compare' => 'LIKE',
    'value'=>$_doctors_last_name
     ))
  ));
  
}else {
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
  $doctors = new WP_Query(array(
    'post_type'=>'doctors',
  'paged' => $paged,
  'posts_per_page' => 12
  ));
} }else{
 	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$args = array('post_type' => 'doctors',
 	'paged' => $paged,
 'posts_per_page' => 12,
);
  $doctors = new WP_Query($args);
}
$the_query = $doctors;
?>
<div class="doctor_reviews_template container">
	<div class="doctor_filter">
	<?php echo do_shortcode('[review-filter]'); ?>
	</div>
	<?php
//  global $post,$wpdb;
  if($doctors->have_posts()){
  while($doctors->have_posts()){
    setup_postdata($post);
    $doctors->the_post();
      //cheeck reviews are available for a doctor
    $testimonials_of_doc= ''; $reviews_of_doc = '';
    if(isset($_GET['specialityTags']) && !empty($_GET['specialityTags']) && $_GET['specialityTags'] !== ' '){
      $reviews_of_doc = get_posts( array(
        'post_type'=>'doctor_reviews', 
        'meta_query' => array(
        	array(
        		'key'=>'review_details_choose_doctor', 
        		'value'=> $post->ID,
        		'compare'=> 'LIKE'
        ),
        array(
        'key' => 'review_details_speciality',
        'value' => $_GET['specialityTags']
      )
      ) ) );
    $testimonials_of_doc = get_posts( array(
        'post_type'=>'doctor_testimonials', 
        'meta_query' => array(
        	array(
        		'key'=>'testimonial_details_choose_doctor', 
        		'value'=> $post->ID,
      			'compare'=> 'LIKE'
        ),
        array(
        'key' => 'testimonial_details_speciality',
        'value' => $_GET['specialityTags']
      )
      ) ));
    }else {
        $reviews_of_doc = get_posts( array(
        'post_type'=>'doctor_reviews', 
     		'meta_query'=>array(
          array(
          'key'=>'review_details_choose_doctor', 
          'value'=> $post->ID,
          'compare'=> 'LIKE'
          
          ))
      ) );
    $testimonials_of_doc = get_posts( array(
        'post_type'=>'doctor_testimonials', 
        		'meta_query'=>array(
      array(
      'key'=>'testimonial_details_choose_doctor', 
        		'value'=> $post->ID,
      'compare'=>'LIKE',
      ))
      ) );
    }
    $check_con = NULL;
	if(!empty($reviews_of_doc) || !empty($testimonials_of_doc)){
	  $doc_with_reviews++;
    if(isset($_GET['testimonials_reviews']) && ($_GET['testimonials_reviews'] !== '') && ($_GET['testimonials_reviews'] !== ' ')){
      $_testimonials_reviews = $_GET['testimonials_reviews'];
      if($_testimonials_reviews === "Review"){
        		$check_con = $reviews_of_doc; 
      	} else if($_testimonials_reviews === "Testimonial"){
            $check_con = $testimonials_of_doc;
    	  }
        if(!empty($check_con)){
	?>
  
	<div class="col-md-6">
    <div style="border:2px solid #CCC; padding:10px; display:inline-block; width:100%; margin-bottom:10px; height:200px; overflow:hidden;">
		<div class="col-md-4">
			<?php 
      $image = get_field('photo');
      		if($image){
										 $size = 'thumbnail';
										 $thumb = $image['sizes'][ $size ];
										 $width = $image['sizes'][ $size . '-width' ];
										 $height = $image['sizes'][ $size . '-height' ]; ?>
										 <img  src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
									<?php }else{?>
										 <img  src="<?php  echo esc_url( home_url('/'));?>wp-content/uploads/2017/05/nopic.png" />
									<?php } ?>
		</div>
		<div class="col-md-8">
			<?php 
			printf(__('<h3 class="doc_name"><a href="%s">%s</a></h3>'), get_the_permalink(), esc_html(get_the_title()));
			 ?>
			 <p style="line-height:1.5;font-size:12px;"><?php 
      //get terms
      $get_terms = get_field('speciality_taxonomy');
       foreach($get_terms as $term_id){
         $category = get_term($term_id);
         echo $category->name. ",";
       }
         ?>
      </p>
      <?php if(!empty($reviews_of_doc)) { ?>
      <a href="<?php echo '/doctor_review/?tab_open=review&doctor_id='.$post->ID; ?>" class="btn btn-info">View Reviews</a> <?php } ?>
<?php if(!empty($testimonials_of_doc)){ ?>      <a href="<?php echo '/doctor_review/?tab_open=testimonial&doctor_id='.$post->ID; ?>" class="btn btn-info">View Testimonials</a> <?php } ?>
      
</div>
    </div>
  </div>
<?php }
  }else { ?>
  <div class="col-md-6">
    <div style="border:2px solid #CCC; padding:10px; display:inline-block; width:100%; margin-bottom:10px; height:200px; overflow:hidden;">
		<div class="col-md-4">
			<?php 
      $image = get_field('photo');
      		if($image){
										 $size = 'thumbnail';
										 $thumb = $image['sizes'][ $size ];
										 $width = $image['sizes'][ $size . '-width' ];
										 $height = $image['sizes'][ $size . '-height' ]; ?>
										 <img  src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
									<?php }else{?>
										 <img  src="<?php  echo esc_url( home_url('/'));?>wp-content/uploads/2017/05/nopic.png" />
									<?php } ?>
		</div>
		<div class="col-md-8">
			<?php 
			printf(__('<h3 class="doc_name"><a href="%s">%s</a></h3>'), get_the_permalink(), esc_html(get_the_title()));
			 ?>
			 <p style="line-height:1.5;font-size:12px;"><?php 
      //get terms
      $get_terms = get_field('speciality_taxonomy');
       foreach($get_terms as $term_id){
         $category = get_term($term_id);
         echo $category->name. ",";
       }
         ?>
      </p>
      <?php if(!empty($reviews_of_doc)) { ?>
      <a href="<?php echo '/doctor_review/?tab_open=review&doctor_id='.$post->ID; ?>" class="btn btn-info">View Reviews</a> <?php } ?>
<?php if(!empty($testimonials_of_doc)){ ?>      <a href="<?php echo '/doctor_review/?tab_open=testimonial&doctor_id='.$post->ID; ?>" class="btn btn-info">View Testimonials</a> <?php } ?>
      
</div>
    </div>
  </div>
  <?php }  ?>
  <?php
  } 
    
  }
//endif; 
    
?>
  
</div>

<?php
    $max_num_pages = intval($doc_with_reviews/12);
    custom_pagination($max_num_pages, '', $paged);
wp_reset_postdata();
}
?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
//get_sidebar();
?>
</div><!-- .wrap -->

<?php
get_footer();

