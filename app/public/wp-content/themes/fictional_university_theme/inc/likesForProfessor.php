<?php 
add_action('rest_api_init', 'universityRegisterLikesForProfessorURL');
function universityRegisterLikesForProfessorURL() {
	register_rest_route('university/v1', 'prof', array(
		'methods' => array('GET', 'POST'), 
		'callback' => 'universityCustomProf',));
}

function universityCustomProf($prof) {
	$professor = get_post( $prof['ID'] );
	$professorDetails = array(
		array(
			'userLikesArray' => get_post_meta($prof['ID'], 'userLikesArray'),
			'title' => get_the_title($prof['ID']),
			)
		);
	return get_post_meta($prof['ID'], 'userLikesArray');

}



?>