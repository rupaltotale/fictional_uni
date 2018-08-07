<?php 
$userID = sanitize_text_field($_REQUEST['profID']);
$metakey = sanitize_text_field($_REQUEST['metakey']);
$metavalue =  sanitize_text_field($_REQUEST['metavalue']);
update_usermeta( $profID, $metakey, $metavalue );

 ?>