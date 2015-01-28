/*
BOM Widget Configurator Page
*/


var dldIdSite = dldIdSite || 20;
var softwareLang = [];
softwareLang[20] = 'Logiciels';
softwareLang[21] = 'Software';
var dldBaseUrl = [];
dldBaseUrl[20] = 'http://telecharger.tomsguide.fr/';
dldBaseUrl[21] = 'http://downloads.tomsguide.com/';
jQuery(document).ready(function() {
  /*Color pickers */
  var allBomColorBox = jQuery('.bomColorBox');
  for(var i = 0; i < allBomColorBox.length; i++){
    var bomCurrentColorBox = jQuery(allBomColorBox[i]);
    bomCurrentColorBox.css('background-color',bomCurrentColorBox.prev('.bomColorField').val());
  }
  allBomColorBox.ColorPicker({
    onBeforeShow: function(){
      jQuery(this).ColorPickerSetColor(jQuery(this).prev('.bomColorField').val());
    },
    onShow: function(colorpicker){
      jQuery(colorpicker).slideDown();
      return false;
    },
    onChange : function(hsb,hex,rgb){
      var el = jQuery(this.data('colorpicker').el);
      el.css('backgroundColor','#'+hex).prev('.bomColorField').val('#'+hex);
      var relatedItem = el.attr('rel').split('|');
      jQuery(relatedItem[0]).css(relatedItem[1],'#'+hex);
    },
    onHide:function(colorpicker){
      jQuery('#widgetGenerator').trigger('configChanged',true);
    },
    onSubmit:function(a,b,c,el){
      jQuery(el).ColorPickerHide();
    }
  });
  jQuery('.bomColorField').bind('focus',function(){
    jQuery(this).next('.bomColorBox').ColorPickerShow();
  });

  jQuery('.arrowColorInput').bind('click',function(){
    if(jQuery(this).get(0).checked){
      jQuery('.bomWidgetWrapper .bomWidgetPicto').css('backgroundPosition',(jQuery(this).val()=='black'?'0':'-8px')+' -15px');
    }
  });

  /*dimensions input*/
  jQuery('.widgetAutoDimension').bind('click',function(){
    if(this.checked){
      jQuery('#'+jQuery(this).attr('rel')).attr('disabled',true);
    } else {
        jQuery('#'+jQuery(this).attr('rel')).removeAttr('disabled');
    }
  });


  /* update code */
  jQuery('#widgetGenerator').bind('configChanged',function(event,noupdate){
    var formParams = jQuery('#widgetGenerator').serializeArray();
    var formData = {};
    for (var i = 0; i< formParams.length; i++){
      formData[formParams[i].name] = formParams[i].value || '';
    }
    var now = new Date();
    var randomId = now.getTime();
    var dldIdSite = formData.dldSource !=''?20:21;
    var categId = '#dldCateg'+(formData.dldSource!=''?'-':'')+formData.dldSource;
    var tguListingUrl = dldBaseUrl[dldIdSite]+softwareLang[dldIdSite];
    if(jQuery(categId).val()!=''){
      console.log(jQuery(categId+' option:eq('+jQuery(categId).get(0).selectedIndex+')'));
      tguListingUrl += '-'+jQuery(categId+' option:eq('+jQuery(categId).get(0).selectedIndex+')').attr('rel')+',0702-'+formData.dldCateg+'.html';
    } else {
      tguListingUrl += ',0701-5.html';
    }
    var outputCode = '<div id="bomWidget'+randomId+'" class="bomWidgetWrapper">\n'+
'  <h2 class="bomWidgetTitle"><a href="'+tguListingUrl+'">'+htmlEncode(formData.widgetTitle)+'</a><span class="dash"></span></h2>\n'+
'  <div class="bomWidgetContainer">\n'+
'    <ul id="bomWidgetList'+randomId+'" class="bomWidgetList">\n'+
'    </ul>\n'+
'  </div>\n'+
'  <div class="bomWidgetFt"><div class="bomWidgetFtWrapper"><span>Powered by Tom\'s Guide</span> <a href="'+dldBaseUrl[dldIdSite]+'" class="bomWidgetLogo"><img src="'+bomPluginPath+'images/tgu_dld_widget_sprite.png" alt="Tom\'s Guide"/></a></div></div>\n'+
'</div>\n'+
'<script type="text/javascript">\n'+
'  var bomWidget = bomWidget || [];\n'+
'  bomWidget['+randomId+']=(new BOM.Widget({\n'+
'    \'idWidget\' : \''+randomId+'\''+
((formData.widgetWidth!=200 && !isNaN(parseInt(formData.widgetWidth)))?',\n    \'widgetWidth\': '+parseInt(formData.widgetWidth):'')+
((formData.widgetWidth=='auto')?',\n    \'widgetWidth\':\'auto\'':'')+
((formData.widgetHeight!=300 && !isNaN(parseInt(formData.widgetHeight)))?',\n    \'widgetHeight\': '+parseInt(formData.widgetHeight):'')+
(formData.os!=''?',\n    \'os\': \''+formData.os+'\'':'')+
(formData.dldCateg!=''?',\n    \'dldCateg\': '+formData.dldCateg:'')+
(formData.dldSort!=''?',\n    \'dldSort\': \''+formData.dldSort+'\'':'')+
(formData.nbItemsLimit!=10?',\n    \'nbItemsLimit\': '+formData.nbItemsLimit:'')+
(formData.titleBackgroundColor!='#206FB1'?',\n    \'titleBackgroundColor\': \''+formData.titleBackgroundColor+'\'':'')+
(formData.titleColor!='#fff'?',\n    \'titleColor\':  \''+formData.titleColor+'\'':'')+
(formData.listBackgroundColor!='#fff'?',\n    \'listBackgroundColor\': \''+formData.listBackgroundColor+'\'':'')+
(formData.listColor!='#048'?',\n    \'listColor\': \''+formData.listColor+'\'':'')+
(formData.borderRadius!=''?',\n    \'borderRadius\': '+formData.borderRadius:'')+
(formData.arrowColor!='#000'?',\n    \'arrowColor\': \''+formData.arrowColor+'\'':'')+
'\n  }));\n'+
'</script>';
    if(!noupdate) jQuery('#bomWidgetPrevisualization').html(outputCode);

  });

  jQuery('#widgetGenerator select,#widgetGenerator input').bind('change',function(){
    jQuery('#widgetGenerator').trigger('configChanged',jQuery(this).hasClass('nopreview'));
  });




  jQuery('#widgetGenerator').trigger('configChanged');
});


function htmlEncode(value){
  return jQuery('<div/>').text(value).html();
}

function htmlDecode(value){
  return jQuery('<div/>').html(value).text();
}
