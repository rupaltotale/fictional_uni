<?php 

	function add_new_post_types(){
		//Event Post Type
		register_post_type('event', array(
			'capability_type' => 'event',
			'map_meta_cap' => true,
			'supports' => array('title', 'editor', 'excerpt'),
			'rewrite' => array('slug' => 'events'),
			'has_archive' => true,
			'public' =>true,
			'menu_icon' => 'dashicons-calendar',
			'labels' => array(
				'name' => 'Events',
				'all_items'=>'All Events',
				'edit_item'=> 'Edit Event',
				'singular_item'=>'Event',
				'add_new_item'=>'Add New Event',
				'not_found' => 'No Events Found'
				)
			));

		// Programs Post Type
		register_post_type('program', array(
			'capability_type' => 'program',
			'map_meta_cap' => true,
			'show_in_rest' => true,
			'supports' => array('title', 'editor', 'excerpt'),
			'rewrite' => array('slug' => 'programs'),
			'has_archive' => true,
			'public' =>true,
			'menu_icon' => 'dashicons-awards',
			'labels' => array(
				'name' => 'Programs',
				'all_items'=>'All Programs',
				'edit_item'=> 'Edit Program',
				'singular_item'=>'Program',
				'add_new_item'=>'Add New Program',
				'not_found' => 'No Programs Found'
				)
			));
		// Professor Post Type
		register_post_type('professor', array(
			'show_in_rest' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'public' =>true,
			'menu_icon' => 'dashicons-welcome-learn-more',
			'labels' => array(
				'name' => 'Professors',
				'all_items'=>'All Professors',
				'edit_item'=> 'Edit Professor',
				'singular_item'=>'Professor',
				'add_new_item'=>'Add New Professor',
				'not_found' => 'No Professors Found'
				)
			));
		register_post_type('note', array(
			'capability_type' => 'note',
			'map_meta_cap' => true,
			'show_in_rest' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'public' =>false,
			'show_ui' => true,
			'menu_icon' => 'dashicons-welcome-write-blog',
			'labels' => array(
				'name' => 'Notes',
				'all_items'=>'All Notes',
				'edit_item'=> 'Edit Note',
				'singular_item'=>'Note',
				'add_new_item'=>'Add New Note',
				'not_found' => 'No Notes Found'
				)
			));
		//Campus Post Type
		register_post_type('campus', array(
			'supports' => array('title', 'editor', 'excerpt'),
			'rewrite' => array('slug' => 'campuses'),
			'has_archive' => true,
			'public' =>true,
			'menu_icon' => 'dashicons-location-alt',
			'labels' => array(
				'name' => 'Campuses',
				'all_items'=>'All Campuses',
				'edit_item'=> 'Edit Campus',
				'singular_item'=>'Campus',
				'add_new_item'=>'Add New Campus',
				'not_found' => 'No Campuses Found'
				)
			));



	}
	add_action('init', 'add_new_post_types');


 ?>