<?php get_header(); banner();?>


<div class="container container--narrow page-section">
  <?php 
  $btnClass = "event-summary__date t-center";
  $pastEvents = new WP_Query(array(
                // 'posts_per_page' => '10',
    'paged'=>get_query_var('paged',1),
    'post_type'    => 'event',
    'meta_key'     => 'event_date',
    'meta_value'   => date( "Ymd" ), 
    'meta_compare' => '<', 
    'orderby' => 'meta_value_num',
    'order' => 'DSC'

    ));
  while($pastEvents->have_posts()){
    $pastEvents->the_post();
    get_template_part('template-parts/content', 'event');
    
    
  } 
  echo paginate_links(array(
    'total'=>$pastEvents->max_num_pages
    ));
    ?>

    <hr class="section-break">
    <p><a href="<?php echo get_post_type_archive_link('event') ?>">&#8810;  Go back to All Events</a></p>
  </div>

  <?php get_footer() ?>