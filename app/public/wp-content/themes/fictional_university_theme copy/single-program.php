<?php get_header(); 
the_post();
banner();?>
<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo site_url('/programs') ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to Programs</a> <span class="metabox__main"><?php the_title() ?></span>
        </p>
    </div>
    <div class="generic-content"><?php the_content() ?></div>

    <!-- Taught by (list of names of professor..) -->
    <?php 
    $professors = new WP_Query(array(
        'posts_per_page' => -1, 
        'post_type'    => 'professor',
        'orderby'     => 'title', 
                // 'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
                )
            )
        )); 

    if($professors-> have_posts()){

        ?>
        <hr class="section-break">

        <h2 class="headline headline--medium"><?php the_title() ?> professor(s)</h2>

        <ul class="professor-cards">

            <?php
            while($professors -> have_posts()){
                $professors -> the_post();
                $professorTitle = get_the_title();
                $professorPermalink = get_the_permalink(); 

                ?>
                <li class="professor-card__list-item">
                    <a class= "professor-card" href="<?php echo $professorPermalink ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('landscape') ?>"></img>
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>
                <?php  
                
            } 
            echo "</ul>";
        } 
        wp_reset_postdata();


        ?> 
        
        <!-- Upcoming Events -->
        <?php 
        $events = new WP_Query(array(
            'post_type'    => 'event',
            'meta_key'     => 'event_date', 
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare'=> '>=',
                    'value'=>date('Ymd'),
                    'type' =>'numeric',
                    ),
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                    )
                )
            ));  

        if($events->have_posts()){


            ?>
            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming <?php the_title() ?> Events</h2>

            <?php while($events -> have_posts()){
              $events -> the_post();
              get_template_part('template-parts/content', 'event');
          }} 
          wp_reset_postdata();

//Campuses program is available at 

 
    $programName = get_the_title();
    $campuses = new WP_Query(array(
        'posts_per_page' => -1, 
        'post_type'    => 'campus',
        'orderby'     => 'title', 
                // 'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"',
                )
            )
        )); 

    if($campuses-> have_posts()){

        ?>
        <hr class="section-break">

        <h2 class="headline headline--medium"><?php echo ucfirst($program) ?> is available at these campus(es):</h2>

        <ul class="link-list min-list">

            <?php
            while($campuses -> have_posts()){
                $campuses -> the_post();?>
                <li><a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a></li>
                <?php  
                
            } 
            echo "</ul></div>";
        } 
        wp_reset_postdata();


        ?> 





<!-- Upcoming events alternate (long) -->
    <!-- <?php 
        $actualTitle = get_the_title();
        $eventTitles[] = null;
        $eventLinks[] = null;
        $eventIDs[] = null;
        $hasUpcomingEvents = false;
        $upcomingEvents = new WP_Query(array(
                        'post_type'    => 'event',
                        'meta_key'     => 'event_date',
                        'meta_value'   => date( "Ymd" ), 
                        'meta_compare' => '>=', 
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        //Another way to filter the query. See Section 9, lecture 36 for more details. 

                        // 'meta_query'=> array(
                        //     array(
                        //         'key' => 'related_programs',
                        //         'compare'=>'LIKE',
                        //         'value' => '"'.get_the_ID().'"'
                        //         )
                        //     )
        
                        )); ?>
        <?php
            while($upcomingEvents->have_posts()){
                      $upcomingEvents->the_post();
                        $relatedPrograms = get_field('related_programs');
            
                if($relatedPrograms){
                
                    foreach ( $relatedPrograms as $relatedProgram) {
                    
                        $programTitle = get_the_title($relatedProgram);
                        $programPermalink = get_the_permalink($relatedProgram); 
                        if($programTitle == $actualTitle){
                            array_push($eventTitles, get_the_title());
                            array_push($eventLinks, get_permalink());
                            $hasUpcomingEvents = true;
                            // array_push($eventIDs, get_the_permalink());
                
                        }
                    }
                 
                }
            }
            wp_reset_postdata(); 
            if($hasUpcomingEvents){ 
                ?>
                <hr class="section-break">
                <h2 class="headline headline--medium">Upcoming <?php the_title() ?> Events</h2>
                <ul class="link-list min-list">
                <?php
                for ($i = 0; $i < count($eventTitles); $i++) {
                ?>
                <li><a href="<?php echo $eventLinks[$i] ?>"><?php echo $eventTitles[$i] ?></a></li>

            <?php  }}
            ?>
    </ul>
</div> -->
<?php 
get_footer();
?>