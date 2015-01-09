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
							$(this).addClass('open');
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
							$('.instapic').removeClass('open');
							$(this).fadeOut();
						});

						$('body').on('click', '.insta-content', function (event) {
							event.stopPropagation();
						});

						$('body').on('click', '.close-btn', function (event) {
							event.stopPropagation();
							$('.instapic').removeClass('open');
							$('.insta-modal').fadeOut();
						});

						$('body').on('click','.loadMore', function(){
							var container = document.querySelector('#insta');
							
							$.ajax({
    							type: "GET",
    							dataType: "jsonp",
    							cache: false,
    							url: nextUrl,
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
						});
						
						$('body').on('click','.prev-img', function(event){
							event.stopPropagation();
							var prev = $('.open').prev();
							$('.instapic').removeClass('open');
							if(prev.attr('class') === undefined){
								$('.instapic').removeClass('open');
								$('.insta-modal').fadeOut();
							}else{
								$(prev).addClass('open');
								var srcImg    = $(prev).find('img').attr('src'),
							    	userName  = $(prev).find('img').attr('data-user'),
							    	userLikes = $(prev).find('img').attr('data-likes'),
							    	instalink = $(prev).find('img').attr('data-instalink');

								$('.insta-likes').empty().append(userLikes);
								$('.insta-user').empty().append('<a href="'+instalink+'" target="_blank">'+userName+'</a>');
								$('.insta-modal').height(window.innerHeight).fadeIn();
								$('.insta-content').width(window.innerWidth * 0.40);
								$('.img-container').empty().append('<img src="'+srcImg+'">');
							}
						});

						$('body').on('click','.next-img', function(event){
							event.stopPropagation();
							var next = $('.open').next();
							$('.instapic').removeClass('open');
							if(next.attr('class') === undefined){
								$('.instapic').removeClass('open');
								$('.insta-modal').fadeOut();
							}else{
								$(next).addClass('open');
								var srcImg    = $(next).find('img').attr('src'),
							    	userName  = $(next).find('img').attr('data-user'),
							    	userLikes = $(next).find('img').attr('data-likes'),
							    	instalink = $(next).find('img').attr('data-instalink'),
							    	instatext = $(next).find('img').attr('data-instatext');

								if(instatext === undefined){
									instatext = 'Blacksunstore';
								}

								$('.insta-likes').empty().append(userLikes);
								$('.insta-user').empty().append('<a href="'+instalink+'" target="_blank">'+instatext+'</a>');
								$('.insta-modal').height(window.innerHeight).fadeIn();
								$('.insta-content').width(window.innerWidth * 0.40);
								$('.img-container').empty().append('<img src="'+srcImg+'">');
							}
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
						margin   : 5% auto 0 auto; 
						position : relative; 
					}
					.insta-modal .insta-content .insta-footer{
						width       : 96.5%;
						height      : 30px;
						background  : rgba(0,0,0,.7);  
						color       : white;  
						font-size   : 20px; 
						top         : -50px;
						position    : relative;
						padding     : 10px; 
						overflow    : hidden; 
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
						cursor     : pointer; 
						text-align : center; 
						margin-top : 10px; 
					}
					.loadMore p{
						border     : 1px solid #000;
						cursor     : pointer; 
						width      : 265px;
						text-align : center; 
						margin     : 0 auto;
						padding    : 5px 15px;  
						font-size  : 1.7em; 
						color      : #000;
					}
					.loadMore p:hover{
						color        : #f7ed34;
						background   : rgba(0,0,0,0.7); 
					}
					.cf:before,
					.cf:after {
    					content : " "; /* 1 */
    					display	: table; /* 2 */
					}
					.cf:after {
    					clear : both;
					}
					.close-btn{
						position      : absolute;
						right         : -15px;
						color         : #f7ed34;  
						font-size     : 27px;
						top           : -30px;
						cursor        : pointer; 
						border-top    : 15px solid transparent;
						border-bottom : 15px solid transparent;
						border-right  : 60px solid #000; 
					}
					.close-btn p{
						position : relative;
						right    : -38px; 
						margin   : 0;
					}
					.insta-footer i{
						color : red;
					}
					.next-img{
						position  : absolute;
						right     : 30px;
						top       : 45%; 
						color     : #f7ed34;
						cursor    : pointer;   
					}
					.prev-img{
						position  : absolute;
						left      : 30px;
						top       : 45%;  
						color     : #f7ed34; 
						cursor    : pointer; 
					}
				</style>
				<div class="row-fluid">
					<div class="span-12 mega-cont">
						<h1 class="insta-tittle">#Nuestros<span>Clientes</span></h1>
						<div class="insta cf" id="insta">

						</div>
						<div class="loadMore">
							<p>VER + #BLACKSUNSTORE</p>
						</div>
					</div>	
				</div>
				<div class="insta-modal">
					<div class="insta-content">
						<div class="close-btn">
							<p>x</p>
						</div>
						<div class="img-container"></div>
						<div class="insta-footer">
							<span>
								<span class="insta-likes"></span>
								<i class="fa fa-heart"></i>
							</span>
							<span>-</span>
							<span class="insta-user"></span>
						</div>
					</div>	
					<div class="next-img"><i class="fa fa-angle-right fa-5x"></i></div>
					<div class="prev-img"><i class="fa fa-angle-left fa-5x"></i></div>
				</div>

    						
			<?php } ?>
		</div><!-- end row-fluid -->











		</div><!-- end row-fluid -->

	</div>
</div><!-- end container -->

<?php
	get_footer();
?>