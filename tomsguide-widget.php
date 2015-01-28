<?php
/*
Plugin Name: Tom's Guide Download
Plugin URI: http://www.tomsguide.com/widgets/
Description: Display the download contents from Tom's Guide
Author: Best of Media
Author URI: http://www.tomsguide.com/
Version: 1.0.5
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

define ('TGU_SYNDICATION_URL','http://syndication.bestofmedia.com/');
define('TGU_PLUGIN_URL', plugin_dir_url( __FILE__ ));
$tguDefaultWidgetOption = array(
    'dldSource' => '',
    'baseSyndicationUrl' => TGU_SYNDICATION_URL,
    'widgetWidth' => 202,
    'widgetHeight' => 'auto',
    'widgetTitle' => __('Software Download'),
    'os' => '',
    'dldCateg' => null,
    'dldSort' => 'most-popular',
    'nbItemsLimit' => 10,
    'contentUrl' => TGU_SYNDICATION_URL.'download/v1/software/index',
    'titleBackgroundColor' => '#206FB1',
    'titleColor' => '#ffffff',
    'listColor' => '#004488',
    'listBackgroundColor' => '#ffffff',
    'borderRadius' => '',
    'arrowColor' => '#00000'
    );

include_once dirname( __FILE__ ) . '/statics.php';
include_once dirname( __FILE__ ) . '/widget.php';
if ( is_admin() ){
	require_once dirname( __FILE__ ) . '/control.php';
	require_once dirname( __FILE__ ) . '/admin.php';
}

function tomsguideWidget_init()
{
  global $tguDefaultWidgetOption;
    if ( function_exists( 'wp_register_sidebar_widget' ) ) {
      wp_register_script('bomwidgetjs', TGU_PLUGIN_URL.'js/widgets.js');
      wp_register_style('bomwidgetstyle', TGU_PLUGIN_URL.'css/widgets_style.css');
      wp_enqueue_script('bomwidgetjs');
      wp_enqueue_style('bomwidgetstyle');

      $prefix = 'tomsguide-widget'; // $id prefix
      $name = __('Tom\'s Guide Download', 'tomsguide-widget');
      //update_option("widget_tomsguideDownload", array());
      $defaultOptions = get_option('widget_defaultTomsguideDownload');
      if(!is_array($defaultOptions)){ //save defaultOptions
        $defaultOptions = $tguDefaultWidgetOption;
        update_option('widget_defaultTomsguideDownload', $defaultOptions);
      }

      $options = get_option('widget_tomsguideDownload');
      if(isset($options[0])) unset($options[0]);
      tguLoadPluginTextdomain();
      //var_dump($options);
      if(!empty($options)){
        if(isset($_POST['delete_widget']) && isset($_POST['widget-id'])){ //delete unused widgets
          $deted_widget_number = (int)str_replace($prefix."-","",$_POST['widget-id']);
          unset($options[$deted_widget_number]);
          update_option('widget_tomsguideDownload', $options);
        }
        foreach(array_keys($options) as $widget_number){
          //echo $widget_number;
          wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_tomsguideDownload',  array('description'=> __('Display the download contents from Tom\'s Guide','tomsguide-widget')), array( 'number' => $widget_number ));
          wp_register_widget_control($prefix.'-'.$widget_number, $name, 'tomsguideWidget_control', array('id_base'=>$prefix), array( 'number' => $widget_number ));
        }
      } else {
        //echo "?".$widget_number;
        $options = array();
        $widget_number = 1;
        wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'widget_tomsguideDownload',  array('description'=> __('Display the download contents from Tom\'s Guide','tomsguide-widget')), array( 'number' => $widget_number ));
        wp_register_widget_control($prefix.'-'.$widget_number, $name, 'tomsguideWidget_control', array('id_base'=>$prefix), array( 'number' => $widget_number ));
      }

    }
  if ( is_admin() ){
    add_action('admin_menu','add_tomsguide_widget_admin');
  }

}
if(!function_exists('tguLoadPluginTextdomain')){
  function tguLoadPluginTextdomain() {
    load_plugin_textdomain('tomsguide-widget',false,dirname( plugin_basename( __FILE__ ) ) .'/languages');
  }
}

if(!function_exists('tguWidget_update')){
	function tguWidget_update($id_prefix, $options, $post, $sidebar, $option_name = ''){
		global $wp_registered_widgets;
		static $updated = false;

		// get active sidebar
		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		// search unused options
		foreach ( $this_sidebar as $_widget_id ) {
			if(preg_match('/'.$id_prefix.'-([0-9]+)/i', $_widget_id, $match)){
				$widget_number = $match[1];

				// $_POST['widget-id'] contain current widgets set for current sidebar
				// $this_sidebar is not updated yet, so we can determine which was deleted
				if(!in_array($match[0], $_POST['widget-id'])){
					unset($options[$widget_number]);
				}
			}
		}

		// update database
		if(!empty($option_name)){
			update_option($option_name, $options);
			$updated = true;
		}

		// return updated array
		return $options;
	}
}


add_action("plugins_loaded", "tomsguideWidget_init");

/* L10N */

add_action( 'init', 'tguLoadPluginTextdomain' );


?>
