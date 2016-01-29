var xmlhttp = new XMLHttpRequest();
var url = "posts.php";

xmlhttp.onreadystatechange=function() {
  if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    printPosts(xmlhttp.responseText);
  }
}
xmlhttp.open("GET", url, true);
xmlhttp.send();

function printPosts(response) {
  var arr = JSON.parse(response);
  var i;
  var out = " ";

  for(i = 0; i < arr.length; i++) {
    out += '<div ' + arr[i].color + ' card z-1 class="blog-card">'
    + '<div class="card-info" ' + arr[i].color + '>'
    + arr[i].postDate + ' - ' + arr[i].postTag + '</div>'
    + '<img src="http://lorempixel.com/960/480/sports/" alt="">'
    + '<h3 ' + arr[i].color + '>' + arr[i].postTitle + '</h3>'
    + '<div class="card-body">' + arr[i].postDesc
    + '<a button fg-black href="#">read more</a>'
    + '</div></div>'
  }

  $('div[page-title="Blog"]').html(out);
}
