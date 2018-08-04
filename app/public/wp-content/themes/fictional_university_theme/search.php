<?php get_header(); 

banner(array(
	"title" => 'Search Results',
	"subtitle" => 'You searched for &ldquo;' . esc_html(get_search_query()) . '&rdquo;',
	"background_image" => get_field('page_banner_background_image', 39)['sizes']['banner']
	));

$results = new WP_Query(array(
	'posts_per_page' => 10, 
	'post_type' => array('professor', 'page', 'post', 'event', 'campus', 'program'), 
	'orderby'=>'type',
	's' => get_search_query(),
	'paged'=>get_query_var('paged',1),
	)
);
?>


<div class="container container--narrow page-section">
	<?php 
	if(!$results->have_posts()){?>
	<div class="post-item">
		<h2 class="headline headline--small-plus">No results found for &ldquo;<?php echo get_search_query() ?>&rdquo;</h2>
	</div>
	<?php }
	while($results->have_posts()){
		$results->the_post(); ?>
		<div class="post-item">
			<?php get_template_part('template-parts/content', get_post_type()); ?>
		</div>
		<?php }
		echo paginate_links(array(
			'total'=>$results->max_num_pages
			));
			?>
			<hr class="section-break">
			<div class="generic-content">
				<?php getSearchBox(); ?>
			</div>
		</div>



		<?php get_footer() ?>