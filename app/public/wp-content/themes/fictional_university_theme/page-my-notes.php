<?php 
if(!is_user_logged_in()){
  wp_redirect(site_url('/'));
  exit();
}
get_header(); 

while(have_posts()) { 
  the_post(); 
  banner();
  ?>


  <div class="container container--narrow page-section">
    <div class="create-note">
     <h2 class="headline headline--medium">Create New Note</h2>
     <input class="new-note-title" placeholder="Title">
     <textarea class="new-note-body" placeholder="Your note here..."></textarea>
     <span class="submit-note">Create Note</span>
     <span class="note-limit-message">Note Limit of <?php echo getNoteLimit() ?> Reached. Delete some notes to make room for new ones.</span>
      <br>
      <p class="alert" style="color:red;"></p>
    </div>
    <ul class="min-list link-list" id="my-notes">
      <?php 
      $currentUser = 
      $notes = new WP_Query( array(
        'post_type' => 'note',
        'orderby'     => 'date', 
        'order' => 'DSC',
        'posts_per_page' => -1,
        'author' => get_current_user_id(),
        )

      );
      if(!$notes->have_posts()){
        echo "<h2>You don't have any notes</h2>";
      }
      while ($notes -> have_posts()) {
        $notes-> the_post();
        ?>
        <li id="<?php the_ID() ?>">
          <input readonly class="note-title-field" value="<?php echo str_replace('Private: ', '', esc_attr(get_the_title())) ?>">
          <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
          <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
          <span class="share-note"><i class="fa fa-share"></i> Share</span>
          <textarea readonly class="note-body-field"><?php echo esc_textarea(get_the_content()) ?></textarea>
          <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>

        </li>
        <?php }
        ?>
      </ul>
    </div>

    <?php } get_footer(); ?>