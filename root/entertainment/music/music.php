<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<title>
Music World
</title>

<link rel="icon" type="image/vnd.microsoft.icon" href="/images/allpirates.ico">
<link rel="stylesheet" href="/style.css" type="text/css" media="screen" />
<script src="/javascript/ddmenu.js" type="text/javascript"></script>
<script src="/javascript/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
            $(document).ready( function() {

				// Image hover effects and preview
				$("TABLE IMG").css({
					opacity: .5,
					cursor: 'pointer'
				})
				.attr('title', 'Click to view Pirates Playlist')
				.hover( function() {
					$(this).stop().css({ opacity: .5 }).animate({ opacity: 1 }, 250);
				}, function() {
					$(this).animate({ opacity: .5 }, 250);
				})
				.click( function() {

					$(this).clone().prependTo("#preview");

					$("#overlay").css({
						height: $(document).height(),
						opacity: .75
					})
					.fadeIn();

					$("#preview").css({
						top: (($(window).height() / 2) - (($("#preview").outerHeight() / 2)) + $(window).scrollTop()) + 'px',
						left: ($(window).width() / 2) - ($("#preview").outerWidth() / 2) + 'px'
					})
					.find('IMG')
						.css({
							opacity: 1
						})
						.attr('title', 'Click anywhere or press a key to close')
						.end()
					.fadeIn( function() {
						$(document).bind('click keypress', function() {
							$("#overlay").fadeOut();
							$("#preview").fadeOut( function() {
								$(this).find('IMG').remove();
								$(document).unbind('click keypress');
							});
						});
					});

				});

            });
</script>

</head>

<body>

<div id="container">

    <?php include("../../header.html"); ?>

    <?php include("../../menu.html"); ?>

	<div id="main_content">
	  <img src="/entertainment/music/images/musicpanel.png"></img></p>


		<div id="new_item">

			<div id="new_item_header">
			<h1>Michael Jackson</h1>
			<h2>All time Favorite</h2>
			</div>

			<div id="new_item_image">
			<img src="images/michael_jackson.png" width="153" height="180" alt="New Item Name" />
			</div>

			<div id="new_item_text">
				
				<p>Michael Jackson was the most successful and influential entertainer of all time. 
				   His Thriller Album holds the record of the best selling album selling over 110 million
				    copies world wide. He has sold more than 750 million copies till date and won the Guinness book
					of world record of being the "Most Successful Entertainer of All Time" along with 15 Grammy awards.</p> 
				
				<p>Michael also supported more charities than any other artist - 39 charitable organizations.
				His music and his dancing style have influenced millions including me. Michael's art will be
				  cherished and remembered forever.</p>
				
			</div>

			<div id="new_item_link">
			<a href="/entertainment/music/mj.php">.....View More</a>
			</div>

			<div class="clearthis">&nbsp;</div>
		</div>

		<!-- End of New Item Description -->


		<div class="h_divider">&nbsp;</div>


		<!-- Start of Sub Item Descriptions -->

		<div class="sub_items" style="width: 800px;">


			<!-- Start Left Sub Item -->

			<div  class="sub_left" style="width: 280px;">

				<div class="sub_items_header">
				<h1>Monster Lady Gaga</h1>
				<h2>Artist of Year</h2>
			  </div>

				<div class="sub_items_image">
				<img src="images/ladygaga.png" width="119" height="120" alt="Sub Item Name" />
				</div>

				<div class="sub_items_text">
					<p><a href="http://www.ladygaga.com">Lady Gaga</a> has a spectacular year with four singles from the same debut album <a href="http://www.ladygaga.com/discography/detail.aspx?pid=1620"><i>The Fame</i></a> reaching #1 on the Billboard charts.</p>

				</div>

				<div class="clearthis">&nbsp;</div>
		  </div>

			<!-- End of Left Sub Item -->

			<!-- Start Right Sub Item -->

			<div  class="sub_left" align="center" style="width: 250px; padding-left:15px; padding-right:15px;">
				<div class="sub_items_header">
				<h1>Miley Cyrus</h1>
				<h2>Rising Artist</h2>
				</div>

				<div class="sub_items_image">
				<img src="images/mileycyrus.png" width="110" height="120" alt="Sub Item Name" />
				</div>

				<div class="sub_items_text">
                <p>She released new album <a href="http://en.wikipedia.org/wiki/Can't_Be_Tamed"><i>Can't Be Tamed</i></a> as her 3rd studio album and had huge success on the singles like <a href="http://en.wikipedia.org/wiki/Party_in_the_U.S.A."><i>Party in the USA</i></a>, <a href="http://en.wikipedia.org/wiki/The_Climb_(song)"><i>The Climb</i></a> and <a href="http://en.wikipedia.org/wiki/Hannah_Montana:_The_Movie"><i>Hannah Montana Movie</i></a></p>.

				</div>

				<div class="clearthis">&nbsp;</div>
			</div>

			<div style="width:250;" align="right">
				<div>
		        <table align="right">
			     <tbody><tr>
				  <td>
  				  <a href="/entertainment/music/musiclist.php" target="_parent">
				  <img src="images/playlist.png" width="165" height="155" style="opacity: 0.5;"  alt="Pirates Playlist" />
  				  </a>
				  </td>
			     </tr></tbody>
				</table>
				</div>
			</div>

			<!-- End of Right Sub Item -->

			<div class="clearthis">&nbsp;</div>
	  </div>

		<!-- End of Sub Item Descriptions -->

      <p>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
	  <div class="clearthis">&nbsp;</div>
  </div>
				<div class="clearthis">&nbsp;</div>


    <?php include("../../footer.html"); ?>
</div>

</body>
</html>