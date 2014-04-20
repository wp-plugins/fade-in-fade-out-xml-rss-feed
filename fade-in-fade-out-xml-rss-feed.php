<?php
/*
Plugin Name: Fade in fade out xml rss feed
Plugin URI: http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
Description: Now a day's everyone use fade in fade out text in some portion of the website to attract the user. So i have created new plug-in to do this. This plug-in directly retrieve title from RSS feed and create the fade in fade out effect in the word press website..
Author: Gopi Ramasamy
Version: 7.2
Author URI: http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
Donate link: http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
Tags: wordpress, plugin, widget, fade in, fade out, rss, xml, feed
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

global $wpdb, $wp_version;
define('WP_FIFOXMLRSSFEED_LINK', '');

function FIFOXMLRSSFEED() 
{
	global $wpdb;
	$FIFOXMLRSSFEED_Arr = "";
	$FIFOXMLRSSFEED_FadeWait = get_option('FIFOXMLRSSFEED_FadeWait');
	if(!is_numeric($FIFOXMLRSSFEED_FadeWait)){ $FIFOXMLRSSFEED_FadeWait = 3000; }
	
	if(get_option('FIFOXMLRSSFEED_rss_0') <> "")
	{
		$url = get_option('FIFOXMLRSSFEED_rss_0');
	}
	else
	{
		$url = "http://www.gopiplus.com/work/category/word-press-plug-in/feed/";
	}

	$maxitems = 0;
	include_once( ABSPATH . WPINC . '/feed.php' );
	$rss = fetch_feed( $url );
	if ( ! is_wp_error( $rss ) )
	{
    	$cnt = 0;
		$maxitems = $rss->get_item_quantity( 6 ); 
    	$rss_items = $rss->get_items( 0, $maxitems );
		if ( $maxitems > 0 )
		{
			foreach ( $rss_items as $item )
			{
				$FIFOXMLRSSFEED_link = $item->get_permalink();
				$FIFOXMLRSSFEED_text = $item->get_title();
				$FIFOXMLRSSFEED_Arr = $FIFOXMLRSSFEED_Arr . "FIFOXMLRSSFEED_Links[$cnt] = '$FIFOXMLRSSFEED_link';FIFOXMLRSSFEED_Titles[$cnt] = '$FIFOXMLRSSFEED_text';";
				if($cnt == 0)
				{
					$FIFOXMLRSSFEED_First_text = $FIFOXMLRSSFEED_text;
					$FIFOXMLRSSFEED_First_link = $FIFOXMLRSSFEED_link;
				}
				$cnt++;
			}
		}
	}

	?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_option('siteurl'); ?>/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.css" />
	<script type="text/javascript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.js"></script>
	<script type="text/javascript" language="javascript">
		function FIFOXMLRSSFEED_SetFadeLinks() 
		{
			<?php echo $FIFOXMLRSSFEED_Arr ?>
		}
		var FIFOXMLRSSFEED_FadeOut = 255;
		var FIFOXMLRSSFEED_FadeIn = 0;
		var FIFOXMLRSSFEED_Fade = 0;
		var FIFOXMLRSSFEED_FadeStep = 2;
		var FIFOXMLRSSFEED_FadeWait = <?php echo $FIFOXMLRSSFEED_FadeWait; ?>;
		var FIFOXMLRSSFEED_bFadeOutt = true;
		</script>
	<span id="FIFOXMLRSSFEED_CSS_WIDGET"><a href="<?php echo $FIFOXMLRSSFEED_First_link; ?>" id="FIFOXMLRSSFEED_Link"><?php echo $FIFOXMLRSSFEED_First_text; ?></a> </span>
	<?php	
}

function FIFOXMLRSSFEED_install() 
{
	global $wpdb;
	add_option('FIFOXMLRSSFEED_Title', "Fade In out RSS");
	add_option('FIFOXMLRSSFEED_FadeWait', "3000");
	add_option('FIFOXMLRSSFEED_rss_0', "http://www.gopiplus.com/work/category/word-press-plug-in/feed/");
	add_option('FIFOXMLRSSFEED_rss_1', "");
	add_option('FIFOXMLRSSFEED_rss_2', "");
	add_option('FIFOXMLRSSFEED_rss_3', "");
}

function FIFOXMLRSSFEED_control() 
{
	echo '<p><b>';
	 _e('Fade in xml rss feed', 'fade-in-fade-out');
	echo '.</b> ';
	_e('Check official website for more information', 'fade-in-fade-out');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/"><?php _e('click here', 'fade-in-fade-out'); ?></a></p><?php
}

function FIFOXMLRSSFEED_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('FIFOXMLRSSFEED_Title');
	echo $after_title;
	FIFOXMLRSSFEED();
	echo $after_widget;
}

function FIFOXMLRSSFEED_admin_options() 
{
	global $wpdb;
	?>
	<div class="wrap">
	  <div class="form-wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"><br>
		</div>
		<h2><?php _e('Fade in xml rss feed', 'fade-in-fade-out'); ?></h2>
		<h3><?php _e('Plugin setting', 'fade-in-fade-out'); ?></h3>
		<?php
		$FIFOXMLRSSFEED_Title = get_option('FIFOXMLRSSFEED_Title');
		$FIFOXMLRSSFEED_FadeWait = get_option('FIFOXMLRSSFEED_FadeWait');
		$FIFOXMLRSSFEED_rss_0 = get_option('FIFOXMLRSSFEED_rss_0');
		$FIFOXMLRSSFEED_rss_1 = get_option('FIFOXMLRSSFEED_rss_1');
		$FIFOXMLRSSFEED_rss_2 = get_option('FIFOXMLRSSFEED_rss_2');
		$FIFOXMLRSSFEED_rss_3 = get_option('FIFOXMLRSSFEED_rss_3');
		
		if (isset($_POST['FIFOXMLRSSFEED_submit'])) 
		{
		
			//	Just security thingy that wordpress offers us
			check_admin_referer('FIFOXMLRSSFEED_form_setting');
			
			$FIFOXMLRSSFEED_Title = stripslashes($_POST['FIFOXMLRSSFEED_Title']);
			$FIFOXMLRSSFEED_rss_0 = stripslashes($_POST['FIFOXMLRSSFEED_rss_0']);
			$FIFOXMLRSSFEED_rss_1 = stripslashes($_POST['FIFOXMLRSSFEED_rss_1']);
			$FIFOXMLRSSFEED_rss_2 = stripslashes($_POST['FIFOXMLRSSFEED_rss_2']);
			$FIFOXMLRSSFEED_rss_3 = stripslashes($_POST['FIFOXMLRSSFEED_rss_3']);
			$FIFOXMLRSSFEED_FadeWait = stripslashes($_POST['FIFOXMLRSSFEED_FadeWait']);
			update_option('FIFOXMLRSSFEED_Title', $FIFOXMLRSSFEED_Title );
			update_option('FIFOXMLRSSFEED_rss_0', $FIFOXMLRSSFEED_rss_0 );
			update_option('FIFOXMLRSSFEED_rss_1', $FIFOXMLRSSFEED_rss_1 );
			update_option('FIFOXMLRSSFEED_rss_2', $FIFOXMLRSSFEED_rss_2 );
			update_option('FIFOXMLRSSFEED_rss_3', $FIFOXMLRSSFEED_rss_3 );
			update_option('FIFOXMLRSSFEED_FadeWait', $FIFOXMLRSSFEED_FadeWait );
			
			?>
			<div class="updated fade">
				<p><strong><?php _e('Details successfully updated.', 'fade-in-fade-out'); ?></strong></p>
			</div>
			<?php
		}
		?>
		<form name="FIFOXMLRSSFEED_form" method="post" action="">
		<label for="tag-title"><?php _e('Widget title (Only for widget)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_Title" size="50" id="FIFOXMLRSSFEED_Title" type="text" value="<?php echo $FIFOXMLRSSFEED_Title; ?>" />
		<p><?php _e('Widget title', 'fade-in-fade-out'); ?></p>
			  
		<label for="tag-title"><?php _e('Fade Wait (Global Setting)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_FadeWait" id="FIFOXMLRSSFEED_FadeWait" type="text" size="30" value="<?php echo $FIFOXMLRSSFEED_FadeWait; ?>" />
		<p></p>
		
		<label for="tag-title"><?php _e('RSS feed for widget (Support only external feed)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_rss_0" id="FIFOXMLRSSFEED_rss_0" type="text" size="80" value="<?php echo $FIFOXMLRSSFEED_rss_0; ?>" />
		<p><?php _e('This option only for widget', 'fade-in-fade-out'); ?> <br />Example: http://www.gopiplus.com/work/category/word-press-plug-in/feed/</p>
		
		<label for="tag-title"><?php _e('RSS feed 1 (Support only external feed)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_rss_1" id="FIFOXMLRSSFEED_rss_1" type="text" size="80" value="<?php echo $FIFOXMLRSSFEED_rss_1; ?>" />
		<p><?php _e('Short code :', 'fade-in-fade-out'); ?> [fadein-fadeout-rss feed="link1"] <br />Example: http://www.gopiplus.com/work/category/word-press-plug-in/feed/</p>
		
		<label for="tag-title"><?php _e('RSS feed 2 (Support only external feed)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_rss_2" id="FIFOXMLRSSFEED_rss_2" type="text" size="80" value="<?php echo $FIFOXMLRSSFEED_rss_2; ?>" />
		<p><?php _e('Short code :', 'fade-in-fade-out'); ?> [fadein-fadeout-rss feed="link2"] <br />Example: http://www.gopiplus.com/work/category/word-press-plug-in/feed/</p>
		
		<label for="tag-title"><?php _e('RSS feed 3 (Support only external feed)', 'fade-in-fade-out'); ?> </label>
		<input name="FIFOXMLRSSFEED_rss_3" id="FIFOXMLRSSFEED_rss_3" type="text" size="80" value="<?php echo $FIFOXMLRSSFEED_rss_3; ?>" />
		<p><?php _e('Short code :', 'fade-in-fade-out'); ?> [fadein-fadeout-rss feed="link3"] <br />Example: http://www.gopiplus.com/work/category/word-press-plug-in/feed/</p>
		
		<?php wp_nonce_field('FIFOXMLRSSFEED_form_setting'); ?>
		<input name="FIFOXMLRSSFEED_submit" id="FIFOXMLRSSFEED_submit" lang="publish" class="button-primary" value="<?php _e('Update Setting', 'fade-in-fade-out'); ?>" type="Submit" />
		<a class="button-primary" target="_blank" href="http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/"><?php _e('Help', 'fade-in-fade-out'); ?></a>
		</form>
		<h3><?php _e('Plugin configuration option', 'fade-in-fade-out'); ?></h3>
		<ol>
		  <li><?php _e('Drag and drop the widget.', 'fade-in-fade-out'); ?></li>
		  <li><?php _e('Add the plugin in the posts or pages using short code.', 'fade-in-fade-out'); ?></li>
		  <li><?php _e('Add directly in to the theme using PHP code.', 'fade-in-fade-out'); ?></li>
		</ol>
	  </div>
	  <p class="description">
		<?php _e('Check official website for more information', 'fade-in-fade-out'); ?>
		<a target="_blank" href="http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/"><?php _e('click here', 'fade-in-fade-out'); ?></a>
	</p>
	</div>
	<?php
}

add_shortcode( 'fadein-fadeout-rss', 'FIFOXMLRSSFEED_shortcode' );

function FIFOXMLRSSFEED_shortcode( $atts ) 
{
	global $wpdb;
	$JaFade = "";
	$FIFOXMLRSSFEED_Arr = "";
	$FIFOXMLRSSFEED_FadeWait = get_option('FIFOXMLRSSFEED_FadeWait');
	if(!is_numeric($FIFOXMLRSSFEED_FadeWait)){ $FIFOXMLRSSFEED_FadeWait = 3000; } 
	
	// $Filter = $matches[1];
	// [fadein-fadeout-rss feed="link1"]
	if ( !is_array( $atts ) )
	{
		return '';
	}
	$Filter = strtoupper($atts['feed']);
	
	if( $Filter == "LINK1" ){ $url = get_option('FIFOXMLRSSFEED_rss_1'); }
	elseif( $Filter == "LINK2" ){ $url = get_option('FIFOXMLRSSFEED_rss_2'); }
	elseif( $Filter == "LINK3" ){ $url = get_option('FIFOXMLRSSFEED_rss_3'); }
	else { $url = "http://www.gopiplus.com/work/category/word-press-plug-in/feed/";  }
	
	$maxitems = 0;
	include_once( ABSPATH . WPINC . '/feed.php' );
	$rss = fetch_feed( $url );
	if ( ! is_wp_error( $rss ) )
	{
    	$cnt = 0;
		$maxitems = $rss->get_item_quantity( 6 ); 
    	$rss_items = $rss->get_items( 0, $maxitems );
		if ( $maxitems > 0 )
		{
			foreach ( $rss_items as $item )
			{
				$FIFOXMLRSSFEED_link = $item->get_permalink();
				$FIFOXMLRSSFEED_text = $item->get_title();
				$FIFOXMLRSSFEED_Arr = $FIFOXMLRSSFEED_Arr . "FIFOXMLRSSFEED_Links[$cnt] = '$FIFOXMLRSSFEED_link';FIFOXMLRSSFEED_Titles[$cnt] = '$FIFOXMLRSSFEED_text';";
				if($cnt == 0)
				{
					$FIFOXMLRSSFEED_First_text = $FIFOXMLRSSFEED_text;
					$FIFOXMLRSSFEED_First_link = $FIFOXMLRSSFEED_link;
				}
				$cnt++;
			}
		}
	}
		
	$JaFade = $JaFade . "<link rel='stylesheet' type='text/css' href='".get_option('siteurl')."/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.css' />";
	$JaFade = $JaFade . "<script type='text/javascript' src='".get_option('siteurl')."/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.js'></script>";
    $JaFade = $JaFade . "<script type='text/javascript' language='javascript'>function FIFOXMLRSSFEED_SetFadeLinks() { $FIFOXMLRSSFEED_Arr}";
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_FadeOut = 255;';
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_FadeIn = 0;';
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_Fade = 0;';
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_FadeStep = 3;';
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_FadeWait = 3000;';
	$JaFade = $JaFade . 'var FIFOXMLRSSFEED_bFadeOutt = true;';
	$JaFade = $JaFade . '</script>';
    $JaFade = $JaFade . '<span id="FIFOXMLRSSFEED_CSS_POSTPASGE">';
	$JaFade = $JaFade . '<a href="'.$FIFOXMLRSSFEED_First_link.'" id="FIFOXMLRSSFEED_Link">'.$FIFOXMLRSSFEED_First_text.'</a>';
	$JaFade = $JaFade . '</span>';
	return $JaFade;
}

function FIFOXMLRSSFEED_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page('Fade in xml rss feed', __('Fade in xml rss feed', 'fade-in-fade-out'), 'manage_options', __FILE__, 'FIFOXMLRSSFEED_admin_options' );
	}
}

function FIFOXMLRSSFEED_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('fade-in-xml-rss-feed', __('Fade in xml rss feed', 'fade-in-fade-out'), 'FIFOXMLRSSFEED_widget');
	}
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('fade-in-xml-rss-feed', array( __('Fade in xml rss feed', 'fade-in-fade-out'), 'widgets'), 'FIFOXMLRSSFEED_control');
	} 
}

function FIFOXMLRSSFEED_deactivation() 
{
	// No required now
}

function FIFOXMLRSSFEED_javascript_files() 
{
	//if (!is_admin())
	//{
		//wp_enqueue_style( 'fade-in-fade-out-xml-rss-feed', get_option('siteurl').'/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.css');
		//wp_enqueue_script( 'fade-in-fade-out-xml-rss-feed', get_option('siteurl').'/wp-content/plugins/fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.js');
	//}	
}

function FIFOXMLRSSFEED_textdomain() 
{
	  load_plugin_textdomain( 'fade-in-fade-out', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'FIFOXMLRSSFEED_textdomain');
add_action('wp_enqueue_scripts', 'FIFOXMLRSSFEED_javascript_files');
add_action('admin_menu', 'FIFOXMLRSSFEED_add_to_menu');
add_action("plugins_loaded", "FIFOXMLRSSFEED_init");
register_activation_hook(__FILE__, 'FIFOXMLRSSFEED_install');
register_deactivation_hook(__FILE__, 'FIFOXMLRSSFEED_deactivation');
?>
