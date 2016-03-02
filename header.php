<?php
  if(isset($_GET["logout"])){

    session_unset();
    session_destroy();

    header("Location: login.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Resume of Richard Aasa">
<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">
<meta name="author" content="Richard Aasa">
<title>Richard Aasa</title>
<link rel="stylesheet" href="css/md-css.min.css">
<link rel="stylesheet" href="css/md-icons.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="stylesheet" href="fonts.css">
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
function initialize() {
  var mapProp = {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:11,
    center: {lat: 59.414408, lng: 24.727170},
    mapTypeId:google.maps.MapTypeId.ROADMAP,
    styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#4f595d"},{"visibility":"on"}]}]};
  var map=new google.maps.Map(document.getElementById("Map"),mapProp);

  var marker = new google.maps.Marker({
    position: {lat: 59.414408, lng: 24.727170},
    map: map
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>
<body material fluid>
  <div panel id="panel1">
    <div drawer bg-blue-grey900>
      <div list>
        <a item href="index.php"><span icon="home"></span>Home</a>
        <a item href="blog.php"><span icon="announcement"></span>Blog</a>
        <a item href="#"><span icon="event"></span>Calendar</a>
      </div>
    </div>
    <!-- end of drawer -->
    <div id="0" main bg-none>
      <div toolbar seamed bg-blue-grey400 >
        <span left panel-target="panel1">
          <span icon="menu"></span>
        </span>
        <header title style="font-size: 30px; padding-left: 8px">Richard Aasa</header>

        <a href="#"><i class="social-github"></i></a>
        <a href="#"><i class="social-twitter3"></i></a>
        <a href="#"><i class="social-google-plus3"></i></a>
        <a href="login.php"><span icon="lock-open"></span></a>
      </div>
      <div bg-blue-grey200 class="cover"></div>
      <div content id="content">
