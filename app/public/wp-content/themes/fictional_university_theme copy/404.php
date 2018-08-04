<?php get_header(); banner();

global $wp;
$slug =  $wp->request;
$relatedPages = new WP_Query(array(
	'posts_per_page' => 10, 
	'post_type' => array('professor', 'page', 'post', 'event', 'campus', 'program'), 
	'orderby'=>'type',
	's' => $slug,
	'paged'=>get_query_var('paged',1),
	)
);

?>

<div class="container container--narrow page-section">
	<?php 
	if(!$relatedPages->have_posts()){?>
	<div class="post-item">
		<h2 class="headline headline--small-plus">No Related Pages Found for &ldquo;<?php echo $slug ?>&rdquo;</h2>
	</div>
	<?php } else{
	?>

	<h2 class="headline headline--medium">Perhaps you were looking for...</h2>
	<br>
	<?php }
	while($relatedPages->have_posts()){
		$relatedPages->the_post(); ?>
		<div class="post-item">
			<?php get_template_part('template-parts/content', get_post_type()); ?>
		</div>
		<?php }
		echo paginate_links(array(
			'total'=>$relatedPages->max_num_pages
			));
			?>
			<hr class="section-break">
			<div class="generic-content">
				<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
				<label class="headline headline--medium" for="s">Perform a search: </label>
					<div class="search-form-row">
						<input placeholder = "What are you looking for?" class="s" id="s" type="search" name="s">
						<input class="search-submit" type = "submit" value="Search">
					</div>
				</form>
			</div>
		</div>



		<?php get_footer() ?>