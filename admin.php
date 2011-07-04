<?php
function tomsguideWidget_admin() //WIDGET ADMIN PANEL
{ 
  global $tguDefaultWidgetOption, $arrOs, $arrCateg, $submenu;
  
  $prefix = 'tomsguide-widget';
  $options = get_option('widget_tomsguideDownload');
  $defaultOptions = get_option('widget_defaultTomsguideDownload');
  
  if(empty($options)) $options = array();
	if(isset($options[0])) unset($options[0]);
  $widgetSelected = $_GET['widget_number'];
  // update options array
	if(is_array($_POST) && isset($_POST['submit'])){
    if($widgetSelected != ""){
			$options[$widgetSelected] = $_POST;
      // update active widget
      update_option('widget_tomsguideDownload', $options);
    } else {
      // update default options
       $defaultOptions = $_POST;
       update_option('widget_defaultTomsguideDownload', array_merge($tguDefaultWidgetOption,$defaultOptions));
    }
	}
  
?>
  <div class="wrap">
    <div class="icon32" id="icon-options-general"><br/></div>
    <h2><?php _e('Tom\'s Guide Widget Admin', 'trans_domain'); ?> </h2>
    <?php if($widgetSelected == "" || count($options) < 1) { //home admin
    if(count($options) >= 1){ //some widgets are active ?>
    <h3><?php _e('Customize an active widget','tomsguide-widget'); ?></h3>
    <select id="selectWidget">
    <?php foreach ($options as $key =>$widget){ ?>
      <option value="<?php echo $key; ?>"><?php echo stripslashes($widget['widgetTitle']); ?></option>
    <?php } ?>
    </select>
    <input id="goWidget" class="button-secondary" type="button" name="submit" value="<?php _e('Go'); ?>" />
    <script type="text/javascript">
      jQuery('#goWidget').click(function(){
        document.location.href = '<?php echo $_SERVER['PHP_SELF']; ?>?page=tgu&widget_number='+jQuery('#selectWidget').val();
      });
    </script>
    <p><?php _e('Or','tomsguide-widget'); ?></p>
    <?php }
    $opts = $defaultOptions;
    ?>
    <h3><?php _e('Change your default widget settings','tomsguide-widget'); ?></h3>
    <?php } else { 
    $opts = array_merge($defaultOptions,is_array($options[$widgetSelected])?$options[$widgetSelected]:array());?>
    <h3><?php _e('Customize your Download Widget','tomsguide-widget'); ?></h3>
    <?php } ?>
    <form id="widgetGenerator" class="bomWidgetGenerator" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
      <ul id="custom-widgetnav" class="bomWidgetCustomNav">
        <li class="tab current"><a href="#fragment-1"><?php _e('Preferences','tomsguide-widget'); ?></a></li>
        <li class="tab"><a href="#fragment-2"><?php _e('Appearence','tomsguide-widget'); ?></a></li>
        <li class="tab"><a href="#fragment-3"><?php _e('Dimensions','tomsguide-widget'); ?></a></li>
      </ul>
      <div id="fragment-1" class="panel panel-preferences">
        <p class="spaceT0">
          <label for="widgetTitle"><strong><?php echo __('Widget Title','tomsguide-widget'); ?>: </strong></label><br/>
          <input type="text" id="widgetTitle" name="widgetTitle" value="<?php echo stripslashes($opts['widgetTitle']);?>" />
        </p>
        <p>
          <label for="os"><strong><?php _e('Operating System','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="os" name="os">
            <option value=""<?php echo $opts['os']==""?" selected=\"selected\"":""; ?>"><?php _e('All','tomsguide-widget'); ?></option>
            <?php foreach ($arrOs as $Os){ ?>
            <option value="<?php echo $Os; ?>"<?php echo $opts['os']==$Os?" selected=\"selected\"":""; ?>><?php echo $Os; ?></option>
            <?php } ?>
          </select>
        </p>
        <p>
          <label for="dldSource"><strong><?php _e('Content language','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="dldSource" name="dldSource">
            <option value="">English</option>
            <option value="fr_FR"<?php echo $opts['dldSource']=="fr_FR"?" selected=\"selected\"":""; ?>>Français</option>
          </select>
        </p>
        <p id="categField"<?php echo $opts['dldSource']=="fr_FR"?" style=\"display:none\"":""; ?>>
          <label for="dldCateg"><strong><?php _e('Category','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="dldCateg" name="dldCateg"<?php echo $opts['dldSource']=="fr_FR"?" disabled=\"disabled\"":""; ?>>
            <option value=""><?php _e('All','tomsguide-widget'); ?></option>
            <?php foreach ($arrCateg[''] as $categ){ ?>
            <option value="<?php echo $categ['id']; ?>"<?php echo $opts['dldCateg']==$categ['id']?" selected=\"selected\"":""; ?> rel="<?php echo $categ['slug']; ?>"><?php echo $categ['label']; ?></option>
            <?php } ?>
          </select>
        </p>
        <p id="categField-fr_FR"<?php echo $opts['dldSource']!="fr_FR"?" style=\"display:none\"":""; ?>>
          <label for="dldCateg-fr_FR"><strong><?php _e('Category','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="dldCateg-fr_FR" name="dldCateg"<?php echo $opts['dldSource']!="fr_FR"?" disabled=\"disabled\"":""; ?>>
            <option value=""><?php _e('All','tomsguide-widget'); ?></option>
            <?php foreach ($arrCateg['fr_FR'] as $categ){ ?>
            <option value="<?php echo $categ['id']; ?>"<?php echo $opts['dldCateg']==$categ['id']?" selected=\"selected\"":""; ?> rel="<?php echo $categ['slug']; ?>"><?php echo $categ['label']; ?></option>
            <?php } ?>
          </select>
        </p>
        <script type="text/javascript">
          jQuery('#dldSource').live('change',function(){
            if(jQuery(this).val() != ''){
              jQuery('#categField').hide();
              jQuery('#dldCateg').attr('disabled','disabled');
              jQuery('#categField-fr_FR').show();
              jQuery('#dldCateg-fr_FR').removeAttr('disabled');
            } else {
              jQuery('#categField').show();
              jQuery('#dldCateg').removeAttr('disabled');
              jQuery('#categField-fr_FR').hide();
              jQuery('#dldCateg-fr_FR').attr('disabled','disabled');
            }
          });
        </script>
        <p>
          <label for="dldSort"><strong><?php _e('Sort by','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="dldSort" name="dldSort">
            <option value="most-popular" <?php echo ($opts['dldSort'] == "most-popular")?" selected=\"selected\"":"";?>><?php _e('Most popular','tomsguide-widget'); ?></option>
            <option value="nearest-first" <?php echo ($opts['dldSort'] == "nearest-first")?" selected=\"selected\"":"";?>><?php _e('Newest','tomsguide-widget'); ?></option>
            <option value="best-increase" <?php echo ($opts['dldSort'] == "best-increase")?" selected=\"selected\"":"";?>><?php _e('Most downloaded this week','tomsguide-widget'); ?></option>
          </select>
        </p>
        <p>
          <label for="nbItemsLimit"><strong><?php _e('Number of softwares','tomsguide-widget'); ?>: </strong></label><br/>
          <select id="nbItemsLimit" name="nbItemsLimit">
            <option value="5" <?php echo ($opts['nbItemsLimit'] == 5)?" selected=\"selected\"":"";?>>5</option>
            <option value="10" <?php echo ($opts['nbItemsLimit'] == 10 || $opts['nbItemsLimit'] == "")?" selected=\"selected\"":"";?>>10</option>
            <option value="15" <?php echo ($opts['nbItemsLimit'] == 15)?" selected=\"selected\"":"";?>>15</option>
            <option value="20" <?php echo ($opts['nbItemsLimit'] == 20)?" selected=\"selected\"":"";?>>20</option>
          </select>
        </p>
      
      </div>
      <div id="fragment-2" class="panel" style="display:none">
        <h3 class="spaceT0"><?php _e('Colors','tomsguide_widget'); ?></h3>
          <div class="spaceB20 bomColorFieldset">
              <p>
                <label for="titleBackgroundColor" class="label "><?php _e('Title background color','tomsguide-widget'); ?></label> <input type="text" name="titleBackgroundColor" id="titleBackgroundColor" class=" inputText bomColorField nopreview" value="<?php echo $opts['titleBackgroundColor']; ?>" /> <span class=" bomColorBox" rel=".bomWidgetWrapper .bomWidgetTitle|background-color"></span>
                <div class="clear"></div>
              </p>
              <p>
                <label for="titleColor" class="label "><?php _e('Title color','tomsguide-widget'); ?></label> <input type="text" name="titleColor" id="titleColor" class=" inputText bomColorField nopreview" value="<?php echo $opts['titleColor']; ?>" /> <span class=" bomColorBox" rel=".bomWidgetWrapper .bomWidgetTitle a|color"></span>
                <div class="clear"></div>
              </p>
              <p>
                <label for="listBackgroundColor" class="label "><?php _e('Text background color','tomsguide-widget'); ?></label> <input type="text" name="listBackgroundColor" id="listBackgroundColor" class=" inputText bomColorField nopreview" value="<?php echo $opts['listBackgroundColor']; ?>" /> <span class=" bomColorBox" rel=".bomWidgetWrapper .bomWidgetContainer|background"></span>
                <div class="clear"></div>
              </p>
              <p>
                <label for="listColor" class="label "><?php _e('Text color','tomsguide-widget'); ?></label> <input type="text" name="listColor" id="listColor" class=" inputText bomColorField nopreview" value="<?php echo $opts['listColor']; ?>" /> <span class=" bomColorBox" rel=".bomWidgetWrapper .bomWidgetList a|color"></span>
                <div class="clear"></div>
            </p>
              <p>
                <label for="arrowColor" class="label "><?php _e('Arrow color','tomsguide-widget'); ?></label> <input type="text" name="arrowColor" id="arrowColor" class=" inputText bomColorField nopreview" value="<?php echo $opts['arrowColor']; ?>" /> <span class=" bomColorBox" rel=".bomWidgetWrapper .bomWidgetPicto |color"></span>
                <div class="clear"></div>
              </p>
          </div>
          <h3><?php _e('Border radius','tomsguide-widget'); ?></h3>
          <select name="borderRadius">
            <option value=""><?php _e('None','tomsguide-widget'); ?></option>
            <option value="3"<?php echo $opts['borderRadius']=="3"?" selected=\"selected\"":""; ?>>3</option>
            <option value="5"<?php echo $opts['borderRadius']=="5"?" selected=\"selected\"":""; ?>>5</option>
            <option value="7"<?php echo $opts['borderRadius']=="7"?" selected=\"selected\"":""; ?>>7</option>
            <option value="10"<?php echo $opts['borderRadius']=="10"?" selected=\"selected\"":""; ?>>10</option>
          </select>
          <p>(<?php _e('Works only on','tomsguide-widget'); ?> Firefox, Safari, Chrome, Internet Explorer9 and Opera10+)</p>
      </div>
      <div id="fragment-3" class="panel" style="display:none">
        <p class="spaceT0">
           <label for="widgetWidth" class=" labelDimension"><?php _e('Width','tomsguide-widget'); ?></label><input type="text" name="widgetWidth" value="<?php echo is_numeric($opts['widgetWidth'])?$opts['widgetWidth']:"200"; ?>" id="widgetWidth" class=" inputText inputDimension nopreview" <?php echo $opts['widgetWidth']=='auto'?"disabled=\"disabled\"":""; ?> />pixels <span class="else"><?php _e('Or','tomsguide-widget'); ?></span>
          <input type="checkbox" name="widgetWidth" value="auto" id="widgetAutoWidth" class="widgetAutoDimension nopreview" rel="widgetWidth"<?php echo $opts['widgetWidth']=='auto'?"checked=\"checked\"":""; ?> /> <label for="widgetAutoWidth"><?php _e('auto width','tomsguide-widget'); ?></label>
        </p>
        <p>
          <label for="widgetHeight" class=" labelDimension"><?php _e('Height','tomsguide-widget'); ?></label><input type="text" name="widgetHeight" value="<?php echo is_numeric($opts['widgetHeight'])?$opts['widgetHeight']:"300"; ?>" id="widgetHeight" class=" inputText inputDimension nopreview" <?php echo $opts['widgetHeight']=='auto'?"disabled=\"disabled\"":""; ?> />pixels <span class="else"><?php _e('Or','tomsguide-widget'); ?></span>

          <input type="checkbox" name="widgetHeight" value="auto" id="widgetAutoHeight" class="widgetAutoDimension nopreview" rel="widgetHeight"<?php echo $opts['widgetHeight']=='auto'?"checked=\"checked\"":""; ?> /> <label for="widgetAutoHeight"><?php _e('auto height','tomsguide-widget'); ?></label>
        </p>
        <p class="btd"><?php _e('Note','tomsguide-widget'); ?>: <?php _e('Widget size won\'t update in preview','tomsguide-widget'); ?>.</p>
      </div>
      <div class="clear"></div>
      <p class="submit"><input class="button-primary" type="submit" name="submit" value="<?php _e('Update options &raquo;'); ?>" /><?php if($widgetSelected != ""){?> <a class="button-secondary" href="<?php echo $_SERVER['PHP_SELF'].'?page=tgu'; ?>"><?php _e('Cancel and return to main page','tomsguide-widget'); ?></a><?php } ?></p>
    </form>
    <div class="bomWidgetPreview">
      <div class="bomWidgetPreviewWrapper">
        <h3><?php _e('Widget preview','tomsguide-widget'); ?></h3>
        <div id="bomWidgetPrevisualization" class="">
        </div>
        <span class="arrow"></span>
      </div>
    </div>
    <div class="clear"></div>
    
    <script type="text/javascript">
      var bomPluginPath = bomPluginPath || '<?php echo TGU_PLUGIN_URL; ?>';
    </script>
    <script type="text/javascript">
      jQuery('#custom-widgetnav a').click(function(){
        jQuery(jQuery(this).attr('href')).show().siblings('.panel').hide();
        jQuery(this).parent().addClass('current').siblings('.tab').removeClass('current');
        return false;
      });
    </script>
  </div>
  
<?php
}
function add_tomsguide_widget_admin(){
  add_submenu_page('plugins.php', __('Tom\'s Guide Widget settings','tomsguide-widget'), __('Tom\'s Guide Widget settings','tomsguide-widget'), 'manage_options', 'tgu', 'tomsguideWidget_admin');
}

function tgu_admin_load_script(){
  wp_register_script('bomwidgetadminjs', TGU_PLUGIN_URL.'js/widgets_config.js');
  wp_register_script('colorpickerjs', TGU_PLUGIN_URL.'js/colorpicker.js');
  wp_register_style('bomwidgetadminstyle', TGU_PLUGIN_URL.'css/widgets_config.css');
  wp_register_style('colorpickerstyle', TGU_PLUGIN_URL.'css/colorpicker.css');
  wp_enqueue_script('bomwidgetadminjs');
  wp_enqueue_script('colorpickerjs');
  wp_enqueue_style('bomwidgetadminstyle');
  wp_enqueue_style('colorpickerstyle');
}

add_action('admin_init', 'tgu_admin_load_script');
?>