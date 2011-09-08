<?php
function widget_tomsguideDownload($args, $vars = array()) { //WIDGET DISPLAYED
  global $arrCateg, $arrHomeDld, $arrSoftwareDld;
  extract($args);
  $prefix = 'tomsguide-widget'; // $id prefix
  $widget_number = (int)str_replace($prefix."-", '', @$widget_id);
  $getOptions = get_option("widget_tomsguideDownload");
  $defaultOptions = get_option('widget_defaultTomsguideDownload');
  $options = array_merge($defaultOptions,is_array($getOptions[$widget_number])?$getOptions[$widget_number]:array());

  $tguListingUrl = $arrHomeDld[$options['dldSource']].$arrSoftwareDld[$options['dldSource']];
  if($options['dldCateg']!= ''){
    $tguListingUrl .= '-'.$arrCateg[$options['dldSource']][$options['dldCateg']]['slug'].',0702-'.$options['dldCateg'].'.html';
  } else {
    $tguListingUrl .= ',0701-5.html';
  }
  echo $before_widget;
  ?>
  <div id="bomWidget<?php echo $widget_number;?>" class="bomWidgetWrapper">
  <h2 class="bomWidgetTitle"><a href="<?php echo $tguListingUrl; ?>"><?php echo stripslashes($options['widgetTitle']);?></a><span class="dash"></span></h2>
  <div class="bomWidgetContainer">
    <ul id="bomWidgetList<?php echo $widget_number;?>" class="bomWidgetList">
    </ul>
  </div>
  <div class="bomWidgetFt">
    <div class="bomWidgetFtWrapper">
      <span>Powered by Tom's Guide</span> <a href="<?php echo $arrHomeDld[$options['dldSource']]?>" class="bomWidgetLogo"><img src="<?php echo plugins_url('/images/', __FILE__) ?>tgu_dld_widget_sprite.png" alt="Tom's Guide"/></a>
    </div>
  </div>
</div>

<script type="text/javascript">
  var bomPluginPath = bomPluginPath || '<?php echo TGU_PLUGIN_URL; ?>';
</script>
<script type="text/javascript">
  var bomWidget = bomWidget || [];
  bomWidget[<?php echo $widget_number;?>] = new BOM.Widget({
    'idWidget' : '<?php echo $widget_number;?>'
<?php echo($options['widgetWidth']!=200 && is_numeric($options['widgetWidth']))?', \'widgetWidth\': '.$options['widgetWidth']:''; ?>
<?php echo($options['widgetWidth']=='auto')?', \'widgetWidth\':\'auto\'':''; ?>
<?php echo($options['widgetHeight']!=300 && is_numeric($options['widgetHeight']))?', \'widgetHeight\': '.$options['widgetHeight']:''; ?>
<?php echo$options['os']!=''?', \'os\': \''.$options['os'].'\'':''; ?>
<?php echo$options['dldCateg']!=''?', \'dldCateg\': '.$options['dldCateg']:''; ?>
<?php echo$options['dldSort']!=''?', \'dldSort\': \''.$options['dldSort'].'\'':''; ?>
<?php echo$options['nbItemsLimit']!=10?', \'nbItemsLimit\': '.$options['nbItemsLimit']:''; ?>
<?php echo$options['titleBackgroundColor']!='#206FB1'?', \'titleBackgroundColor\': \''.$options['titleBackgroundColor'].'\'':''; ?>
<?php echo$options['titleColor']!='#fff'?', \'titleColor\':  \''.$options['titleColor'].'\'':''; ?>
<?php echo$options['listBackgroundColor']!='#fff'?', \'listBackgroundColor\': \''.$options['listBackgroundColor'].'\'':''; ?>
<?php echo$options['listColor']!='#048'?', \'listColor\': \''.$options['listColor'].'\'':''; ?>
<?php echo$options['borderRadius']!=''?', \'borderRadius\': '.$options['borderRadius']:''; ?>
<?php echo$options['arrowColor']!='#000'?', \'arrowColor\': \''.$options['arrowColor'].'\'':''; ?>
  });
</script>
<?php  echo $after_widget;
}

?>