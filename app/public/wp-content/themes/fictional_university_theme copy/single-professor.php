<?php get_header(); 
the_post();
banner();?>

<?php 
$today = date('Ymd');
$eventDate = get_field('event_date');

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
				<?php the_content() ?>
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
