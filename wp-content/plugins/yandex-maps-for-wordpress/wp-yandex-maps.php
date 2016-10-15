<?php
/**
 * Plugin Name: Yandex Maps for WordPress
 * Plugin URI: http://blog.meelk.com.ua/2009/02/10/plugin-yandekskarty-dlya-wordpress/
 * Description: This simple plugin allows you to insert <a href="http://maps.yandex.ru">Yandex Maps</a> into your blog posts, including large cities. Based on <a href="http://xavisys.com/google-maps-for-wordpress/">Google Maps for Wordpress Plugin</a>. Requires PHP5.
 * Version: 1.4.1
 * Author: Mykhailo Glubokyi
 * Author URI: http://meelk.com.ua/
 */

/**
 * Changelog
 * 19/02/2012: 1.4.1
 * 	-  Baloon fixes / Multiple map fixes
 * 02/02/2012: 1.4.0
 * 	-  Fixed bug with extra padding\margins on some themes
 * 01/05/2009: 1.2.1
 * 	-  Fixed bug with edit filter
 * 28/04/2009: 1.2
 * 	-  Fixed bug with nonce
 * 13/02/2009: 1.1.1
 * 	-  Fixed bug with hook naming
 * 10/02/2009: 1.1.0
 * 	- Added Wordpress MU support
 *
 * 10/02/2009: 1.0
 * 	- Original Version
 */
 
 
 /**
 * wpYandexMaps is the class based on Aaron D. Campbell's Google Maps Class. Thanks for great job, Aaron.
 */
 

/*  Created by Mykhailo Glubokyi  (email : contacts@meelk.com.ua)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
/**
 * wpYandexMaps is the class that handles ALL of the plugin functionality.
 * It helps us avoid name collisions
 * http://codex.wordpress.org/Writing_a_Plugin#Avoiding_Function_Name_Collisions
 */
class wpYandexMaps
{
	/**
	 * We check if there are any maps on the page, and store this as a bool here
	 *
	 * @var bool
	 */
	private $isMap;

	/**
	 * Current map being added to the page.  This gives unique ids to each map,
	 * allowing multiple maps per page
	 *
	 * @var int
	 */
	private $mapNum = 0;

	/**
	 * Full url to the yandex Maps JavaScript file (including API key)
	 *
	 * @var string
	 */
	private $mapApiUrl;

	/**
	 * yandex Maps API Key
	 *
	 * @var string
	 */
	protected $yandexKey;

	/**
	 * Gets Yandex API Key, and creates the url to the yandex Maps JavaScript
	 *
	 */
	public function __construct()
	{
		$this->yandexKey = get_option('wpYandexMaps_api_key');
		$this->mapApiUrl = "http://api-maps.yandex.ru/1.0/index.xml?key={$this->yandexKey}";

		$jsDir = get_option('siteurl') . '/wp-content/plugins/yandex-maps-for-wordpress/js/';

		wp_register_script('yandexMaps', $this->mapApiUrl, false, 2);
		//wp_register_script('wpYandexMaps', "{$jsDir}wp-yandex-maps.js", array('prototype', 'yandexMaps'), '0.0.1');
		wp_register_script('wpYandexMapsAdmin', "{$jsDir}wp-yandex-maps-admin.js", array('jquery'), '0.0.2');
	}

	/**
	 * Add our plugin configuration menu in the admin section
	 * Add boxes to the "edit post" and "edit page" pages
	 */
	public function adminMenu()
	{
		add_meta_box('wpYandexMaps', 'Yandex Maps for WordPress', array($this, 'insertForm'), 'post', 'normal');
		add_meta_box('wpYandexMaps', 'Yandex Maps for WordPress', array($this, 'insertForm'), 'page', 'normal');
		if ( function_exists('add_submenu_page') ) {
			$page = add_submenu_page('plugins.php', __('Yandex Maps'), __('Yandex Maps'), 'manage_options', 'wpYandexMaps-config', array($this, 'configPage'));
			add_action( 'admin_print_scripts-'.$page, array($this, 'printScripts') );
		}
	}

	/**
	 * Create the actual plugin configuration page
	 */
	public function configPage()
	{
		$title = __('Yandex Maps Configuration');
		if ($message) { ?>
			<div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php } ?>
			<div class="wrap">
				<h2><?php echo $title; ?></h2>
				<form action="options.php" method="post">
					<?php
						wp_nonce_field('yandex-maps-options');
					?>
					<p>Yandex Maps for WordPress will allow you to easily add maps to your posts or pages.</p>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Yandex API Key:') ?></th>
							<td>
								<input type="text" size="40" style="width:95%;" name="wpYandexMaps_api_key" id="wpYandexMaps_api_key" value="<?php echo get_option('wpYandexMaps_api_key'); ?>" />
								<input type="hidden" id="option_page" name="option_page" value="yandex-maps" />
								<p id="wpYandexMaps_message"></p>
							</td>
						</tr>
				   </table>
					<p class="submit">
						<input type="submit" name="Submit" value="<?php _e('Apply'); ?>" />
					</p>
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="page_options" value="wpYandexMaps_api_key" />
				</form>
			</div>
<?php
	}

	/**
	 * Used to check for maps, and set $this->isMap
	 *
	 * @param array $posts
	 * @return array of posts (unchanged)
	 */
	public function findMaps($posts)
	{
		if (is_admin()) {
			$this->isMap = false;
			return $posts;
		}
		$content = '';
		foreach ($posts as $post) {
			$content .= $post->post_content;
		}
		$this->isMap = (bool)preg_match("/\[yandexMap(.*)\]/U", $content);

		return $posts;
	}

	/**
	 * If you need to check if there are maps on the current page, use this
	 * $wpYandexMaps->isMap();
	 *
	 * @return bool
	 */
	public function isMap()
	{
		return $this->isMap;
	}

	/**
	 * Links to the Yandex Maps API JavaScript and the wpYandexMaps JS, but only
	 * IF there are maps on this page.
	 *
	 * @return void
	 */
	public function wpHead ()
	{ 
	   if ($this->isMap) {

			//wp_enqueue_script('wpYandexMaps');
			wp_enqueue_script('yandexMaps');
			echo '<link rel="stylesheet" href="'.site_url("/wp-content/plugins/yandex-maps-for-wordpress/yandex.css",'http').'" type="text/css" media="screen" title="Yandex Maps CSS" charset="utf-8"/>';
		}
	}

	/**
	 * Links to the yandex Maps API JavaScript and the wpYandexMaps admin JS
	 *
	 * @return void
	 */
	public function adminHead ()
	{
		if ($GLOBALS['editing']) {
			$this->printScripts();
		}
	}

	public function printScripts () {
		wp_enqueue_script('wpYandexMapsAdmin');    	
		if ( get_option('wpYandexMaps_api_key') ) {
			wp_enqueue_script('yandexMaps', false, array('wpYandexMapsAdmin'));
		}
	}

	/**
	 * Given the attributes and content from the yandexMap shortCode, this will
	 * return an object that has all the settings in it.
	 *
	 * @param array $attr - attributes from the shortCode
	 * @param string $address - content of the shortCode
	 * @return stdClass
	 */
	private function getMapDetails($attr, $address)
	{
		if (isset($attr['width']) && ctype_digit($attr['width'])) {
			$attr['width'] .= 'px';
		}
		if (isset($attr['height']) && ctype_digit($attr['height'])) {
			$attr['height'] .= 'px';
		}

		$mapInfo = (object)shortcode_atts(array('name'              => '',
												'mousewheel'        => 'true',
												'zoompancontrol'    => 'true',
												'typecontrol'       => 'true',
												'directions_to'     => 'true',
												'directions_from'   => 'false',
												'width'             => '100%',
												'height'            => '400px',
												'description'       => ''), $attr);

		array_walk($mapInfo, array($this, 'fixTrueFalse'));
		$mapInfo->address = $address;
		return $mapInfo;
	}

	/**
	 * Replaces "true" and "false" (strings) with true and false (bool)
	 * Used with array_walk
	 *
	 * @param mixed &$value
	 * @param string $key
	 */
	private function fixTrueFalse(&$value, $key) {
		if ($value == 'false') {
			$value = false;
		} elseif ($value == 'true') {
			$value = true;
		}
	}

	/**
	 * Echo a warning into the admin section, if no yandex API has been entered
	 */
	public function warning() {
		echo "<div id='wpYandexMaps_warning' class='updated fade-ff0000'><p><strong>"
			.__('Yandex Maps for WordPress is almost ready.')."</strong> "
			.sprintf(__('You must <a href="%1$s">enter your Yandex API key</a> for it to work.'), "plugins.php?page=wpYandexMaps-config")
			."</p></div>";            
	}

	/**
	 * Adds the form to generate a yandexMaps shortcode and send it to the
	 * editor.  Default values are blank on purpose.  It helps the JavaScript
	 * generate the shortest possible shortCode for the map in question.
	 *
	 * @return void
	 */
	public function insertForm() {
?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_name"><?php _e('Location Name:')?></label></th>
				<td>
					<input type="text" size="40" style="width:95%;" name="wpYandexMaps[name]" id="wpYandexMaps_name" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_address"><?php _e('Address:')?></label></th>
				<td>
					<input type="text" size="40" style="width:95%;" name="wpYandexMaps[address]" id="wpYandexMaps_address" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_description"><?php _e('Location Description:')?></label></th>
				<td>
					<input type="text" size="40" style="width:95%;" name="wpYandexMaps[description]" id="wpYandexMaps_description" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_width"><?php _e('Map Width:')?></label></th>
				<td>
					<input type="text" size="4" name="wpYandexMaps[width]" id="wpYandexMaps_width" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_height"><?php _e('Map Height:')?></label></th>
				<td>
					<input type="text" size="4" name="wpYandexMaps[height]" id="wpYandexMaps_height" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="wpYandexMaps_description"><?php _e('Options:')?></label></th>
				<td>

					<input type="hidden" name="wpYandexMaps[zoompancontrol]" id="wpYandexMaps_zoompancontrol_" value="false" />
					<input type="checkbox" name="wpYandexMaps[zoompancontrol]" id="wpYandexMaps_zoompancontrol" value="" checked="checked" />
					<label for="wpYandexMaps_zoompancontrol">Enable Zoom/Pan Controls</label><br />
					<input type="hidden" name="wpYandexMaps[typecontrol]" id="wpYandexMaps_typecontrol_" value="false" />
					<input type="checkbox" name="wpYandexMaps[typecontrol]" id="wpYandexMaps_typecontrol" value="" checked="checked" />
					<label for="wpYandexMaps_typecontrol">Enable Map Type Controls (Map, Satellite, or Hybrid)</label><br />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="button" onclick="return wpGMapsAdmin.sendToEditor(this.form);" value="<?php _e('Send Map to Editor &raquo;'); ?>" />
		</p>
		<p id="wpYandexMaps_message">&nbsp;</p>
<?php
	}

	/**
	 * Replace our shortCode with the necessary divs (one for the map, and one
	 * for directions) and some JavaScript to start the map
	 *
	 * @param array $attr - array of attributes from the shortCode
	 * @param string $content - Content of the shortCode
	 * @return string - formatted XHTML replacement for the shortCode
	 */
	public function handleShortcodes($attr, $content)
	{    	
		
		$this->mapNum++;
		$mapInfo = $this->getMapDetails($attr, $content);
		if (function_exists('json_encode')) {
			$json = json_encode($mapInfo);
		} else {
			require_once('json_encode.php');
			$json = Zend_Json_Encoder::encode($mapInfo);
		}
		
		
	
		if($mapInfo->typecontrol==1) {
				$buttonsOverlay = "
							var typeControl = new YMaps.TypeControl();
							map.addControl(typeControl);	        
				";		
		} else {
				$buttonsOverlay  =  "";	
		}
	
		if($mapInfo->zoompancontrol==1) {
			$zoomPan = "
						
						map.addControl(new YMaps.ToolBar());
						map.addControl(new YMaps.Zoom());
						map.addControl(new YMaps.MiniMap());
						map.addControl(new YMaps.ScaleLine());
			";
		} else {
			$zoomPan = "";
		}
		
		return <<<mapCode
<div id='map_{$this->mapNum}' style='width:{$mapInfo->width}; height:{$mapInfo->height}; margin:10px;' class='yandexMap'></div>
<div id='dir_{$this->mapNum}'></div>
<script type="text/javascript">
//<![CDATA[ 
			
			var map{$this->mapNum} = new YMaps.Map(document.getElementById("map_{$this->mapNum}"));

						
				var geocoder = new YMaps.Geocoder("{$mapInfo->address}", {results: 1, boundedBy: map{$this->mapNum}.getBounds()});
	 
				YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
					if (this.length()) {
						geoResult = this.get(0);
						map{$this->mapNum}.setCenter(geoResult.getGeoPoint(), 13);
						map{$this->mapNum}.openBalloon(geoResult.getGeoPoint(), "<div style='padding:10px'><h3>{$mapInfo->name}</h3><p>{$mapInfo->description}</p></div>");
						
						//geoResult.text=

						//map.addOverlay(geoResult);
						//map.setBounds(geoResult.getBounds());	                    
						//geoResult.openBalloon();  

												

					}else {
						alert("Location cannot be found.")
					}
				});
				
		{$buttonsOverlay}
		{$zoomPan}
	
//]]>
</script>
mapCode;
print_r($mapInfo);
	}
}

// Instantiate our class
$wpYandexMaps = new wpYandexMaps();


/**
 * Add filters and actions
 */
if ( !get_option('wpYandexMaps_api_key') && !isset($_POST['submit']) ) {
	// Add the warning notice if the yandex API Key isn't set
	add_action('admin_notices', array($wpYandexMaps, 'warning'));    
} else {
	
	// Process shortCodes and include JavaScript if the yandex API Key is set
	add_filter('the_posts', array($wpYandexMaps, 'findMaps'));
	add_action('wp_print_scripts', array($wpYandexMaps, 'wpHead'));
	add_shortcode('yandexMap', array($wpYandexMaps, 'handleShortcodes'));
}
add_filter('admin_print_scripts', array($wpYandexMaps, 'adminHead'));
add_action('admin_menu', array($wpYandexMaps, 'adminMenu'));

add_filter('whitelist_options','yandexMaps_alter_whitelist_options');

function yandexMaps_alter_whitelist_options($whitelist) {
if(is_array($whitelist)) {
	$option_array = array('yandex-maps' => array('wpYandexMaps_api_key'));
	$whitelist = array_merge($whitelist,$option_array);
}
return $whitelist;
}
?>