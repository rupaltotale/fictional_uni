	<?php

	require get_theme_file_path('/inc/search-route.php');

	function university_files(){
		wp_enqueue_script('googleMap','//maps.googleapis.com/maps/api/js?key=AIzaSyARvnayzLUq45FnVHAjYLDmV8XgZQiFDAk', NULL, microtime(), true);
		wp_enqueue_script('main-university-js', get_theme_file_uri('js/scripts-bundled.js'), NULL, microtime(), true);
		wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
		wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
		wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
		wp_localize_script('main-university-js','universityData', array(
			'root_url' => get_site_url(),
			'nonce' => wp_create_nonce( 'wp_rest' ),
			'noteCount' => count_user_posts(get_current_user_id(), 'note'),
			'noteLimit' => getNoteLimit(),
			));
	}

	function university_features(){
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		register_nav_menu('headerMenuLocation', 'Header Menu Location');
		register_nav_menu('exploreMenu', 'Explore Menu');
		register_nav_menu('learnMenu', 'Learn Menu');
		add_image_size('landscape', 400, 260, true);
		add_image_size('portrait', 480, 650, true);
		add_image_size('banner', 1500, 350, false);
	}

	function university_adjust_queries($query){
		if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()){
			$query -> set('meta_key','event_date');
			$query -> set('meta_value',date( "Ymd" ));
			$query -> set('meta_compare','>=');
			$query -> set('orderby' ,'meta_value_num');
			$query -> set('order','ASC');
		}
		if(!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()){
			$query-> set('posts_per_page', -1);
			$query -> set('orderby' ,'title');
			$query -> set('order','ASC');
		}
		if(!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()){
			$query-> set('posts_per_page', -1);
		}
	}
	function universityMapKey($api){
		$api['key'] = 'AIzaSyARvnayzLUq45FnVHAjYLDmV8XgZQiFDAk';
		return $api;

	}
	function university_custom_rest(){
		register_rest_field('post', 'authorName', array(
			'get_callback' => function() {return get_the_author();},
			));
		register_rest_field('note', 'noteCount', array(
			'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');},
			));
	}
	function redirectSubsToFrontend(){
		$currentUser = wp_get_current_user();
		$user_roles=$currentUser -> roles;
		if(sizeof($user_roles) == 1 && $user_roles[0] == 'subscriber'){	
			wp_redirect(site_url('/'));
			exit;
		}

	}

	function redirectToFrontPageAfterLogout(){
		wp_redirect(home_url());
		//home_url() = site_url('/')
		exit();
	}

	function noSubsAdminBar(){
		$currentUser = wp_get_current_user();
		$user_roles=$currentUser -> roles;
		if(sizeof($user_roles) == 1 && $user_roles[0] == 'subscriber'){	
			show_admin_bar( false );
		}

	}
	function outHeaderURL(){
		return esc_url(site_url('/'));
	}

	function ourLoginPageCSS(){
		wp_enqueue_style('university_main_styles', get_stylesheet_uri());
		wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
	}
	function ourLoginTitle() {
		return get_bloginfo('name');
	}
	// function checkNoteLimit(){
	// 	if(count_user_posts(get_current_user_id(), 'note') > 5){
	// 		return "Over";
	// 	}
		
	// }
	function makeNotePrivate($post){

		if ($post['post_type'] == 'note'){
			if(count_user_posts(get_current_user_id(), 'note') > (getNoteLimit() - 1) AND $_SERVER['REQUEST_METHOD'] === 'POST' AND $_POST[status] == 'publish'){
				die("You have reached your note limit");

			}
			$post['post_content'] = sanitize_textarea_field($post['post_content']);
			$post['post_title'] = sanitize_text_field($post['post_title']);

		}
		if ($post['post_type'] == 'note' && $post['post_status'] != 'trash'){
			$post['post_status'] = 'private';
		}
		return $post;
	}
	function remove_private_from_title($title){
		$title = esc_attr($title);
		$find = array('#Private: #');
		$replace = array('');
		$title = preg_replace($find, $replace, $title);
		return $title;

	}



	add_action('pre_get_posts', 'university_adjust_queries');
	add_action('wp_enqueue_scripts', 'university_files');
	add_action('after_setup_theme', 'university_features');
	add_action('acf/fields/google_map/api', 'universityMapKey');
	add_action('rest_api_init', 'university_custom_rest');
	add_action('admin_init', 'redirectSubsToFrontend');
	add_action('wp_logout','redirectToFrontPageAfterLogout');
	add_action('wp_loaded','noSubsAdminBar');
	add_filter('login_headerurl', 'outHeaderURL');
	add_action('login_enqueue_scripts', 'ourLoginPageCSS');
	add_filter('login_headertitle', 'ourLoginTitle');
	add_filter('wp_insert_post_data', 'makeNotePrivate');
	// add_filter('the_title', 'remove_private_from_title'); I DID THIS ANOTHER WAY SEE PAGE-MY-NOTES.PHP



 // PAGE BANNER FUNCTION

	function banner($args =NULL){ 
		if(!$args['title']){
			if(get_the_title()){
				$args['title'] = get_the_title();
			}
			else{
				$args['title'] = "Page Not Found";
			}

		}
		if(!$args['subtitle']){
			if(get_field('page_banner_subtitle')){
				$args['subtitle'] = get_field('page_banner_subtitle');
			}
			// else{
			// 	$args['subtitle'] = "Lorem Ipsum Dorem Lit";
			// }

		}
		if(!$args['background_image']){
			if(get_field('page_banner_background_image')){
				$args['background_image'] = get_field('page_banner_background_image')['sizes']['banner'];
			}
			else{
				$args['background_image'] = get_theme_file_uri('images/ocean.jpg');
			}


		}
		?>
		<div class="page-banner">
			<div class="page-banner__bg-image" style="background-image: url(<?php 
			echo $args['background_image'];?>)"></div>
			<div class="page-banner__content container container--narrow">
				<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
				<div class="page-banner__intro">
					<p><?php echo $args['subtitle']; ?></p>
				</div>
			</div>
		</div>

		<?php 
	} 
	function getSearchBox(){
		?>
		<form class="search-form" method="get" action="<?php echo esc_url(site_url('/')); ?>">
			<label class="headline headline--medium" for="s">Perform a new search: </label>
			<div class="search-form-row">
				<input placeholder = "What are you looking for?" class="s" id="s" type="search" name="s">
				<input class="search-submit" type = "submit" value="Search">
			</div>
		</form>
		<?
	}

	function getNoteLimit(){
		return 10;
	}

	?>

