<?php
add_action('rest_api_init', 'universityRegisterSearch');
function universityRegisterSearch() {
	register_rest_route('university/v1', 'search', array('methods' => WP_REST_SERVER::READABLE, 'callback' => 'universitySearchResults',));
}
function addRelatedPrograms() {
    // Related programs accessed and added to program stack
	$relatedPrograms = get_field('related_programs');
	if ($relatedPrograms) {
		foreach ($relatedPrograms as $relatedProgram) {
			$permalink = get_the_permalink($relatedProgram);
			if (!is_in_array($allPostTypesObject['programs'], 'permalink', $permalink)) {
				array_push($allPostTypesObject['programs'], array('title' => get_the_title($relatedProgram), 'permalink' => get_the_permalink($relatedProgram),));
			}
		}
	}
}
function universitySearchResults($data) {
    // $professorItems = array();
    // $generalInfoItems = array();
    // $eventItems = array();
    // $campusItems = array();
    // $programItems = array();
	$allPostTypesObject = array('professors' => array(), 'generalInfo' => array(), 'events' => array(), 'campuses' => array(), 'programs' => array(),);
	$searchQuery = new WP_Query(array('posts_per_page' => - 1, 'post_type' => array('professor', 'page', 'post', 'event', 'campus', 'program'), 's' => sanitize_text_field($data['term'])));
	while ($searchQuery->have_posts()) {
		$searchQuery->the_post();

		// ****************** RELATED PROGRAMS!!!
		$relatedPrograms = get_field('related_programs');
		if ($relatedPrograms) {
			foreach ($relatedPrograms as $relatedProgram) {
				$permalink = get_the_permalink($relatedProgram);
				if (!is_in_array($allPostTypesObject['programs'], 'permalink', $permalink)) {
					array_push($allPostTypesObject['programs'], array('title' => get_the_title($relatedProgram), 'permalink' => get_the_permalink($relatedProgram),));
				}
			}
		}
		$array = array('title' => get_the_title(), 'permalink' => get_the_permalink(),);
		if (get_post_type() == 'professor') {
			$array['imageURL'] = get_the_post_thumbnail_url(0, 'landscape');
			$permalink = get_the_permalink();
			if (!is_in_array($allPostTypesObject['professors'], 'permalink', $permalink)) {
				array_push($allPostTypesObject['professors'], $array);
			}
		}
		if (get_post_type() == 'page' or get_post_type() == 'post') {
			if (get_post_type() == 'post') {
				$array['author'] = get_the_author();
			}
			array_push($allPostTypesObject['generalInfo'], $array);
		}
		if (get_post_type() == 'event') {
			$eventDate = new DateTime(get_field('event_date'));
			$eventMonth = $eventDate->format('M');
			$eventDay = $eventDate->format('d');
			if (has_excerpt()) {
				$array['excerpt'] = get_the_excerpt();
			} else {
				$array['excerpt'] = wp_trim_words(get_the_content(), 20);
			}
			$array['month'] = $eventMonth;
			$array['day'] = $eventDay;
			$permalink = get_the_permalink();
			if (!is_in_array($allPostTypesObject['events'], 'permalink', $permalink)) {
				array_push($allPostTypesObject['events'], $array);
			}
			
		}
		if (get_post_type() == 'campus') {
			$permalink = get_the_permalink();
			if (!is_in_array($allPostTypesObject['campuses'], 'permalink', $permalink)) {
				array_push($allPostTypesObject['campuses'], $array);
			}
		}
		if (get_post_type() == 'program') {
			$ID = get_the_ID();
			$permalink = get_the_permalink();
			if (!is_in_array($allPostTypesObject['programs'], 'permalink', $permalink)) {
				array_push($allPostTypesObject['programs'], $array);
			}
            // *** Professors that teach this subject
			$professors = new WP_Query(array(
				'posts_per_page' => - 1, 
				'post_type' => 'professor', 
				'orderby' => 'title',
            // 'orderby' => 'meta_value_num',
				'order' => 'ASC', 'meta_query' => array(array('key' => 'related_programs', 'compare' => 'LIKE', 'value' => '"' . $ID . '"',))));
			if ($professors->have_posts()) {
				while ($professors->have_posts()) {
					$professors->the_post();
					$permalink = get_the_permalink();
					if (!is_in_array($allPostTypesObject['professors'], 'permalink', $permalink)) {
						array_push($allPostTypesObject['professors'], array('title' => get_the_title(), 'permalink' => get_the_permalink(), 'imageURL' => get_the_post_thumbnail_url(0, 'landscape')));
					}
				}
			}
			wp_reset_postdata();

            // *** Campuses that teach this subject
			$campuses = new WP_Query(array('posts_per_page' => - 1, 'post_type' => 'campus', 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array(array('key' => 'related_programs', 'compare' => 'LIKE', 'value' => '"' . $ID . '"',))));
			if ($campuses->have_posts()) {
				while ($campuses->have_posts()) {
					$campuses->the_post();
					$permalink = get_the_permalink();
					if (!is_in_array($allPostTypesObject['campuses'], 'permalink', $permalink)) {
						array_push($allPostTypesObject['campuses'], array('title' => get_the_title(), 'permalink' => get_the_permalink(),));
					}
				}
			}

			// *** Events that are related to this subject
			$events = new WP_Query(array('posts_per_page' => - 1, 'post_type' => 'event', 'orderby' => 'title', 'order' => 'ASC', 'meta_query' => array(array('key' => 'related_programs', 'compare' => 'LIKE', 'value' => '"' . $ID . '"',))));
			if ($events->have_posts()) {
				while ($events->have_posts()) {
					$events->the_post();
					$permalink = get_the_permalink();
					if (!is_in_array($allPostTypesObject['events'], 'permalink', $permalink)) {
						$eventDate = new DateTime(get_field('event_date'));
						$eventMonth = $eventDate->format('M');
						$eventDay = $eventDate->format('d');
						if (has_excerpt()) {
							$excerpt = get_the_excerpt();
						} else {
							$excerpt = wp_trim_words(get_the_content(), 20);
						}
						array_push($allPostTypesObject['events'], array(
							'title' => get_the_title(), 
							'permalink' => get_the_permalink(),
							'excerpt' => $excerpt,
							'month' => $eventMonth,
							'day' => $eventDay,
							));
					}
				}
			}
		}
	}
	return $allPostTypesObject;
}
function is_in_array($array, $key, $key_value) {
	$within_array = false;
	foreach ($array as $k => $v) {
		if (is_array($v)) {
			$within_array = is_in_array($v, $key, $key_value);
			if ($within_array == true) {
				return true;
			}
		} else {
			if ($v == $key_value && $k == $key) {
				$within_array = true;
				return true;
			}
		}
	}
	return $within_array;
}
