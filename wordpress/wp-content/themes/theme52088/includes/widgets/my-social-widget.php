<?php
// =============================== My Social Networks Widget ====================================== //
class My_SocialNetworksWidget extends WP_Widget {

	function My_SocialNetworksWidget() {
		$widget_ops = array('classname' => 'social_networks_widget', 'description' => __('Link to your social networks.', CHERRY_PLUGIN_DOMAIN) );
		$this->WP_Widget('social_networks', __('Cherry - Social Networks', CHERRY_PLUGIN_DOMAIN), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance );

		$networks['Twitter']['link']    = $instance['twitter'];
		$networks['Facebook']['link']   = $instance['facebook'];
		$networks['Flickr']['link']     = $instance['flickr'];
		$networks['Feed']['link']       = $instance['feed'];
		$networks['Linkedin']['link']   = $instance['linkedin'];
		$networks['Pinterest']['link']  = $instance['pinterest'];
		$networks['Youtube']['link']    = $instance['youtube'];
		$networks['Google']['link']    = $instance['google'];

		$networks['Twitter']['label']   = $instance['twitter_label'];
		$networks['Facebook']['label']  = $instance['facebook_label'];
		$networks['Flickr']['label']    = $instance['flickr_label'];
		$networks['Feed']['label']      = $instance['feed_label'];
		$networks['Linkedin']['label']  = $instance['linkedin_label'];
		$networks['Pinterest']['label'] = $instance['pinterest_label'];
		$networks['Youtube']['label']   = $instance['youtube_label'];
		$networks['Google']['label']   = $instance['google_label'];

		// WPML compatibility
		// Check if WPML is activated, then reigster labels for translation
		if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			foreach( $networks as $label => $val ) {
				$networks[$label]['label'] = icl_translate( 'cherry', 'social_widget_label_' . $label, $val['label'] );
			}
		}

		$display = $instance['display'];

		echo $before_widget;
		if( $title ) {
			echo $before_title;
				echo $title;
			echo $after_title;
		} ?>

		<!-- BEGIN SOCIAL NETWORKS -->
		<?php if ($display == "both" or $display =="labels") {
			$addClass = "social__list";
		} elseif ($display == "icons") {
			$addClass = "social__row clearfix";
		} ?>

		<ul class="social <?php echo $addClass ?> unstyled">

		<?php foreach(array("Google", "Twitter", "Facebook", "Linkedin", "Feed") as $network) : ?>
			<?php if (!empty($networks[$network]['link'])) : ?>
			<li class="social_li">
				<a class="social_link social_link__<?php echo strtolower($network); ?>" rel="tooltip" data-original-title="<?php echo strtolower($networks[$network]['label']); ?>" href="<?php echo $networks[$network]['link']; ?>" target="_blank">
					<?php if (($display == "both") or ($display =="icons")) { ?>
						<span class="social_ico"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/<?php echo strtolower($network);?>.png" alt=""></span>
					<?php } if (($display == "labels") or ($display == "both")) { ?>
						<?php if ( $networks[$network]['label'] != "" ) { echo '<span class="social_label">'.$networks[$network]['label'].'</span>'; }?>
					<?php } ?>
				</a>
			</li>
			<?php endif; ?>
		<?php endforeach; ?>

		</ul>
		<!-- END SOCIAL NETWORKS -->
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'google' => '', 'google_label' => '', 'twitter' => '', 'twitter_label' => '', 'facebook' => '', 'facebook_label' => '', 'linkedin' => '', 'linkedin_label' => '', 'feed' => '', 'feed_label' => '', 'display' => 'icons', 'text' => '');
		$instance = wp_parse_args( (array) $instance, $defaults );

		$google          = $instance['google'];
		$twitter         = $instance['twitter'];
		$facebook        = $instance['facebook'];
		$flickr          = $instance['flickr'];
		$feed            = $instance['feed'];
		$linkedin        = $instance['linkedin'];
		$pinterest       = $instance['pinterest'];
		$youtube         = $instance['youtube'];

		$google_label    = $instance['google_label'];
		$twitter_label   = $instance['twitter_label'];
		$facebook_label  = $instance['facebook_label'];
		$flickr_label    = $instance['flickr_label'];
		$feed_label      = $instance['feed_label'];
		$linkedin_label  = $instance['linkedin_label'];
		$pinterest_label = $instance['pinterest_label'];
		$youtube_label   = $instance['youtube_label'];

		$display         = $instance['display'];
		$title           = strip_tags($instance['title']);
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', CHERRY_PLUGIN_DOMAIN) ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php _e('Google', CHERRY_PLUGIN_DOMAIN); ?>:</legend>
		
		<p><label for="<?php echo $this->get_field_id('google'); ?>"><?php _e('Google URL', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('google'); ?>" name="<?php echo $this->get_field_name('google'); ?>" type="text" value="<?php echo esc_attr($google); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('google_label'); ?>"><?php _e('Google label', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('google_label'); ?>" name="<?php echo $this->get_field_name('google_label'); ?>" type="text" value="<?php echo esc_attr($google_label); ?>" /></p>
	</fieldset>

	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php _e('Twitter', CHERRY_PLUGIN_DOMAIN); ?>:</legend>
		
		<p><label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('twitter_label'); ?>"><?php _e('Twitter label', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter_label'); ?>" name="<?php echo $this->get_field_name('twitter_label'); ?>" type="text" value="<?php echo esc_attr($twitter_label); ?>" /></p>
	</fieldset>


	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php _e('Facebook', CHERRY_PLUGIN_DOMAIN); ?>:</legend>

		<p><label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL', CHERRY_PLUGIN_DOMAIN) ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('facebook_label'); ?>"><?php _e('Facebook label', CHERRY_PLUGIN_DOMAIN) ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook_label'); ?>" name="<?php echo $this->get_field_name('facebook_label'); ?>" type="text" value="<?php echo esc_attr($facebook_label); ?>" /></p>
	</fieldset>


	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php _e('Linkedin', CHERRY_PLUGIN_DOMAIN); ?>:</legend>
		
		<p><label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URL', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('linkedin_label'); ?>"><?php _e('Linkedin label', CHERRY_PLUGIN_DOMAIN) ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('linkedin_label'); ?>" name="<?php echo $this->get_field_name('linkedin_label'); ?>" type="text" value="<?php echo esc_attr($linkedin_label); ?>" /></p>
	</fieldset>


	<fieldset style="border:1px solid #dfdfdf; padding:10px 10px 0; margin-bottom:1em;">
		<legend style="padding:0 5px;"><?php _e('RSS feed', CHERRY_PLUGIN_DOMAIN); ?>:</legend>
		
		<p><label for="<?php echo $this->get_field_id('feed'); ?>"><?php _e('RSS feed', CHERRY_PLUGIN_DOMAIN); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('feed'); ?>" name="<?php echo $this->get_field_name('feed'); ?>" type="text" value="<?php echo esc_attr($feed); ?>" /></p>
		
		<p><label for="<?php echo $this->get_field_id('feed_label'); ?>"><?php _e('RSS label', CHERRY_PLUGIN_DOMAIN) ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('feed_label'); ?>" name="<?php echo $this->get_field_name('feed_label'); ?>" type="text" value="<?php echo esc_attr($feed_label); ?>" /></p>
	</fieldset>


		<p><?php _e('Display', CHERRY_PLUGIN_DOMAIN); ?>:</p>
		<label for="<?php echo $this->get_field_id('icons'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="icons" id="<?php echo $this->get_field_id('icons'); ?>" <?php checked($display, "icons"); ?>></input>  <?php _e('Icons', CHERRY_PLUGIN_DOMAIN); ?></label>
		<label for="<?php echo $this->get_field_id('labels'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="labels" id="<?php echo $this->get_field_id('labels'); ?>" <?php checked($display, "labels"); ?>></input> <?php _e('Labels', CHERRY_PLUGIN_DOMAIN); ?></label>
		<label for="<?php echo $this->get_field_id('both'); ?>"><input type="radio" name="<?php echo $this->get_field_name('display'); ?>" value="both" id="<?php echo $this->get_field_id('both'); ?>" <?php checked($display, "both"); ?>></input> <?php _e('Both', CHERRY_PLUGIN_DOMAIN); ?></label>
<?php
	}
}?>