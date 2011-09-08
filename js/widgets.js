/*Widget BOM */

var baseSyndicationUrl = 'http://syndication.bestofmedia.com/';

var BOM = BOM || {};
BOM.Widget = function(params){
  this.params = {
    'baseSyndicationUrl':baseSyndicationUrl,
    'widgetWidth': 202,
    'widgetHeight': 'auto',
    'widgetTitle': 'Software Download',
    'os':'',
    'dldCateg':null,
    'dldSort':'most-popular',
    'nbItemsLimit':10,
    'contentUrl':baseSyndicationUrl+'download/v1/software/index',
    'titleBackgroundColor': '#206FB1',
    'titleColor': '#ffffff',
    'listColor':'#004488',
    'listBackgroundColor':'#ffffff',
    'borderRadius':'',
    'arrowColor':'#000000'
  };
  this.init = function(params){
    this.params.idWidget = params.idWidget || '';
    this.params.widgetWidth = params.widgetWidth || this.params.widgetWidth;
    this.params.widgetHeight = params.widgetHeight || this.params.widgetHeight;
    this.params.widgetTitle = params.widgetTitle || this.params.widgetTitle;
    this.params.os = params.os || this.params.os;
    this.params.dldCateg = params.dldCateg || this.params.dldCateg;
    this.params.dldSort = params.dldSort || this.params.dldSort;
    this.params.titleBackgroundColor = params.titleBackgroundColor || this.params.titleBackgroundColor;
    this.params.titleColor = params.titleColor || this.params.titleColor;
    this.params.listBackgroundColor = params.listBackgroundColor || this.params.listBackgroundColor;
    this.params.listColor = params.listColor || this.params.listColor;
    this.params.borderRadius = params.borderRadius || this.params.borderRadius;
    this.params.arrowColor = params.arrowColor || this.params.arrowColor;
    this.params.nbItemsLimit = params.nbItemsLimit || this.params.nbItemsLimit;
    this.params.contentUrl = isNaN(params.dldCateg)? this.params.contentUrl: baseSyndicationUrl+'download/v1/software/category/'+params.dldCateg;
    this.widgetWrapper = document.getElementById('bomWidget'+this.params.idWidget);
    this.style();
  };
  this.style = function (){
    this.setBrowserClassName();
    var bomWidgetListId = '#bomWidget'+this.params.idWidget;
    var style = document.createElement('style');
    style.type = 'text/css';
    
    var output = bomWidgetListId+'{';
    output += '    width:'+((this.params.widgetWidth=='auto')?'auto':(this.params.widgetWidth+'px'))+';';
    output += '    -webkit-border-radius:'+this.params.borderRadius+'px;';
    output += '    -moz-border-radius:'+this.params.borderRadius+'px;';
    output += '    border-radius:'+this.params.borderRadius+'px;';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetTitle{';
    output += '    background-color:'+this.params.titleBackgroundColor+';';
    output += '    color:'+this.params.titleColor+';';
    output += '    margin:0;';
    output += '    position:relative;';
    output += '    font-size:17px;';
    output += '    padding:5px 10px 13px;';
    output += '    -webkit-border-radius:'+this.params.borderRadius+'px '+this.params.borderRadius+'px 0 0;';
    output += '    -moz-border-radius:'+this.params.borderRadius+'px '+this.params.borderRadius+'px 0 0;';
    output += '    border-radius:'+this.params.borderRadius+'px '+this.params.borderRadius+'px 0 0;';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetTitle .dash{';
    output += '    position:absolute;';
    output += '    bottom:0;';
    output += '    left:0;';
    output += '    height:7px;';
    output += '    width:100%;';
    output += '    display:block;';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetTitle a{';
    output += '    color:'+this.params.titleColor+';';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetList a{';
    output += '    color:'+this.params.listColor+';';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetTitle .dash,.bomWidgetWrapper .bomWidgetFt{';
    output += '    background-image: url("'+bomPluginPath+'images/tgu_dld_widget_sprite.png");';
    output += '  }';
    output += '.bomWidgetWrapper{';
    output += '    font-family:Arial,Helvetica,sans-serif;';
    output += '  }';
    output += bomWidgetListId+'.ie6 .bomWidgetTitle{';
    output += '    padding-bottom:5px;';
    output += '  }';
    output += bomWidgetListId+'.ie6 .bomWidgetTitle .dash{';
    output += '    display:none;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetTitle a{';
    output += '    text-decoration:none;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetTitle a:hover{';
    output += '    text-decoration:underline;';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetContainer{    ';
    output += '    border:1px solid #dcdcdc;';
    output += '    border-top:0;';
    output += '    padding:5px 7px;';
    output += '    background:'+this.params.listBackgroundColor+';';
    output += '  }';
    output += bomWidgetListId+' .bomWidgetList{';
    output += '    margin:0;';
    output += '    padding:0;';
    output += '    list-style-type:none;';
    if(this.params.widgetHeight != 'auto'){
      output += '    height:'+this.params.widgetHeight+'px;';
      output += '   overflow-y:auto';
    }
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetList li{';
    output += '    border-bottom:1px dotted #c1c1c1;';
    output += '    font-size:12px;';
    output += '    padding:3px 0 5px 2px;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetList li.bomWidgetLastItem{';
    output += '    border-bottom:0;';
    output += '  }';
    output += '.bomWidgetWrapper  .bomWidgetList a{';
    output += '    text-decoration:none;';
    output += '    display:block;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetList a .bomWidgetPicto{';
    output += '    font-size:15px;';
    output += '    font-family:tahoma;';
    output += '    margin-right:5px;';
    output += '    color:'+this.params.arrowColor+';';
    output += '  }';
    output += bomWidgetListId+'.ie6 .bomWidgetList a .bomWidgetPicto, '+bomWidgetListId+'.ie7 .bomWidgetList a .bomWidgetPicto{';
    output += '    display: inline-block;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetList a:hover .bomWidgetLabel{';
    output += '    text-decoration:underline;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetFt{';
    output += '    border-style:solid;';
    output += '    border-width:0 1px 1px 1px;';
    output += '    border-color:#dcdcdc #dcdcdc #ffffff #dcdcdc;';
    output += '    height:34px;';
    output += '    font-size:11px;';
    output += '    padding:1px 7px 0;';
    output += '    margin:0;';
    output += '    overflow:hidden;';
    output += '    background-color:#fff;';
    output += '    background-position:0 -70px;';
    output += '    background-repeat:repeat-x;';
    output += '    -webkit-border-radius:0 0 '+this.params.borderRadius+'px '+this.params.borderRadius+'px;';
    output += '    -moz-border-radius:0 0 '+this.params.borderRadius+'px '+this.params.borderRadius+'px;';
    output += '    border-radius:0 0 '+this.params.borderRadius+'px '+this.params.borderRadius+'px;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetFt .bomWidgetFtWrapper{';
    output += '    position:relative;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetFt .bomWidgetLogo{';
    output += '    color:#000;';
    output += '    display:block;';
    output += '    overflow:hidden;';
    output += '    height:34px;';
    output += '    float:left;';
    output += '    width:116px;';
    output += '    text-decoration:none;';
    output += '    position:absolute;';
    output += '    top:0;';
    output += '    left:61px;';
    output += '  }';
    output += bomWidgetListId+'.ie6 .bomWidgetFt .bomWidgetLogo{';
    output += '    left:-61px;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetFt .bomWidgetLogo img{';
    output += '    position:absolute;';
    output += '    top:-32px;';
    output += '    left:0;';
    output += '    border:none;';
    output += '  }';
    output += '.bomWidgetWrapper .bomWidgetFt span{';
    output += '    float:left;';
    output += '    line-height:34px;';
    output += '  }';
    
    if (style.styleSheet) style.styleSheet.cssText = output;
    else style.appendChild(document.createTextNode(output));
        
    this.widgetWrapper.parentNode.insertBefore(style,this.widgetWrapper);
    /* set border radius manually for ie9*/
    if(this.widgetWrapper.className.match(/ie9/gi)){
      this.widgetWrapper.style.borderRadius = this.params.borderRadius+'px';
      this.widgetWrapper.getElementsByClassName('bomWidgetTitle')[0].style.borderRadius = this.params.borderRadius+'px '+this.params.borderRadius+'px 0 0';
      this.widgetWrapper.getElementsByClassName('bomWidgetFt')[0].style.borderRadius = '0 0 '+this.params.borderRadius+'px '+this.params.borderRadius+'px';
    }
   /* */
    this.getData();
  };
  this.getData = function(){
    var jsonp = document.createElement('script'); 
    jsonp.type = 'text/javascript'; 
    jsonp.async = true;
    jsonp.src = this.params.contentUrl+'.json?callback=bomWidget['+this.params.idWidget+'].render&limit='+this.params.nbItemsLimit;
    if(this.params.os != '')jsonp.src += '&os='+this.params.os;
    if(this.params.dldSort != '')jsonp.src += '&sort='+this.params.dldSort;
    this.widgetWrapper.parentNode.insertBefore(jsonp,this.widgetWrapper);
  };
  this.render = function (params){ //JSONP Callback function
    var output = "";
    var items = params.items || [];
    for (var i = 0; i < items.length && i < this.params.nbItemsLimit; i++){
      var item = items[i].item;
      var title = item.body.title;
      var link = item.body.url;
      output += '<li'+((i == items.length-1)?' class="bomWidgetLastItem"':'')+'>';
      output += '<a href="'+link+'"><span class="bomWidgetPicto">&rsaquo;</span><span class="bomWidgetLabel">'+title+'</span></a>'
      output += '</li>';
    }
    document.getElementById('bomWidgetList'+this.params.idWidget).innerHTML = output;
  };
  this.setBrowserClassName = function(){
    var ua = navigator.userAgent.toLowerCase();
    var browser = '';
    if(ua.indexOf('firefox') != -1){
      browser = 'firefox';
    }
    else if(ua.indexOf('webkit') != -1){
      browser = 'webkit';
    }
    else if(ua.indexOf('opera') != -1){
      browser = 'opera';
    }
    else if(ua.indexOf('msie') != -1){
      browser = 'ie';
      browser += ua.match(/msie ([0-9])+/i)[1];
    }
    if(this.widgetWrapper.className.indexOf(browser)+' ' == -1 && ' '+this.widgetWrapper.className.indexOf(browser) == -1 && this.widgetWrapper.className != browser)
      this.widgetWrapper.className += ' '+browser;
  };
  this.init(params);
}