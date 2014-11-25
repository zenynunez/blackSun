<?php 
	get_header();
?>

<?php 
	extract(etheme_get_page_sidebar());
?>

<?php if ($page_heading != 'disable' && ($page_slider == 'no_slider' || $page_slider == '')): ?>
	<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
		<div class="container">
			<div class="row-fluid">
				<div class="span12 a-center">
					<h1 class="title"><span><?php the_title(); ?></span></h1>
					<?php etheme_breadcrumbs(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif ?>

<?php if($page_slider != 'no_slider' && $page_slider != ''): ?>
	
	<?php echo do_shortcode('[rev_slider_vc alias="'.$page_slider.'"]'); ?>

<?php endif; ?>

<div class="container">
	<div class="page-content sidebar-position-<?php echo $position; ?> responsive-sidebar-<?php echo $responsive; ?>">
		<div class="row-fluid">
			<?php if($position == 'left' || ($responsive == 'top' && $position == 'right')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-left">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>
			
			<div class="content <?php echo $content_span; ?>">
				<?php if(have_posts()): while(have_posts()) : the_post(); ?>
					
					<?php the_content(); ?>

					<div class="post-navigation">
						<?php wp_link_pages(); ?>
					</div>
					
					<?php if ($post->ID != 0 && current_user_can('edit_post', $post->ID)): ?>
						<?php edit_post_link( __('Edit this', ETHEME_DOMAIN), '<p class="edit-link">', '</p>' ); ?>
					<?php endif ?>

				<?php endwhile; else: ?>

					<h3><?php _e('No pages were found!', ETHEME_DOMAIN) ?></h3>

				<?php endif; ?>

			</div>

			<?php if($position == 'right' || ($responsive == 'bottom' && $position == 'left')): ?>
				<div class="<?php echo $sidebar_span; ?> sidebar sidebar-right">
					<?php etheme_get_sidebar($sidebarname); ?>
				</div>
			<?php endif; ?>
			
			<?php if($_SERVER['REQUEST_URI'] === '/comentarios-de-clientes/'){?>
				<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
				<script type="text/javascript">
					(function($){
						var access_token = '220451675.1fb234f.3575f1c2ff024ad2b8256067897463ba';
    					var userId       = '220451675';
    					var urlInstagram = 'https://api.instagram.com/v1/tags/blacksunstore/media/recent?access_token='+access_token+'&count=20&callback=JSON_CALLBACK';
    					var nextUrl      = undefined;
   
    					$.ajax({
    						type: "GET",
    						dataType: "jsonp",
    						cache: false,
    						url: urlInstagram,
    						success: function(instagram_data){
    							nextUrl = instagram_data.pagination.next_url;
    							var instagram_feed = _.map(instagram_data.data,function(data_instagram){ 
        							var data_obj = {
        								'link'     : data_instagram.link,
        								'image'    : data_instagram.images.standard_resolution.url,
        								'likes'    : data_instagram.likes.count,
        								'user'     : data_instagram.user.full_name,
        								'imgLink'  : data_instagram.link,
        								'profileP' : data_instagram.user.profile_picture
        							};
        							return data_obj;
      							});
      							var i = 3;
      							 _.forEach(instagram_feed,function(img_feed){
      							 	$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='"+ $('.mega-cont').width() / 5 +"' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'><div class='overlay'> <span class='text-wrapper'> <img src='"+img_feed.profileP+"' width='50px'/> <span class='overlay-name'>"+img_feed.user+"</span> <span> </div></div>");	
      							});
      							$('.overlay').height($('.mega-cont').width() / 5).css('margin-top',-($('.mega-cont').width() / 5)).hide();
      						}
      					});

						$('body').on({
    						mouseenter: function () {
        						$(this).find('.overlay').fadeIn();
    						},
    						mouseleave: function () {
        						$(this).find('.overlay').fadeOut();
    						}
                        }, ".instapic");

						$('body').on('click', '.instapic', function () {
							var srcImg    = $(this).find('img').attr('src'),
							    userName  = $(this).find('img').attr('data-user'),
							    userLikes = $(this).find('img').attr('data-likes'),
							    instalink = $(this).find('img').attr('data-instalink');

							$('.insta-likes').empty().append(userLikes);
							$('.insta-user').empty().append('<a href="'+instalink+'" target="_blank">'+userName+'</a>');
							$('.insta-modal').height(window.innerHeight).fadeIn();
							$('.insta-content').width(window.innerWidth * 0.40);
							$('.img-container').empty().append('<img src="'+srcImg+'">');
						});

						$('body').on('click', '.insta-modal', function (event) {
							event.stopPropagation();
							$(this).fadeOut();
						});

						$('body').on('click','.loadMore', function(){
							var container = document.querySelector('#insta');
							var msnry = Masonry.data(container);
							
							$.ajax({
    							type: "GET",
    							dataType: "jsonp",
    							cache: false,
    							url: nextUrl,
    							success: function(instagram_data){
    								console.log(instagram_data);
    								nextUrl = instagram_data.pagination.next_url;
    								var instagram_feed = _.map(instagram_data.data,function(data_instagram){ 
        								var data_obj = {
        								'link'     : data_instagram.link,
        								'image'    : data_instagram.images.standard_resolution.url,
        								'likes'    : data_instagram.likes.count,
        								'user'     : data_instagram.user.full_name,
        								'imgLink'  : data_instagram.link,
        								'profileP' : data_instagram.user.profile_picture
        							};
        								return data_obj;
      								});
      								var i = 3;
      							 	_.forEach(instagram_feed,function(img_feed){
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='"+ $('.mega-cont').width() / 5 +"' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'><div class='overlay'> <span class='text-wrapper'> <img src='"+img_feed.profileP+"' width='50px'/> <span class='overlay-name'>"+img_feed.user+"</span> <span> </div></div>");	
      								});
      								$('.overlay').height($('.mega-cont').width() / 5).css('margin-top',-($('.mega-cont').width() / 5)).hide();
      							}
      						});
						});

					})(jQuery);
				</script>
				<style type="text/css">
					.insta-tittle span{
						color : #f7ed34;
					}
					.instapic{
						cursor : pointer; 
						float  : left; 
					}
					.insta-modal{
						background : rgba(0,0,0,0.7); 
						position   : fixed;
						width      : 100%;
						left       : 0;
						top        : 0;
						display    : none; 
						z-index    : 99999;
					}
					.insta-modal .insta-content{
						margin : 5% auto 0 auto; 
					}
					.insta-modal .insta-content .insta-footer{
						width       : 100%;
						height      : 40px;
						background  : rgba(0,0,0,.7);  
						color       : white;  
						font-size   : 20px; 
						top         : -50px;
						position    : relative;
						padding-top : 10px;
					}
					.insta-modal .insta-content .insta-footer a{
						color           : #fff;
						text-decoration : none;
					}
					.insta-modal img{
						display : block;
						width   : 100%;  
					}
					.insta .overlay{
						background : rgba(0,0,0,0.7); 
						position   : relative;  
					}
					.insta .overlay-name{
						color       : white;
						margin-left : 5px;  
					}
					.insta .text-wrapper{
						top      : 70%;
						position : relative;
						left     : 10%;
					}
					.insta img:hover{
						opacity : 1;
					}
					.insta img{
						opacity : 1;
					}
					.loadMore{
						cursor : pointer;
						border : 1px solid #000;  
					}
					.cf:before,
					.cf:after {
    					content : " "; /* 1 */
    					display	: table; /* 2 */
					}
					.cf:after {
    					clear : both;
					}
				</style>
				<div class="row-fluid">
					<div class="span-12 mega-cont">
						<h1 class="insta-tittle">#BLACKSUN<span>STORE</span></h1>
						<div class="insta cf" id="insta">

						</div>
						<div class="loadMore">
							<p>Load More</p>
						</div>
					</div>	
				</div>
				<div class="insta-modal">
					<div class="insta-content">
						<div class="img-container"></div>
						<div class="insta-footer">
							<span>
								<i class="fa fa-heart"></i>
								<span class="insta-likes"></span>
							</span>
							<span class="insta-user"></span>
						</div>
					</div>	
				</div>
			<?php } ?>

			<?php if($_SERVER['REQUEST_URI'] === '/'){?>
				<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js'></script>
				<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
				<script type="text/javascript">
					(function($){
						var access_token = '220451675.1fb234f.3575f1c2ff024ad2b8256067897463ba';
    					var userId       = '220451675';
    					var urlInstagram = 'https://api.instagram.com/v1/users/'+userId+'/media/recent/?access_token='+access_token+'&count=18&callback=JSON_CALLBACK';

    							$.ajax({
    						type: "GET",
    						dataType: "jsonp",
    						cache: false,
    						url: urlInstagram,
    						success: function(instagram_data){
    							console.log(instagram_data);
    							nextUrl = instagram_data.pagination.next_url;
    							var instagram_feed = _.map(instagram_data.data,function(data_instagram){ 
        							var data_obj = {
        								'link'    : data_instagram.link,
        								'image'   : data_instagram.images.standard_resolution.url,
        								'likes'   : data_instagram.likes.count,
        								'user'    : data_instagram.user.full_name,
        								'imgLink' : data_instagram.link
        							};
        							return data_obj;
      							});
      							var i = 3;
      							 _.forEach(instagram_feed,function(img_feed){
      							 	if(instagram_feed.indexOf(img_feed) === i){
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='376' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'></div>");
      							 		i = 10;
      							 	}
      							 	else{
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='188' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'></div>");
      							 	}
      							});

      							 var $container = $('#insta');
								// initialize
								setTimeout(function() {
									$container.masonry({
  										itemSelector: '.instapic'
									});
								}, 500);
      						}
      					});

						$('body').on('click', '.instapic', function () {
							var srcImg    = $(this).find('img').attr('src'),
							    userName  = $(this).find('img').attr('data-user'),
							    userLikes = $(this).find('img').attr('data-likes');
							    instalink = $(this).find('img').attr('data-instalink');

							$('.insta-likes').empty().append(userLikes);
							$('.insta-user').empty().append('<a href="'+instalink+'" target="_blank">'+userName+'</a>');
							$('.insta-modal').height(window.innerHeight).fadeIn();
							$('.insta-content').width(window.innerWidth * 0.40);
							$('.img-container').empty().append('<img src="'+srcImg+'">');
						});

						$('body').on('click', '.insta-modal', function (event) {
							event.stopPropagation();
							$(this).fadeOut();
						});

						$('.loadMore').on('click',function(){
							console.log('dddsd');
							$.ajax({
    						type: "GET",
    						dataType: "jsonp",
    						cache: false,
    						url: nextUrl,
    						success: function(instagram_data){
    							console.log(instagram_data);
    							nextUrl = instagram_data.pagination.next_url;
    							var instagram_feed = _.map(instagram_data.data,function(data_instagram){ 
        							var data_obj = {
        								'link'    : data_instagram.link,
        								'image'   : data_instagram.images.standard_resolution.url,
        								'likes'   : data_instagram.likes.count,
        								'user'    : data_instagram.user.full_name,
        								'imgLink' : data_instagram.link
        							};
        							return data_obj;
      							});
      							var i = 3;
      							 _.forEach(instagram_feed,function(img_feed){
      							 	if(instagram_feed.indexOf(img_feed) === i){
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='376' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'></div>");
      							 		i = 10;
      							 	}
      							 	else{
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='188' data-likes='"+img_feed.likes+"' data-user='"+img_feed.user+"' data-instalink='"+img_feed.link+"'></div>");
      							 	}
      							});

      							 var $container = $('#insta');
								// initialize
								setTimeout(function() {
									$container.masonry({
  										itemSelector: '.instapic'
									});
								}, 500);
      						}
      					});
						});

					})(jQuery);
				</script>
				<style type="text/css">
					.insta-tittle span{
						color : #f7ed34;
					}
					.instapic{
						cursor : pointer; 
					}
					.insta-modal{
						background : rgba(0,0,0,0.7); 
						position   : fixed;
						width      : 100%;
						left       : 0;
						top        : 0;
						display    : none; 
						z-index    : 99999;
					}
					.insta-modal .insta-content{
						margin : 5% auto 0 auto; 
					}
					.insta-modal .insta-content .insta-footer{
						width       : 100%;
						height      : 40px;
						background  : rgba(0,0,0,.7);  
						color       : white;  
						font-size   : 20px; 
						top         : -50px;
						position    : relative;
						padding-top : 10px;
					}
					.insta-modal .insta-content .insta-footer a{
						color           : #fff;
						text-decoration : none;
					}
					.insta-modal img{
						display : block;
						width   : 100%;  
					}
				
				</style>
				<div class="row-fluid">
					<div class="span-12">
						<h1 class="insta-tittle">#BLACKSUN<span>STORE</span></h1>
						<div class="insta" id="insta">

						</div>
						<p class="loadMore">Load More</p>
					</div>	
				</div>
				<div class="insta-modal">
					<div class="insta-content">
						<div class="img-container"></div>
						<div class="insta-footer">
							<span>
								<i class="fa fa-heart"></i>
								<span class="insta-likes"></span>
							</span>
							<span class="insta-user"></span>
						</div>
					</div>	
				</div>
			<?php } ?>
		</div><!-- end row-fluid -->

	</div>
</div><!-- end container -->

<?php
	get_footer();
?>