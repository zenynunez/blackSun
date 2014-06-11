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
			<?php if($_SERVER['REQUEST_URI'] === '/'){?>
				<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js'></script>
				<script type="text/javascript" src='http://cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js'></script>
				<script type="text/javascript">
					(function($){
						var access_token = '220451675.1fb234f.36e1b4878a8e4f34859b7a46c71736d8';
    					var userId       = '220451675';
    					var urlInstagram = 'https://api.instagram.com/v1/users/'+userId+'/media/recent/?access_token='+access_token+'&count=18&callback=JSON_CALLBACK';

    					$.ajax({
    						type: "GET",
    						dataType: "jsonp",
    						cache: false,
    						url: urlInstagram,
    						success: function(instagram_data){
    							var instagram_feed = _.map(instagram_data.data,function(data_instagram){  
        							var data_obj = {'link':data_instagram.link,'image':data_instagram.images.standard_resolution.url};
        							return data_obj;
      							});
      							var i = 3;
      							 _.forEach(instagram_feed,function(img_feed){
      							 	if(instagram_feed.indexOf(img_feed) === i){
      							 		console.log(instagram_feed.indexOf(img_feed));
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='376'></div>");
      							 		i = 10;
      							 	}
      							 	else{
      							 		$('.insta').append("<div class='instapic'><img src='"+img_feed.image+"' width='188'></div>");
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
					})(jQuery);
				</script>
				<style type="text/css">
					.insta-tittle span{
						color : #f7ed34;
					}
				</style>
				<div class="row-fluid">
					<div class="span-12">
						<h1 class="insta-tittle">#BLACKSUN<span>STORE</span></h1>
						<div class="insta" id="insta">

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