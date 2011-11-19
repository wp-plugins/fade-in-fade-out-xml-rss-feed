<?php

/*
Plugin Name: Fade in fade out xml rss feed
Plugin URI: http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
Description: Now a day's everyone use fade in fade out text in some portion of the website to attract the user. So i have created new plug-in to do this. This plug-in directly retrieve title from RSS feed and create the fade in fade out effect in the word press website..
Author: Gopi.R
Version: 2.0
Author URI: http://www.gopiplus.com/work/
Donate link: http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/
Tags: wordpress, plugin, widget, fade in, fade out, rss, xml, feed
*/

/**
 *     Fade in fade out xml rss feed
 *     Copyright (C) 2011  www.gopiplus.com
 * 
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 * 
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 * 
 *     You should have received a copy of the GNU General Public License
 *     along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

global $wpdb, $wp_version;

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
		$url = "http://www.gopiplus.com/work/feed/";
	}

	$cnt=0;
	$doc = new DOMDocument();
	$doc->load( $url );
	$item = $doc->getElementsByTagName( "item" );
	foreach( $item as $item )
	{
		$paths = $item->getElementsByTagName( "title" );
	  	$FIFOXMLRSSFEED_text = mysql_real_escape_string($paths->item(0)->nodeValue);
	  	$paths = $item->getElementsByTagName( "link" );
	  	$FIFOXMLRSSFEED_link = $paths->item(0)->nodeValue;
		$FIFOXMLRSSFEED_Arr = $FIFOXMLRSSFEED_Arr . "FIFOXMLRSSFEED_Links[$cnt] = '$FIFOXMLRSSFEED_link';FIFOXMLRSSFEED_Titles[$cnt] = '$FIFOXMLRSSFEED_text';";
		if($cnt == 0)
		{
			$FIFOXMLRSSFEED_First_text = $FIFOXMLRSSFEED_text;
			$FIFOXMLRSSFEED_First_link = $FIFOXMLRSSFEED_link;
		}
		$cnt++;
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
	var FIFOXMLRSSFEED_FadeStep = 3;
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
	add_option('FIFOXMLRSSFEED_rss_0', "http://www.gopiplus.com/work/feed/");
	add_option('FIFOXMLRSSFEED_rss_1', "http://www.gopiplus.com/work/feed/");
	add_option('FIFOXMLRSSFEED_rss_2', "http://www.gopiplus.com/work/feed");
	add_option('FIFOXMLRSSFEED_rss_3', "http://www.gopiplus.com/work/feed");
}
function FIFOXMLRSSFEED_control() 
{
	echo '<p>Fade in xml rss feed.<br>';
	echo ' <a href="options-general.php?page=fade-in-fade-out-xml-rss-feed/fade-in-fade-out-xml-rss-feed.php">';
	echo 'click here for more info</a></p>';
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
  <h2>Fade in xml rss feed</h2>
</div>
<?php
	$FIFOXMLRSSFEED_Title = get_option('FIFOXMLRSSFEED_Title');
	$FIFOXMLRSSFEED_FadeWait = get_option('FIFOXMLRSSFEED_FadeWait');
	$FIFOXMLRSSFEED_rss_0 = get_option('FIFOXMLRSSFEED_rss_0');
	$FIFOXMLRSSFEED_rss_1 = get_option('FIFOXMLRSSFEED_rss_1');
	$FIFOXMLRSSFEED_rss_2 = get_option('FIFOXMLRSSFEED_rss_2');
	$FIFOXMLRSSFEED_rss_3 = get_option('FIFOXMLRSSFEED_rss_3');
	if (@$_POST['FIFOXMLRSSFEED_submit']) 
	{
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
	}
	?>
<form name="FIFOXMLRSSFEED_form" method="post" action="">
  <?php
	echo '<p>Title:<br><input  style="width: 200px;" type="text" value="';
	echo $FIFOXMLRSSFEED_Title . '" name="FIFOXMLRSSFEED_Title" id="FIFOXMLRSSFEED_Title" /> Widget title</p>';
	echo '<p>Fade Wait:<br><input  style="width: 100px;" type="text" value="';
	echo $FIFOXMLRSSFEED_FadeWait . '" name="FIFOXMLRSSFEED_FadeWait" id="FIFOXMLRSSFEED_FadeWait" /></p>';
	echo '<p>RSS feed:<br><input  style="width: 500px;" type="text" value="';
	echo $FIFOXMLRSSFEED_rss_0 . '" name="FIFOXMLRSSFEED_rss_0" id="FIFOXMLRSSFEED_rss_0" /> Only for widget</p>';
	echo '<p>RSS feed 1:<br><input  style="width: 500px;" type="text" value="';
	echo $FIFOXMLRSSFEED_rss_1 . '" name="FIFOXMLRSSFEED_rss_1" id="FIFOXMLRSSFEED_rss_1" /> [FADE-IN-OUT-RSS=LINK1]</p>';
	echo '<p>RSS feed 2:<br><input  style="width: 500px;" type="text" value="';
	echo $FIFOXMLRSSFEED_rss_2 . '" name="FIFOXMLRSSFEED_rss_2" id="FIFOXMLRSSFEED_rss_2" /> [FADE-IN-OUT-RSS=LINK2]</p>';
	echo '<p>RSS feed 3:<br><input  style="width: 500px;" type="text" value="';
	echo $FIFOXMLRSSFEED_rss_3 . '" name="FIFOXMLRSSFEED_rss_3" id="FIFOXMLRSSFEED_rss_3" /> [FADE-IN-OUT-RSS=LINK3]</p>';
	echo '<input name="FIFOXMLRSSFEED_submit" id="FIFOXMLRSSFEED_submit" lang="publish" class="button-primary" value="Update Setting" type="Submit" />';
	?>
</form>
<br />
Check official website for live demo and help <a target="_blank" href='http://www.gopiplus.com/work/2011/04/29/wordpress-plugin-fade-in-fade-out-xml-rss-feed/'>www.gopiplus.com</a>
<?php
}
add_filter('the_content','FIFOXMLRSSFEED_Show_Filter');

function FIFOXMLRSSFEED_Show_Filter($content)
{
	return 	preg_replace_callback('/\[FADE-IN-OUT-RSS=(.*?)\]/sim','FIFOXMLRSSFEED_Show_Filter_Callback',$content);
}
function FIFOXMLRSSFEED_Show_Filter_Callback($matches) 
{
	global $wpdb;
	$JaFade = "";
	$FIFOXMLRSSFEED_Arr = "";
	$FIFOXMLRSSFEED_FadeWait = get_option('FIFOXMLRSSFEED_FadeWait');
	if(!is_numeric($FIFOXMLRSSFEED_FadeWait)){ $FIFOXMLRSSFEED_FadeWait = 3000; } 
	$Filter = $matches[1];
	if( $Filter == "LINK1" ){ $url = get_option('FIFOXMLRSSFEED_rss_1'); }
	elseif( $Filter == "LINK2" ){ $url = get_option('FIFOXMLRSSFEED_rss_2'); }
	elseif( $Filter == "LINK3" ){ $url = get_option('FIFOXMLRSSFEED_rss_3'); }
	else { $url = "http://www.gopiplus.com/work/feed/";  }
	
	$cnt=0;
	$doc = new DOMDocument();
	$doc->load( $url );
	$item = $doc->getElementsByTagName( "item" );
	foreach( $item as $item )
	{
		$paths = $item->getElementsByTagName( "title" );
	  	$FIFOXMLRSSFEED_text = mysql_real_escape_string($paths->item(0)->nodeValue);
	  	$paths = $item->getElementsByTagName( "link" );
	  	$FIFOXMLRSSFEED_link = $paths->item(0)->nodeValue;
		$FIFOXMLRSSFEED_Arr = $FIFOXMLRSSFEED_Arr . "FIFOXMLRSSFEED_Links[$cnt] = '$FIFOXMLRSSFEED_link';FIFOXMLRSSFEED_Titles[$cnt] = '$FIFOXMLRSSFEED_text';";
		if($cnt == 0)
		{
			$FIFOXMLRSSFEED_First_text = $FIFOXMLRSSFEED_text;
			$FIFOXMLRSSFEED_First_link = $FIFOXMLRSSFEED_link;
		}
		$cnt++;
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
	add_options_page('Fade in xml rss feed', 'Fade in xml rss feed', 'manage_options', __FILE__, 'FIFOXMLRSSFEED_admin_options' );
}
if (is_admin()) 
{
	add_action('admin_menu', 'FIFOXMLRSSFEED_add_to_menu');
}
function FIFOXMLRSSFEED_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('fade-in-xml-rss-feed', 'Fade in xml rss feed', 'FIFOXMLRSSFEED_widget');
	}
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('fade-in-xml-rss-feed', array('Fade in xml rss feed', 'widgets'), 'FIFOXMLRSSFEED_control');
	} 
}
function FIFOXMLRSSFEED_deactivation() 
{
	
}
add_action("plugins_loaded", "FIFOXMLRSSFEED_init");
register_activation_hook(__FILE__, 'FIFOXMLRSSFEED_install');
register_deactivation_hook(__FILE__, 'FIFOXMLRSSFEED_deactivation');
add_action('admin_menu', 'FIFOXMLRSSFEED_add_to_menu');
?>