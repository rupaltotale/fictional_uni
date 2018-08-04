<?php get_header();
banner(array(
	"title" => "All Programs",
	"subtitle" => "There is something for everyone. Have a look around.",
	"background_image" => get_theme_file_uri('images/ocean.jpg')
	));
	?>

	<div class="container container--narrow page-section">
		<ul class="link-list min-list">
			<?php 

			while(have_posts()){
				the_post();
				?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
				
				<?
				
			} 
			echo paginate_links();
			?>
		</ul>
	</div>


	
	<?php get_footer() ?>