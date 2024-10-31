<?php
/*
Plugin Name: Negaraku
Version: 1.1.4
Plugin URI: http://www.noktahhitam.com/wordpress-plugin-for-negaraku.html
Description: Adds Negaraku button to your WordPress blog posts - fully customizable. [Latest update 20081112: Tiny bug]
Author: ImamKhalid
Author URI: http://soleh.net
*/

$message = "";
if (!function_exists('smnegaraku_request_handler')) {
    function smnegaraku_request_handler() {
        global $message;
        if ($_POST['smnegaraku_action'] == "update options") {
            if ($_POST['smnegaraku_top_main']=='on') $smnegaraku_top_main='yes'; else $smnegaraku_top_main='no';
            if ($_POST['smnegaraku_top_single']=='on') $smnegaraku_top_single='yes'; else $smnegaraku_top_single='no';
            $smnegaraku_align_top 	= $_POST['smnegaraku_align_top'];
            $smnegaraku_size_top 	= $_POST['smnegaraku_size_top'];
            $smnegaraku_margin_top 	= $_POST['smnegaraku_margin_top'];

            $smnegaraku_align_bot 	= $_POST['smnegaraku_align_bot'];
            $smnegaraku_size_bot 	= $_POST['smnegaraku_size_bot'];
            $smnegaraku_margin_bot 	= $_POST['smnegaraku_margin_bot'];

            $smnegaraku_size_int 	= $_POST['smnegaraku_size_int'];
            $smnegaraku_margin_int 	= $_POST['smnegaraku_margin_int'];

    		// top
			if(get_option("smnegaraku_top_main")) update_option("smnegaraku_top_main", $smnegaraku_top_main);
    		else add_option("smnegaraku_top_main", $smnegaraku_top_main);

			if(get_option("smnegaraku_top_single")) update_option("smnegaraku_top_single", $smnegaraku_top_single);
    		else add_option("smnegaraku_top_single", $smnegaraku_top_single);

    		if(get_option("smnegaraku_align_top")) update_option("smnegaraku_align_top", $smnegaraku_align_top);
    		else add_option("smnegaraku_align_top", $smnegaraku_align_top);

    		if(get_option("smnegaraku_size_top")) update_option("smnegaraku_size_top", $smnegaraku_size_top);
    		else add_option("smnegaraku_size_top", $smnegaraku_size_top);

    		if(get_option("smnegaraku_margin_top")) update_option("smnegaraku_margin_top", $smnegaraku_margin_top);
    		else add_option("smnegaraku_margin_top", $smnegaraku_margin_top);

    		// bottom
    		if(get_option("smnegaraku_align_bot")) update_option("smnegaraku_align_bot", $smnegaraku_align_bot);
    		else add_option("smnegaraku_align_bot", $smnegaraku_align_bot);

    		if(get_option("smnegaraku_size_bot")) update_option("smnegaraku_size_bot", $smnegaraku_size_bot);
    		else add_option("smnegaraku_size_bot", $smnegaraku_size_bot);

    		if(get_option("smnegaraku_margin_bot")) update_option("smnegaraku_margin_bot", $smnegaraku_margin_bot);
    		else add_option("smnegaraku_margin_bot", $smnegaraku_margin_bot);

    		// intermediate
    		if(get_option("smnegaraku_size_int")) update_option("smnegaraku_size_int", $smnegaraku_size_int);
    		else add_option("smnegaraku_size_int", $smnegaraku_size_int);

    		if(get_option("smnegaraku_margin_int")) update_option("smnegaraku_margin_int", $smnegaraku_margin_int);
    		else add_option("smnegaraku_margin_int", $smnegaraku_margin_int);

            $message = '<br clear="all" /> <div id="message" class="updated fade"><p><strong>Option saved. </strong></p></div>';
        } else {
			if(get_option("smnegaraku_box_align")) delete_option("smnegaraku_box_align"); // delete old negaraku option to save database
			if(get_option("smnegaraku_top")) delete_option("smnegaraku_top");
			if(!get_option("smnegaraku_top_main")) add_option("smnegaraku_top_main", 'yes');
			if(!get_option("smnegaraku_top_single")) add_option("smnegaraku_top_single", 'yes');
			if(!get_option("smnegaraku_align_top")) add_option("smnegaraku_align_top", 'Right');
			if(!get_option("smnegaraku_size_top")) add_option("smnegaraku_size_top", 'evb2');
			if(!get_option("smnegaraku_align_bot")) add_option("smnegaraku_align_bot", 'None');
		}
    }
}

if(!function_exists('smnegaraku_add_menu')) {
    function smnegaraku_add_menu () {
        add_options_page("Negaraku! Options", "Negaraku! Options", 8, basename(__FILE__), "smnegaraku_displayOptions");
    }
}

if (!function_exists('smnegaraku_displayOptions')) {
    function smnegaraku_displayOptions() {
        global $message;
        echo $message;

		print('<div class="wrap">');
		print('<h2>Negaraku! Options</h2>');
        print ('<form name="smnegaraku_form" action="'. get_bloginfo("wpurl") . '/wp-admin/options-general.php?page=negaraku.php' .'" method="post">');

?>
		<h3><a name="usage">Usage: Three ways to configure</a></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Basic</th>
				<td>By configuring the options in this page, highly customizable.<br>
					See <a href="#topbutt"><strong>Top Button Settings</strong></a> or <a href="#botbutt"><strong>Bottom Button Settings</strong></a>.</td>
			</tr>
			<tr valign="top">
				<th scope="row">Intermediate</th>
				<td>By inserting <code>&lt;!--negaraku--&gt;</code> in any part of the post where you want the Negaraku button to appear.<br>
					See <a href="#intermediate"><strong>Intermediate Settings</strong></a> below to configure.</td>
			</tr>
			<tr valign="top">
				<th scope="row">Advanced</th>
				<td>By calling the show_negaraku() method in the theme tempalate inside the 'have_post()' loop.<br>
					<strong>Parameters:</strong> <code>show_negaraku( [ string $float , string $margin , string $version ] )</code><br>
					<strong>Example 1:</strong> <nobr><code>if (function_exists('show_negaraku')) show_negaraku();</code></nobr><br>
					<strong>Example 2:</strong> <nobr><code>if (function_exists('show_negaraku')) show_negaraku("left", "-10px 0 0 -10px", "evb2");</code></nobr><br>
					<strong>Note:</strong> This method calls the folder name, such as 'evb' and 'evb2'.</td>
			</tr>
		</table>
		<h3><a name="topbutt">Top Button Settings</a> <a href="#usage" title="Back to usage">&uarr;</a></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_align_top">Align</label></th>
				<td><select name="smnegaraku_align_top" id="smnegaraku_align_top">
					<option value="Left" <?php if (get_option("smnegaraku_align_top") == "Left") echo " selected"; ?> >Left</option>
					<option value="Right" <?php if (get_option("smnegaraku_align_top") == "Right") echo " selected"; ?> >Right</option>
					<option value="None" <?php if (get_option("smnegaraku_align_top") == "None") echo " selected"; ?> >Disable</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_top_main">Display on</label></th>
				<td><input type="checkbox" name="smnegaraku_top_main" id="smnegaraku_top_main"
					<?php if (get_option("smnegaraku_top_main") == "yes") echo " checked"; ?>><label for="smnegaraku_top_main"> main page</label>
					<input type="checkbox" name="smnegaraku_top_single" id="smnegaraku_top_single"
					<?php if (get_option("smnegaraku_top_single") == "yes") echo " checked"; ?>><label for="smnegaraku_top_single"> single-post page</label></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_size_top">Version</label></th>
				<td><label><input type="radio" name="smnegaraku_size_top" id="smnegaraku_size_top" 
					value="evb"<?php if (get_option("smnegaraku_size_top") == "evb") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_lama2.png" /></label>
					<label><input type="radio" name="smnegaraku_size_top" id="smnegaraku_size_top" 
					value="evb2"<?php if (get_option("smnegaraku_size_top") == "evb2") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_baru2.png" /></label></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_margin_top">Margin (px)</label></th>
				<td><input type="text" size="24" name="smnegaraku_margin_top" id="smnegaraku_margin_top" value="<?=get_option("smnegaraku_margin_top");?>" /><br>
					Top Right Bottom Left (i.e: 10px 10px -10px -10px)<br>
					Default is 0px 0px 0px 0px</td>
			</tr>
		</table>
		<h3><a name="botbutt">Bottom Button Settings (single-post page only)</a> <a href="#usage" title="Back to usage">&uarr;</a></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_align_bot">Align</label></th>
				<td><select name="smnegaraku_align_bot" id="smnegaraku_align_bot">
					<option value="Left" <?php if (get_option("smnegaraku_align_bot") == "Left") echo " selected"; ?> >Left</option>
					<option value="Right" <?php if (get_option("smnegaraku_align_bot") == "Right") echo " selected"; ?> >Right</option>
					<option value="None" <?php if (get_option("smnegaraku_align_bot") == "None") echo " selected"; ?> >Disable</option>
				</select></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_size_bot">Version</label></th>
				<td><label><input type="radio" name="smnegaraku_size_bot" id="smnegaraku_size_bot" 
					value="evb"<?php if (get_option("smnegaraku_size_bot") == "evb") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_lama2.png" /></label>
					<label><input type="radio" name="smnegaraku_size_bot" id="smnegaraku_size_bot" 
					value="evb2"<?php if (get_option("smnegaraku_size_bot") == "evb2") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_baru2.png" /></label></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_margin_bot">Margin (px)</label></th>
				<td><input type="text" size="24" name="smnegaraku_margin_bot" id="smnegaraku_margin_bot" value="<?=get_option("smnegaraku_margin_bot");?>" /><br>
					Same as top margin</td>
			</tr>
		</table>
		<h3><a name="intermediate">Intermediate Settings</a> <a href="#usage" title="Back to usage">&uarr;</a></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_size_int">Version</label></th>
				<td><label><input type="radio" name="smnegaraku_size_int" id="smnegaraku_size_int" 
					value="evb"<?php if (get_option("smnegaraku_size_int") == "evb") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_lama2.png" /></label>
					<label><input type="radio" name="smnegaraku_size_int" id="smnegaraku_size_int" 
					value="evb2"<?php if (get_option("smnegaraku_size_int") == "evb2") echo " checked"; ?>>
					<img src="http://sembangkomputer.com/wp-content/uploads/2008/11/butang_baru2.png" /></label></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="smnegaraku_margin_int">Margin (px)</label></th>
				<td><input type="text" size="24" name="smnegaraku_margin_int" id="smnegaraku_margin_int" value="<?=get_option("smnegaraku_margin_int");?>" /><br>
					Same as top margin</td>
			</tr>
		</table>
<?php
		print ('<div class="submit"><input type="submit" value="Update Settings &raquo;" /></div>');
		print ('<input type="hidden" name="smnegaraku_action" value="update options" />');
		print('</form></div>');
    }
}

if (!function_exists('smnegaraku_negarakuhtml')) {
	function smnegaraku_negarakuhtml($float="",$margin="0px 0px 0px 0px",$version="evb2") {
		global $wp_query;
		$post = $wp_query->post;
		$permalink = get_permalink($post->ID);
        $title = urlencode($post->post_title);
		$negarakuhtml = "<span style=\"margin: $margin; float: $float;\">\n";
		$negarakuhtml.= "<script type=\"text/javascript\">\n";
		$negarakuhtml.= "submit_url = \"$permalink\";\n";
		$negarakuhtml.= "</script>\n";
		$negarakuhtml.= "<script type=\"text/javascript\" src=\"http://negaraku.net/$version/button.php\"></script>\n";
		$negarakuhtml.= "</span>\n";
		return $negarakuhtml;
	}
}

if (!function_exists('smnegaraku_addbutton')) {
	function smnegaraku_addbutton($content) {
		if(! preg_match('|<!--negaraku-->|', $content)) {
			$smnegaraku_top_main = get_option("smnegaraku_top_main");
			$smnegaraku_top_single = get_option("smnegaraku_top_single");
			if ( ( (is_home() || is_search()) && $smnegaraku_top_main == 'yes' ) || ( is_single() && $smnegaraku_top_single == 'yes' ) ) {
				$smnegaraku_align_top = get_option("smnegaraku_align_top");
				$smnegaraku_margin_top = get_option("smnegaraku_margin_top");
				$smnegaraku_size_top = get_option("smnegaraku_size_top");
				if ($smnegaraku_align_top) {
					if ( $smnegaraku_align_top == "Right" ) {
						$smnegaraku_addbutton = smnegaraku_negarakuhtml("right",$smnegaraku_margin_top,$smnegaraku_size_top).$content;
					} elseif ( $smnegaraku_align_top == "None" ) {
						$smnegaraku_addbutton = $content;
					} else {
						$smnegaraku_addbutton = smnegaraku_negarakuhtml("left",$smnegaraku_margin_top,$smnegaraku_size_top).$content;
					}
				} else $smnegaraku_addbutton = $content;
			} else {
				$smnegaraku_addbutton = $content;
			}
			if ( is_single() ) {
				$smnegaraku_align_bot = get_option("smnegaraku_align_bot");
				$smnegaraku_margin_bot = get_option("smnegaraku_margin_bot");
				$smnegaraku_size_bot = get_option("smnegaraku_size_bot");
				if ($smnegaraku_align_bot) {
					if ( $smnegaraku_align_bot == "Right" ) {
						$smnegaraku_addbutton.= smnegaraku_negarakuhtml("right",$smnegaraku_margin_bot,$smnegaraku_size_bot);
					} elseif ( $smnegaraku_align_bot == "None" ) {
						$smnegaraku_addbutton.= "";
					} else {
						$smnegaraku_addbutton.= smnegaraku_negarakuhtml("left",$smnegaraku_margin_bot,$smnegaraku_size_bot);
					}
				}
			} else {
				$smnegaraku_addbutton.= "";
			}
		} else {
			$smnegaraku_margin_int = get_option("smnegaraku_margin_int");
			$smnegaraku_size_int = get_option("smnegaraku_size_int");
			$smnegaraku_addbutton = str_replace('<!--negaraku-->', smnegaraku_negarakuhtml("none",$smnegaraku_margin_int,$smnegaraku_size_int), $content);
		}
		return $smnegaraku_addbutton;
	}
}

if (!function_exists('show_negaraku')) {
	function show_negaraku($float="none",$margin="0px 0px 0px 0px",$version="evb2") {
        global $post;
		$permalink = get_permalink($post->ID);
		echo "<span style=\"margin: $margin; float: $float;\">\n";
		echo "<script type=\"text/javascript\">\n";
		echo "submit_url = \"$permalink\";\n";
		echo "</script>\n";
		echo "<script type=\"text/javascript\" src=\"http://negaraku.net/$version/button.php\"></script>\n";
		echo "</span>\n";
    }
}

add_filter('the_content', 'smnegaraku_addbutton', 999);
add_action('admin_menu', 'smnegaraku_add_menu');
add_action('init', 'smnegaraku_request_handler');

?>