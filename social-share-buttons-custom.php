<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ){
	die;
}

/*
Plugin Name: WP Simple Social Share Buttons
Plugin URI: https://hamrick.es
Description: Plugin for displaying floating social share icons on posts
Author: hamrick.es
Version: 0.0.5
Author URI: https://hamrick.es
*/


Class Social_Share_Button_Custom {

	function __construct() {

	}

	public function init() {

		add_action( 'the_content', array( $this, 'custom_social_share_buttons' ));
		add_action( 'wp_enqueue_scripts', array( $this , 'plugin_enqueue_scripts') );
	}

	public function plugin_enqueue_scripts()
	{

		wp_enqueue_style('font-awesome-fonts', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), false, false);
		wp_enqueue_style( 'social-share-floating-css', plugins_url( 'assets/css/style.css', __FILE__ ), array(), false, false );
		wp_register_script( 'social-share-floating-js', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), false, true );
		wp_enqueue_script( 'social-share-floating-js' );
	}


	public function custom_social_share_buttons($content) {
		global $post;
		if( is_singular('post') && !is_home() ){

			// Get current page URL
			$sharerURL = urlencode(get_permalink());

			// Get current page title
			$sharerTitle = str_replace( ' ', '%20', get_the_title());

			// Get Post Thumbnail for pinterest
			$postThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

			$share_heading = __('Share this article:', 'pro');

			// Get Twitter Handle from db
			$twitterHandle = "@".get_option('twitter-handle');
			
			// Construct sharing URL without using any script
			$twitterURL = 'https://twitter.com/intent/tweet?text='.$sharerTitle.'&amp;url='.$sharerURL."%20".$twitterHandle;
			$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sharerURL;
			$googleURL = 'https://plus.google.com/share?url='.$sharerURL;
			$bufferURL = 'https://bufferapp.com/add?url='.$sharerURL.'&amp;text='.$sharerTitle;
			$whatsappURL = 'whatsapp://send?text='.$sharerTitle . ' ' . $sharerURL;
			$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sharerURL.'&amp;title='.$sharerTitle;
			// Based on popular demand added Pinterest too
			$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$sharerURL.'&amp;media='.$postThumbnail[0].'&amp;description='.$sharerTitle;

			error_log(var_export( $twitterURL , true ));
			// Add sharing button at the end of page/page content

			$content .= '<div id="sharer-float" class="shares-left hide-on-mobile">
			   <ul class="share-list">
			      <li class="share facebook"><a class="url" target="_blank" href="'.$facebookURL.'"><i class="fa fa-facebook"></i></a></li>
			      <li class="share twitter"><a class="url" target="_blank" href="'.$twitterURL.'"><i class="fa fa-twitter"></i></a></li>
			      <li class="share pinterest"><a class="url" target="_blank" href="'.$pinterestURL.'"><i class="fa fa-pinterest"></i></a></li>
			   </ul>
			</div>';


			$content .= '<div id="content-sharer">
				<h4>'.$share_heading.'</h4>
				<ul class="content-sharer-list">
					<li class="share facebook"><a class="url" target="_blank" href="'.$facebookURL.'"><i class="fa fa-facebook"></i></a></li>
				      <li class="share twitter"><a class="url" target="_blank" href="'.$twitterURL.'"><i class="fa fa-twitter"></i></a></li>
				      <li class="share pinterest"><a class="url" target="_blank" href="'.$pinterestURL.'"><i class="fa fa-pinterest"></i></a></li>
				</ul>
			</div>';

			return $content;
		}else{
			// if not a post/page then don't include sharing button
			return $content;
		}
	}

}



$app = new Social_Share_Button_Custom;
$app->init();
