<?php get_header(); 
banner(array(
	"title" => "All Events",
	"subtitle" => "See what is upcoming in our university",
	"background_image" => get_theme_file_uri('images/ocean.jpg')
	));

	?>


	<div class="container container--narrow page-section">
		<?php 
		$btnClass = "event-summary__date t-center";

		while(have_posts()){
			the_post();
			get_template_part('template-parts/content', 'event');
		} 
		echo paginate_links();
		?>
		<hr class="section-break">
		<p>Looking for a recap of our past events? <a href="<?php echo site_url('/past-events') ?>">Check out our past events archive!</a></p>
	</div>


	
	<?php get_footer() ?>