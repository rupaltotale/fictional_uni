<?php get_header(); 

while(have_posts()) { 
  the_post(); 
  banner();
  ?>


<!-- <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php 
      $pageBannerImage = get_field('page_banner_background_image');
    echo $pageBannerImage['sizes']['banner']?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_title(); ?></h1>
        <div class="page-banner__intro">
            <p><?php echo get_field('page_banner_subtitle'); ?></p>
        </div>
    </div>
  </div> -->


  <div class="container container--narrow page-section">
    <?php if(wp_get_post_parent_ID(get_the_ID())) {?>
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_the_permalink(wp_get_post_parent_ID(get_the_ID())) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title(wp_get_post_parent_ID(get_the_ID())) ?></a> <span class="metabox__main"><?php the_title() ?></span>
      </p>
    </div>
    <?php } ?>
    
    <!-- <div class="page-links">
      <h2 class="page-links__title"><a href="#">About Us</a></h2>
      <ul class="min-list">
        <li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li>
      </ul>
    </div> -->

    <?php  $parentID = wp_get_post_parent_ID(get_the_ID()); 

if($parentID == 0){ // current page is the parent 
	$parentID = get_the_ID(); 
	$children = get_children( $parentID);
	if(sizeof($children) != 0){
   ?>
   <div class="page-links">
    <h2 class="page-links__title"><a href="<?php echo get_the_permalink($parentID) ?>"><?php the_title(); ?></a></h2>
    <ul class="min-list">
      <?php 

      foreach ( $children as $childID) {
        
       $childTitle = get_the_title($childID);
       $childPermalink = get_the_permalink($childID); 

       ?>
       <li><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
       <?php  }


       ?>
       
     </ul>
   </div>

   <?php  
 }}
 else{  
   $currentID = get_the_ID();
   ?>
   <div class="page-links">
    <h2 class="page-links__title"><a href="<?php echo get_the_permalink($parentID) ?>"><?php echo get_the_title($parentID); ?></a></h2>
    <ul class="min-list">
     <?php 

     $children = get_children( $parentID);

     foreach ( $children as $child) {
       $childTitle = get_the_title($child);
       $childPermalink = get_the_permalink($child);
       $childID = $child -> ID;
       if(get_the_ID() == $childID){
         
        ?>
        <li class="current_page_item"><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
        <?php  }

        else{ 
         

         ?>

         <li><a href="<?php echo $childPermalink ?>"><?php echo $childTitle ?></a></li>
         <?php  }
       }

       ?>
       
     </ul>
   </div>

   <?php  } 
   ?> 
   

   <div class="generic-content">
    <?php the_content(); ?>
  </div>

</div>

<?php } get_footer(); ?>