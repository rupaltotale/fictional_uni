<?php get_header(); 

while(have_posts()) { 
	the_post(); 
	banner();
	?>



	<div class="container container--narrow page-section">
		<?php if(wp_get_post_parent_ID(get_the_ID())) {?>
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p><a class="metabox__blog-home-link" href="<?php echo get_the_permalink(wp_get_post_parent_ID(get_the_ID())) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title(wp_get_post_parent_ID(get_the_ID())) ?></a> <span class="metabox__main"><?php the_title() ?></span>
			</p>
		</div>
		<?php } ?>


		<?php  $parentID = wp_get_post_parent_ID(get_the_ID()); 

if($parentID == 0){ // current page is the parent 
	$parentID = get_the_ID(); 
	$children = get_children( $parentID);
	if(sizeof($children) != 0){
		?>
		<div class="page-links">
			<h2 class="page-links__title"><a href="<?php echo get_the_permalink($parentID) ?>"><?php the_title(); ?></a></h2>
			<ul class="min-list">
				<?php 

				foreach ( $children as $childID) {

					$childTitle = get_the_title($childID);
					$childPermalink = get_the_permalink($childID); 

					?>
					<li><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
					<?php  }


					?>

				</ul>
			</div>

			<?php  
		}}
		else{  
			$currentID = get_the_ID();
			?>
			<div class="page-links">
				<h2 class="page-links__title"><a href="<?php echo get_the_permalink($parentID) ?>"><?php echo get_the_title($parentID); ?></a></h2>
				<ul class="min-list">
					<?php 

					$children = get_children( $parentID);

					foreach ( $children as $child) {
						$childTitle = get_the_title($child);
						$childPermalink = get_the_permalink($child);
						$childID = $child -> ID;
						if(get_the_ID() == $childID){

							?>
							<li class="current_page_item"><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
							<?php  }

							else{ 


								?>

								<li><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
								<?php  }
							}

							?>

						</ul>
					</div>

					<?php  } 
					?> 

					<div class="generic-content">
						<?php getSearchBox(); ?>
					</div>
				</div>

				

				<?php } get_footer(); ?>