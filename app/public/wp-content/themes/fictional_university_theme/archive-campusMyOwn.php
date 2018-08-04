<?php get_header();
banner(array(
  "title" => "All Campuses",
  "subtitle" => "We have several conveniently located campuses.",
  "background_image" => get_theme_file_uri('images/ocean.jpg')
  ));
  ?>

  <?php 
  $lats = 0;
  $lngs = 0;
  $numberOfLocs = 0;
  while(have_posts()){
   the_post();
   $location = get_field('map_location');
   $lats = $lats + $location['lat'];
   $lngs = $lngs + $location['lng'];
   $numberOfLocs = $numberOfLocs + 1; }
   $centerLat = $lats/$numberOfLocs;
   $centerLng = $lngs/$numberOfLocs;


   ?>
   <div class="container container--narrow page-section">

     <div id="map" style="width:100%;height:400px;background:white;"></div>
     <script>
      function initMap() {

        var center = {lat: <?php echo $centerLat ?>, lng: <?php echo $centerLng ?>};
        var bounds = new google.maps.LatLngBounds();
        var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 10, center: center});
        <?php 
        while(have_posts()){
         the_post();
         $location = get_field('map_location');
         $lat = $location['lat'];
         $lng = $location['lng'];

         ?>

         var markerCords = {lat: <?php echo $location['lat'] ?>, lng: <?php echo $location['lng'] ?>};

         var marker = new google.maps.Marker({position: markerCords, map: map});

         var latlng = new google.maps.LatLng( <?php echo $location['lat'] ?>, <?php echo $location['lng'] ?> );

      bounds.extend( latlng );

           
    
    <?php } ?>
    map.fitBounds( bounds );
  }
  </script>

  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARvnayzLUq45FnVHAjYLDmV8XgZQiFDAk&callback=initMap">
</script>
</div>



<?php 

get_footer() ?>