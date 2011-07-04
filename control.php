<?php
function tomsguideWidget_control($args) //WIDGET CONTROLER on WP Widgets panel
{
  global $arrOs, $arrCateg;
  $prefix = 'tomsguide-widget';
  $options = get_option("widget_tomsguideDownload");
  $defaultOptions = get_option('widget_defaultTomsguideDownload');
  if(empty($options)) $options = array();
	if(isset($options[0])) unset($options[0]);
  
  // update options array
	if(!empty($_POST[$prefix]) && is_array($_POST)){
		foreach($_POST[$prefix] as $widget_number => $values){
			if(empty($values) && isset($options[$widget_number])) // user clicked cancel
				continue;
 
			if(!isset($options[$widget_number]) && $args['number'] == -1){
				$args['number'] = $widget_number;
				//$options['last_number'] = $widget_number;
			}
			$options[$widget_number] = $values;
		}
 
		// update number
		if($args['number'] == -1 ){
			$args['number'] = 1;
		}
 
		// clear unused options and update options in DB. return actual options array
		$options = tguWidget_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'widget_tomsguideDownload');
	}
  
  
  
  $widget_number = ($args['number'] == -1)?'%i%':$args['number'];
  $opts = array_merge($defaultOptions,is_array($options[$widget_number])?$options[$widget_number]:array());
  //$options[$widget_number] = array_merge($defaultOptions,is_array($getOptions)?$getOptions:array());
  //var_dump($args['number']);
  //var_dump($options);
?>
  <p>
    <label for="widgetTitle-<?php echo $widget_number; ?>"><?php echo __('Widget Title','tomsguide-widget'); ?>: </label><br/>
    <input class="widefat" type="text" id="widgetTitle-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[widgetTitle]'; ?>" value="<?php echo stripslashes($opts['widgetTitle']);?>" />
  </p>
  <p>
    <label for="os-<?php echo $widget_number; ?>"><?php _e('Operating System','tomsguide-widget'); ?>: </label><br/>
    <select class="widefat" id="os-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[os]'; ?>">
      <option value=""<?php echo $opts['os']==""?" selected=\"selected\"":""; ?>><?php _e('All','tomsguide-widget'); ?></option>
      <?php foreach ($arrOs as $Os){ ?>
      <option value="<?php echo $Os; ?>"<?php echo $opts['os']==$Os?" selected=\"selected\"":""; ?>><?php echo $Os; ?></option>
      <?php } ?>
    </select>
  </p>
  <p>
    <label for="dldSource-<?php echo $widget_number; ?>"><?php _e('Content language','tomsguide-widget'); ?>: </label><br/>
    <select class="widefat" id="dldSource-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[dldSource]'; ?>">
      <option value="">English</option>
      <option value="fr_FR"<?php echo $opts['dldSource']=="fr_FR"?" selected=\"selected\"":""; ?>>Français</option>
    </select>
  </p>
  <p id="categField-<?php echo $widget_number; ?>"<?php echo $opts['dldSource']=="fr_FR"?" style=\"display:none\"":""; ?>>
    <label for="dldCateg-<?php echo $widget_number; ?>"><?php _e('Category','tomsguide-widget'); ?>: </label><br/>
    <select class="widefat" id="dldCateg-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[dldCateg]'; ?>"<?php echo $opts['dldSource']=="fr_FR"?" disabled=\"disabled\"":""; ?>>
      <option value=""><?php _e('All','tomsguide-widget'); ?></option>
      <?php foreach ($arrCateg[''] as $categ){ ?>
      <option value="<?php echo $categ['id']; ?>"<?php echo $opts['dldCateg']==$categ['id']?" selected=\"selected\"":""; ?>><?php echo $categ['label']; ?></option>
      <?php } ?>
    </select>
  </p>
  <p id="categField-fr_FR-<?php echo $widget_number; ?>"<?php echo $opts['dldSource']!="fr_FR"?" style=\"display:none\"":""; ?>>
    <label for="dldCateg-fr_FR-<?php echo $widget_number; ?>"><?php _e('Category','tomsguide-widget'); ?>: </label><br/>
    <select class="widefat" id="dldCateg-fr_FR-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[dldCateg]'; ?>"<?php echo $opts['dldSource']!="fr_FR"?" disabled=\"disabled\"":""; ?>>
      <option value=""><?php _e('All','tomsguide-widget'); ?></option>
      <?php foreach ($arrCateg['fr_FR'] as $categ){ ?>
      <option value="<?php echo $categ['id']; ?>"<?php echo $opts['dldCateg']==$categ['id']?" selected=\"selected\"":""; ?>><?php echo $categ['label']; ?></option>
      <?php } ?>
    </select>
  </p>
  <script type="text/javascript">
    jQuery('#dldSource-<?php echo $widget_number; ?>').live('change',function(){
      if(jQuery(this).val() != ''){
        jQuery('#categField-<?php echo $widget_number; ?>').hide();
        jQuery('#dldCateg-<?php echo $widget_number; ?>').attr('disabled','disabled');
        jQuery('#categField-fr_FR-<?php echo $widget_number; ?>').show();
        jQuery('#dldCateg-fr_FR-<?php echo $widget_number; ?>').removeAttr('disabled');
      } else {
        jQuery('#categField-<?php echo $widget_number; ?>').show();
        jQuery('#dldCateg-<?php echo $widget_number; ?>').removeAttr('disabled');
        jQuery('#categField-fr_FR-<?php echo $widget_number; ?>').hide();
        jQuery('#dldCateg-fr_FR-<?php echo $widget_number; ?>').attr('disabled','disabled');
      }
    });
  </script>
  <p>
    <label for="dldSort-<?php echo $widget_number; ?>"><?php _e('Sort by','tomsguide-widget'); ?>: </label><br/>
    <select class="widefat" id="dldSort-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[dldSort]'; ?>">
      <option value="most-popular" <?php echo ($opts['dldSort'] == "most-popular")?" selected=\"selected\"":"";?>><?php _e('Most popular','tomsguide-widget'); ?></option>
      <option value="nearest-first" <?php echo ($opts['dldSort'] == "nearest-first")?" selected=\"selected\"":"";?>><?php _e('Newest','tomsguide-widget'); ?></option>
      <option value="best-increase" <?php echo ($opts['dldSort'] == "best-increase")?" selected=\"selected\"":"";?>><?php _e('Most downloaded this week','tomsguide-widget'); ?></option>
    </select>
  </p>
  <p>
    <label for="nbItemsLimit-<?php echo $widget_number; ?>"><?php _e('Number of softwares','tomsguide-widget'); ?>: </label><br/>
    <select id="nbItemsLimit-<?php echo $widget_number; ?>" name="<?php echo $prefix.'['.$widget_number.']'.'[nbItemsLimit]'; ?>">
      <option value="5" <?php echo ($opts['nbItemsLimit'] == 5)?" selected=\"selected\"":"";?>>5</option>
      <option value="10" <?php echo ($opts['nbItemsLimit'] == 10 || $opts['nbItemsLimit'] == "")?" selected=\"selected\"":"";?>>10</option>
      <option value="15" <?php echo ($opts['nbItemsLimit'] == 15)?" selected=\"selected\"":"";?>>15</option>
      <option value="20" <?php echo ($opts['nbItemsLimit'] == 20)?" selected=\"selected\"":"";?>>20</option>
    </select>
  </p>
<?php
}
?>