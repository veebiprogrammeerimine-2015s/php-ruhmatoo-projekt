<script>

$(document).ready(function() {

 var docHeight = $(window).height();
 var footerHeight = $('.page-footer').height();
 var footerTop = $('.page-footer').position().top + footerHeight;

 if (footerTop < docHeight) {
  $('.page-footer').css('margin-top', 1+ (docHeight - footerTop) + 'px');
 }
});
</script>

<div class="page-footer">

  <div class="row">
	  <div class="col-xs-6 col-md-3 col-md-offset-1">Something interesting</div>
	  <div class="col-xs-6 col-md-3">Telefoni nr</div>
	  <div class="col-xs-6 col-md-3">info@ratemypro.ee</div>

  <ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="#">Back to top</a></li>
  </ul>

  </div>


  <div class="row">
	  <div class="col-xs-6 col-md-3 col-md-offset-1">RateMyPro OY</div>
	  <div class="col-xs-6 col-md-3">Olematu mnt 112b</div>
	  <div class="col-xs-6 col-md-3">info@ratemypro.ee</div>


  </div>
</div>

</div>
</body>
