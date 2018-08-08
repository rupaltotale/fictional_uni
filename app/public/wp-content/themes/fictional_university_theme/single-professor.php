<?php get_header(); 
the_post();
banner();

$post_id = $post->ID;
if (!get_post_meta($post_id, 'userLikesArray', true )){
	add_post_meta($post_id, 'userLikesArray', array());
}

$post_id = $post->ID;
$userLikesArray = get_post_meta(get_the_id(), 'userLikesArray', true );
$userLoggedIn = is_user_logged_in();
$userLikes = in_array (get_current_user_id() , $userLikesArray);

?>
<div class="container container--narrow page-section">
	
	<div class="generic-content">
		<div class="row group">
			<div class="one-third">
				<?php if ( has_post_thumbnail() ) { 
					the_post_thumbnail( 'portrait' );
				}?>
			</div>
			<div class="two-thirds">
				<span class="like-box" id = "<?php echo get_the_ID() ?>" 
					<?php if ($userLoggedIn && $userLikes) {
						echo 'data-exists="yes"';
					} else if ($userLoggedIn && !$userLikes){
						echo 'data-exists="no"';
					}
					else{
						echo 'data-exists="idk"';
					}
					?>
					>
					<i class="fa fa-heart-o" id = "like-button" aria-hidden="true"></i>
					<i class="fa fa-heart" id = "like-button" aria-hidden="true"></i>
					<span class="like-count"><?php echo sizeof($userLikesArray) ?></span>
				</span>
				<?php 
				the_content(); 
				print_r($userLikesArray);
				// array_push($userLikesArray, 13);
				// print_r($userLikesArray);

				// update_post_meta(get_the_ID(), 'userLikesArray', $userLikesArray);
				
				?>
			</div>
		</div>

	</div>

	
	


	<!-- Subjects Taught -->
	<?php 
	$relatedPrograms = get_field('related_programs');

	if($relatedPrograms){

		?>
		<hr class="section-break">

		<h2 class="headline headline--medium">Subject(s) taught</h2>

		<ul class="link-list min-list">

			<?php
			foreach ( $relatedPrograms as $relatedProgram) {
				
				$programTitle = get_the_title($relatedProgram);
				$programPermalink = get_the_permalink($relatedProgram); 

				?>
				<li><a href="<?php echo $programPermalink ?>"><?php echo $programTitle ?></a></li>
				<?php  }

			}


			?>

			
		</ul></div>
		<?php  
		get_footer();
		?>
