<?php
	// Loads child theme textdomain
	load_child_theme_textdomain( CURRENT_THEME, CHILD_DIR . '/languages' );

	// Loads custom scripts.
	// require_once( 'custom-js.php' );

	require_once('my_script.php');

	add_filter( 'cherry_slider_params', 'child_slider_params' );
		function child_slider_params( $params ) {
		    $params['minHeight'] = '"100px"';
		    $params['height'] = '"70.33%"';
		return $params;
		}

	// Custom inner row
	if (!function_exists('row_custom_shortcode')) {
		function row_custom_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
		'custom_class' => '',
		), $atts));
		$output = '<div class="row '.$custom_class.'">'.do_shortcode($content).'</div>';
		return $output;
		}
		add_shortcode('row_custom', 'row_custom_shortcode');
	}

	// Extra Wrap
	if (!function_exists('extra_wrap_shortcode')) {
		function extra_wrap_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
		'custom_class' => '',
		), $atts));
		$output = '<div class="extra-wrap '.$custom_class.'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
		}
		add_shortcode('extra_wrap', 'extra_wrap_shortcode');
	}

	// Custom Extra Wrap
	if (!function_exists('extra_wrap_inner_shortcode')) {
		function extra_wrap_inner_shortcode($atts, $content = null) {
		extract(shortcode_atts(array(
		'custom_class' => '',
		), $atts));
		$output = '<div class="extra-wrap-inner '.$custom_class.'">';
		$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
		}
		add_shortcode('extra_wrap_inner', 'extra_wrap_inner_shortcode');
	}

	add_filter( 'cherry_stickmenu_selector', 'cherry_change_selector' );
		function cherry_change_selector($selector) {
		$selector = 'header .custom_poz';
		return $selector;
	}

	// Add the postmeta to Clients
    require_once('theme-clientsmeta.php');


	// Loads custom scripts.
	// require_once( 'custom-js.php' );

	//Recent Posts
	if (!function_exists('shortcode_recent_posts')) {

		function shortcode_recent_posts( $atts, $content = null, $shortcodename = '' ) {
			extract(shortcode_atts(array(
					'type'             => 'post',
					'category'         => '',
					'custom_category'  => '',
					'tag'              => '',
					'post_format'      => 'standard',
					'num'              => '5',
					'meta'             => 'true',
					'thumb'            => 'true',
					'thumb_width'      => '120',
					'thumb_height'     => '120',
					'more_text_single' => '',
					'excerpt_count'    => '0',
					'custom_class'     => ''
			), $atts));

			$output = '<ul class="recent-posts-cust '.$custom_class.' unstyled">';

			global $post;
			global $my_string_limit_words;
			$item_counter = 0;
			// WPML filter
			$suppress_filters = get_option('suppress_filters');

			if($post_format == 'standard') {

				$args = array(
							'post_type'         => $type,
							'category_name'     => $category,
							'tag'               => $tag,
							$type . '_category' => $custom_category,
							'numberposts'       => $num,
							'orderby'           => 'post_date',
							'order'             => 'DESC',
							'tax_query'         => array(
							'relation'          => 'AND',
								array(
									'taxonomy' => 'post_format',
									'field'    => 'slug',
									'terms'    => array('post-format-aside', 'post-format-gallery', 'post-format-link', 'post-format-image', 'post-format-quote', 'post-format-audio', 'post-format-video'),
									'operator' => 'NOT IN'
								)
							),
							'suppress_filters' => $suppress_filters
						);

			} else {

				$args = array(
					'post_type'         => $type,
					'category_name'     => $category,
					'tag'               => $tag,
					$type . '_category' => $custom_category,
					'numberposts'       => $num,
					'orderby'           => 'post_date',
					'order'             => 'DESC',
					'tax_query'         => array(
					'relation'          => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => array('post-format-' . $post_format)
						)
					),
					'suppress_filters' => $suppress_filters
				);
			}

			$latest = get_posts($args);

			foreach($latest as $k => $post) {
					//Check if WPML is activated
					if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
						global $sitepress;

						$post_lang = $sitepress->get_language_for_element($post->ID, 'post_' . $type);
						$curr_lang = $sitepress->get_current_language();
						// Unset not translated posts
						if ( $post_lang != $curr_lang ) {
							unset( $latest[$k] );
						}
						// Post ID is different in a second language Solution
						if ( function_exists( 'icl_object_id' ) ) {
							$post = get_post( icl_object_id( $post->ID, $type, true ) );
						}
					}
					setup_postdata($post);
					$excerpt        = get_the_excerpt();
					$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
					$url            = $attachment_url['0'];
					$image          = aq_resize($url, $thumb_width, $thumb_height, true);

					$post_classes = get_post_class();
					foreach ($post_classes as $key => $value) {
						$pos = strripos($value, 'tag-');
						if ($pos !== false) {
							unset($post_classes[$key]);
						}
					}
					$post_classes = implode(' ', $post_classes);

					$output .= '<li class="recent-posts_li ' . $post_classes . '  list-item-' . $item_counter . ' clearfix">';

					//Aside
					if($post_format == "aside") {

						$output .= the_content($post->ID);

					} elseif ($post_format == "link") {

						$url =  get_post_meta(get_the_ID(), 'tz_link_url', true);

						$output .= '<a target="_blank" href="'. $url . '">';
						$output .= get_the_title($post->ID);
						$output .= '</a>';

					//Quote
					} elseif ($post_format == "quote") {

						$quote =  get_post_meta(get_the_ID(), 'tz_quote', true);

						$output .= '<div class="quote-wrap clearfix">';

								$output .= '<blockquote>';
									$output .= $quote;
								$output .= '</blockquote>';

						$output .= '</div>';

					//Image
					} elseif ($post_format == "image") {

					if (has_post_thumbnail() ) :

						// $lightbox = get_post_meta(get_the_ID(), 'tz_image_lightbox', TRUE);

						$src      = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), array( '9999','9999' ), false, '' );

						$thumb    = get_post_thumbnail_id();
						$img_url  = wp_get_attachment_url( $thumb,'full'); //get img URL
						$image    = aq_resize( $img_url, 200, 120, true ); //resize & crop img


						$output .= '<figure class="thumbnail featured-thumbnail large">';
							$output .= '<a class="image-wrap" rel="prettyPhoto" title="' . get_the_title($post->ID) . '" href="' . $src[0] . '">';
							$output .= '<img src="' . $image . '" alt="' . get_the_title($post->ID) .'" />';
							$output .= '<span class="zoom-icon"></span></a>';
						$output .= '</figure>';

					endif;


					//Audio
					} elseif ($post_format == "audio") {

						$template_url = get_template_directory_uri();
						$id           = $post->ID;

						// get audio attribute
						$audio_title  = get_post_meta(get_the_ID(), 'tz_audio_title', true);
						$audio_artist = get_post_meta(get_the_ID(), 'tz_audio_artist', true);
						$audio_format = get_post_meta(get_the_ID(), 'tz_audio_format', true);
						$audio_url    = get_post_meta(get_the_ID(), 'tz_audio_url', true);

						// Get the URL to the content area.
						$content_url = untrailingslashit( content_url() );

						// Find latest '/' in content URL.
						$last_slash_pos = strrpos( $content_url, '/' );

						// 'wp-content' or something else.
						$content_dir_name = substr( $content_url, $last_slash_pos - strlen( $content_url ) + 1 );

						$pos = strpos( $audio_url, $content_dir_name );

						if ( false === $pos ) {
							$file = $audio_url;
						} else {
							$audio_new = substr( $audio_url, $pos + strlen( $content_dir_name ), strlen( $audio_url ) - $pos );
							$file     = $content_url . $audio_new;
						}

						$output .= '<script type="text/javascript">
							jQuery(document).ready(function(){
								var myPlaylist_'. $id.'  = new jPlayerPlaylist({
								jPlayer: "#jquery_jplayer_'. $id .'",
								cssSelectorAncestor: "#jp_container_'. $id .'"
								}, [
								{
									title:"'. $audio_title .'",
									artist:"'. $audio_artist .'",
									'. $audio_format .' : "'. stripslashes(htmlspecialchars_decode($file)) .'"}
								], {
									playlistOptions: {enableRemoveControls: false},
									ready: function () {jQuery(this).jPlayer("setMedia", {'. $audio_format .' : "'. stripslashes(htmlspecialchars_decode($file)) .'", poster: "'. $image .'"});
								},
								swfPath: "'. $template_url .'/flash",
								supplied: "'. $audio_format .', all",
								wmode:"window"
								});
							});
							</script>';

						$output .= '<div id="jquery_jplayer_'.$id.'" class="jp-jplayer"></div>
									<div id="jp_container_'.$id.'" class="jp-audio">
										<div class="jp-type-single">
											<div class="jp-gui">
												<div class="jp-interface">
													<div class="jp-progress">
														<div class="jp-seek-bar">
															<div class="jp-play-bar"></div>
														</div>
													</div>
													<div class="jp-duration"></div>
													<div class="jp-time-sep"></div>
													<div class="jp-current-time"></div>
													<div class="jp-controls-holder">
														<ul class="jp-controls">
															<li><a href="javascript:;" class="jp-previous" tabindex="1" title="'.__('Previous', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Previous', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
															<li><a href="javascript:;" class="jp-play" tabindex="1" title="'.__('Play', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Play', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
															<li><a href="javascript:;" class="jp-pause" tabindex="1" title="'.__('Pause', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Pause', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
															<li><a href="javascript:;" class="jp-next" tabindex="1" title="'.__('Next', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Next', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
															<li><a href="javascript:;" class="jp-stop" tabindex="1" title="'.__('Stop', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Stop', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
														</ul>
														<div class="jp-volume-bar">
															<div class="jp-volume-bar-value"></div>
														</div>
														<ul class="jp-toggles">
															<li><a href="javascript:;" class="jp-mute" tabindex="1" title="'.__('Mute', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Mute', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
															<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="'.__('Unmute', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Unmute', CHERRY_PLUGIN_DOMAIN).'</span></a></li>
														</ul>
													</div>
												</div>
												<div class="jp-no-solution">
													<span>'.__('Update Required.', CHERRY_PLUGIN_DOMAIN).'</span>'.__('To play the media you will need to either update your browser to a recent version or update your ', CHERRY_PLUGIN_DOMAIN).'<a href="http://get.adobe.com/flashplayer/" target="_blank">'.__('Flash plugin', CHERRY_PLUGIN_DOMAIN).'</a>
												</div>
											</div>
										</div>
										<div class="jp-playlist">
											<ul>
												<li></li>
											</ul>
										</div>
									</div>';


					$output .= '<div class="entry-content">';
						$output .= get_the_content($post->ID);
					$output .= '</div>';

					//Video
					} elseif ($post_format == "video") {

						$template_url = get_template_directory_uri();
						$id           = $post->ID;

						// get video attribute
						$video_title  = get_post_meta(get_the_ID(), 'tz_video_title', true);
						$video_artist = get_post_meta(get_the_ID(), 'tz_video_artist', true);
						$embed        = get_post_meta(get_the_ID(), 'tz_video_embed', true);
						$m4v_url      = get_post_meta(get_the_ID(), 'tz_m4v_url', true);
						$ogv_url      = get_post_meta(get_the_ID(), 'tz_ogv_url', true);

						// Get the URL to the content area.
						$content_url = untrailingslashit( content_url() );

						// Find latest '/' in content URL.
						$last_slash_pos = strrpos( $content_url, '/' );

						// 'wp-content' or something else.
						$content_dir_name = substr( $content_url, $last_slash_pos - strlen( $content_url ) + 1 );

						$pos1     = strpos($m4v_url, $content_dir_name);
						if ($pos1 === false) {
							$file1 = $m4v_url;
						} else {
							$m4v_new  = substr($m4v_url, $pos1+strlen($content_dir_name), strlen($m4v_url) - $pos1);
							$file1    = $content_url.$m4v_new;
						}

						$pos2     = strpos($ogv_url, $content_dir_name);
						if ($pos2 === false) {
							$file2 = $ogv_url;
						} else {
							$ogv_new  = substr($ogv_url, $pos2+strlen($content_dir_name), strlen($ogv_url) - $pos2);
							$file2    = $content_url.$ogv_new;
						}

						// get thumb
						if(has_post_thumbnail()) {
							$thumb   = get_post_thumbnail_id();
							$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
							$image   = aq_resize( $img_url, 770, 380, true ); //resize & crop img
						}

						if ($embed == '') {
							$output .= '<script type="text/javascript">
								jQuery(document).ready(function(){
									var
										jPlayerObj = jQuery("#jquery_jplayer_'. $id.'")
									,	jPlayerContainer = jQuery("#jp_container_'. $id.'")
									,	isPause = true
									;
									jPlayerObj.jPlayer({
										ready: function () {
											jQuery(this).jPlayer("setMedia", {
												m4v: "'. stripslashes(htmlspecialchars_decode($file1)) .'",
												ogv: "'. stripslashes(htmlspecialchars_decode($file2)) .'",
												poster: "'. $image .'"
											});
										},
										swfPath: "'. $template_url .'/flash",
										solution: "flash, html",
										supplied: "ogv, m4v, all",
										cssSelectorAncestor: "#jp_container_'. $id.'",
										size: {
											width: "100%",
											height: "100%"
										}
									});
									jPlayerObj.on(jQuery.jPlayer.event.ready + ".jp-repeat", function(event) {
										jQuery("img", this).addClass("poster");
										jQuery("video", this).addClass("video");
										jQuery("object", this).addClass("flashObject");
										jQuery(".video", jPlayerContainer).on("click", function(){
											jPlayerObj.jPlayer("pause");
										})
									})
									jPlayerObj.on(jQuery.jPlayer.event.ended + ".jp-repeat", function(event) {
										isPause = true
										jQuery(".poster", jPlayerContainer).css({display:"inline"});
									    jQuery(".video", jPlayerContainer).css({width:"0%", height:"0%"});
									    jQuery(".flashObject", jPlayerContainer).css({width:"0%", height:"0%"});
									    jPlayerObj.siblings(".jp-gui").find(".jp-video-play").css({display:"block"});
									});
									jPlayerObj.on(jQuery.jPlayer.event.play + ".jp-repeat", function(event) {
									   isPause = false
									   emulSwitch(isPause);
									});
									jPlayerObj.on(jQuery.jPlayer.event.pause + ".jp-repeat", function(event) {
									   isPause = true
									   emulSwitch(isPause);
									});
									function emulSwitch(_pause){
										if(_pause){
											jQuery(".poster", jPlayerContainer).css({display:"none"});
									    	jQuery(".video", jPlayerContainer).css({width:"100%", height:"100%"});
									    	jQuery(".flashObject", jPlayerContainer).css({width:"100%", height:"100%"});
									    	jPlayerObj.siblings(".jp-gui").find(".jp-video-play").css({display:"block"});
										}else{
											jQuery(".poster", jPlayerContainer).css({display:"none"});
									    	jQuery(".video", jPlayerContainer).css({width:"100%", height:"100%"});
									    	jQuery(".flashObject", jPlayerContainer).css({width:"100%", height:"100%"});
									    	jPlayerObj.siblings(".jp-gui").find(".jp-video-play").css({display:"none"});
										}
									}
								});
								</script>';
								$output .= '<div id="jp_container_'. $id .'" class="jp-video fullwidth">';
								$output .= '<div class="jp-type-list-parent">';
								$output .= '<div class="jp-type-single">';
								$output .= '<div id="jquery_jplayer_'. $id .'" class="jp-jplayer"></div>';
								$output .= '<div class="jp-gui">';
								$output .= '<div class="jp-video-play">';
								$output .= '<a href="javascript:;" class="jp-video-play-icon" tabindex="1" title="'.__('Play', CHERRY_PLUGIN_DOMAIN).'">'.__('Play', CHERRY_PLUGIN_DOMAIN).'</a></div>';
								$output .= '<div class="jp-interface">';
								$output .= '<div class="jp-progress">';
								$output .= '<div class="jp-seek-bar">';
								$output .= '<div class="jp-play-bar">';
								$output .= '</div></div></div>';
								$output .= '<div class="jp-duration"></div>';
								$output .= '<div class="jp-time-sep">/</div>';
								$output .= '<div class="jp-current-time"></div>';
								$output .= '<div class="jp-controls-holder">';
								$output .= '<ul class="jp-controls">';
								$output .= '<li><a href="javascript:;" class="jp-play" tabindex="1" title="'.__('Play', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Play', CHERRY_PLUGIN_DOMAIN).'</span></a></li>';
								$output .= '<li><a href="javascript:;" class="jp-pause" tabindex="1" title="'.__('Pause', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Pause', CHERRY_PLUGIN_DOMAIN).'</span></a></li>';
								$output .= '<li class="li-jp-stop"><a href="javascript:;" class="jp-stop" tabindex="1" title="'.__('Stop', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Stop', CHERRY_PLUGIN_DOMAIN).'</span></a></li>';
								$output .= '</ul>';
								$output .= '<div class="jp-volume-bar">';
								$output .= '<div class="jp-volume-bar-value">';
								$output .= '</div></div>';
								$output .= '<ul class="jp-toggles">';
								$output .= '<li><a href="javascript:;" class="jp-mute" tabindex="1" title="'.__('Mute', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Mute', CHERRY_PLUGIN_DOMAIN).'</span></a></li>';
								$output .= '<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="'.__('Unmute', CHERRY_PLUGIN_DOMAIN).'"><span>'.__('Unmute', CHERRY_PLUGIN_DOMAIN).'</span></a></li>';
								$output .= '</ul>';
								$output .= '</div></div>';
								$output .= '<div class="jp-no-solution">';
								$output .= '<span>'.__('Update Required.', CHERRY_PLUGIN_DOMAIN).'</span>'.__('To play the media you will need to either update your browser to a recent version or update your ', CHERRY_PLUGIN_DOMAIN).'<a href="http://get.adobe.com/flashplayer/" target="_blank">'.__('Flash plugin', CHERRY_PLUGIN_DOMAIN).'</a>';
								$output .= '</div></div></div></div>';
								$output .= '</div>';
						} else {
							$output .= '<div class="video-wrap">' . stripslashes(htmlspecialchars_decode($embed)) . '</div>';
						}

						if($excerpt_count >= 1){
							$output .= '<div class="excerpt">';
								$output .= my_string_limit_words($excerpt,$excerpt_count);
							$output .= '</div>';
					}

					//Standard
					} else {

						if ($thumb == 'true') {
							if ( has_post_thumbnail($post->ID) ){
								$output .= '<figure class="thumbnail featured-thumbnail"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= '<img src="'.$image.'" alt="' . get_the_title($post->ID) .'"/>';
								$output .= '<div class="block_cont">';
									$output .= '<h5>';
											$output .= get_the_title($post->ID);
									$output .= '</h5>';
									$output .= cherry_get_post_networks(array('post_id' => $post->ID, 'display_title' => false, 'output_type' => 'return'));
									if ($excerpt_count >= 1) {
										$output .= '<div class="excerpt">';
											$output .= my_string_limit_words($excerpt,$excerpt_count);
										$output .= '</div>';
									}
									if ($more_text_single!="") {
										$output .= '<a href="'.get_permalink($post->ID).'" class="btn btn-primary" title="'.get_the_title($post->ID).'">';
										$output .= $more_text_single;
										$output .= '</a>';
									}
								$output .= '</div>';
								$output .= '</a></figure>';
							}
						}
						/*$output .= '<h5><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';
								$output .= get_the_title($post->ID);
						$output .= '</a></h5>';*/
						/*if ($meta == 'true') {
								$output .= '<span class="meta">';
										$output .= '<span class="post-date">';
											$output .= get_the_date();
										$output .= '</span>';
										$output .= '<span class="post-comments">';
											$output .= '<a href="'.get_comments_link($post->ID).'">';
												$output .= get_comments_number($post->ID);
											$output .= '</a>';
										$output .= '</span>';
								$output .= '</span>';
						}
						$output .= cherry_get_post_networks(array('post_id' => $post->ID, 'display_title' => false, 'output_type' => 'return'));
						if ($excerpt_count >= 1) {
							$output .= '<div class="excerpt">';
								$output .= my_string_limit_words($excerpt,$excerpt_count);
							$output .= '</div>';
						}
						if ($more_text_single!="") {
							$output .= '<a href="'.get_permalink($post->ID).'" class="btn btn-primary" title="'.get_the_title($post->ID).'">';
							$output .= $more_text_single;
							$output .= '</a>';
						}*/
					}
				$output .= '<div class="clear"></div>';
				$item_counter ++;
				$output .= '</li><!-- .entry (end) -->';
			}
			wp_reset_postdata(); // restore the global $post variable
			$output .= '</ul><!-- .recent-posts-cust (end) -->';

			$output = apply_filters( 'cherry_plugin_shortcode_output', $output, $atts, $shortcodename );

			return $output;
		}
		add_shortcode('recent_posts', 'shortcode_recent_posts');
	}
?>