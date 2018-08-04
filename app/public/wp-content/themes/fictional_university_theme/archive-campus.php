<?php

get_header();
banner(array(
  'title' => 'Our Campuses',
  'subtitle' => 'We have several conveniently located campuses.'
  ));
  ?>

  <div class="container container--narrow page-section">

    <div class="acf-map">

      <?php
      while(have_posts()) {
        the_post();
        $mapLocation = get_field('map_location');
        ?>
        <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
          <a href="<?php the_permalink(); ?>"><div class="infowindow">
          <h3><?php the_title(); ?></h3>
          <p><?php echo $mapLocation['address']; ?></p>
          </div></a>
        </div>


        <?php }
        echo paginate_links();
        ?>
      </div>



    </div>

    <?php get_footer();

    ?>