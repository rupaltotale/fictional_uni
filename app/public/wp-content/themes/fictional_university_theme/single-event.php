<?php get_header(); 
the_post();
banner();?>


<?php 
$today = date('Ymd');
$eventDate = get_field('event_date');

?>
<div class="container container--narrow page-section">
	<div class="metabox metabox--position-up metabox--with-home-link">
		<p><a class="metabox__blog-home-link" href="<?php 
			if($today>$eventDate){
				echo site_url('/past-event'); 
			}
			else{
				echo get_post_type_archive_link('event'); 
			}
			?>"
			><i class="fa fa-home" aria-hidden="true"></i> 
			<?php 
			if($today>$eventDate){
				echo "Back To Past Events"; 
			}
			else{
				echo "Back To All Events"; 
			}
			?>
		</a> <span class="metabox__main"><?php the_title() ?></span>
	</p>
</div>
<div class="generic-content"><?php the_content() ?></div>

<?php 
$relatedPrograms = get_field('related_programs');


if($relatedPrograms){

	?>
	<hr class="section-break">

	<h2 class="headline headline--medium">Related Program(s)</h2>

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
