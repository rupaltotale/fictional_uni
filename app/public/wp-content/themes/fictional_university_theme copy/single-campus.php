<?php get_header(); 
the_post();
$mapLocation = get_field('map_location');
banner();?>


<div class="container container--narrow page-section">
	<div class="metabox metabox--position-up metabox--with-home-link">
		<p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus') ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to All Campuses</a> <span class="metabox__main"><?php the_title() ?></span>
		</p>
	</div>
	<div class="generic-content"><?php the_content() ?></div>
	<div class="acf-map">
		<div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
			<h3><?php the_title(); ?></h3>
			<p><?php echo $mapLocation['address']; ?></p>
		</div>
	</div>


<?php 
$relatedPrograms = get_field('related_programs');

if($relatedPrograms){

	?>
	<hr class="section-break">

	<h2 class="headline headline--medium">Program(s) available at this campus</h2>

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
