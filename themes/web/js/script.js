$(document).ready(function(){ 

  var _fetch = false;
  var _page = 2;
  if( $('.column_0').length > 0 ) {
    $(window).scroll(function() { 
      if($(window).scrollTop() == $(document).height() - $(window).height()){
        if( $('.index_loading').hasClass('stop') ) {
          return false;
        }
        if(!_fetch) {
          _fetch = true;
          $('.index_loading').show();
          $.ajax({
            type: 'get',
            cache: false,
            dateType: 'json',
            url: 'site/index_fetch/format/js/page/'+_page,
            success: function(html) {
              $('.index_loading').hide();
              if( html != null ) {
                for( i=0; i< html.length ; i++ ) {
                  var t   = html[i];
                  var img = $('<img>').attr('src', t.src);
                  var a   = $('<a>').attr('href', t.url).attr('title',t.title).append( img );
                  var div = $('<div>').addClass('w').append( a ).hide();
                  $('.column_'+i).append( div );
                  div.fadeIn();
                }
              }else {
                $('.index_loading').addClass('stop').append( ' ~no items~ ' ).slideDown();
              }
              _fetch = false;
              _page ++;
            }
          });
        }
      }
    });
  };

  $('.itext').focus(function(){
    $(this).addClass('focus');
  });
  $('.itext').blur(function(){
    $(this).removeClass('focus');
  });
  $('.isubmit').hover(function(){
    $(this).addClass('hover');
  },function(){
    $(this).removeClass('hover');
  })

  var w=0;
  $('.scroll-wrap').removeAttr('style');
  $('.scroll-pane a img').each(function(){    
    var _oimg = $(this);
    var _img = _oimg.clone();
    _img.css( { 'display': 'none' })
		$(document.body).append(_img);
		i =1;
		_img.one('load',function(){
			_img.removeAttr('height');
			_img.removeAttr('width');
			w += _img.width();
			i++;
			$('.scroll-wrap').css({'width':w}).attr('count',i);
		});
  });
  function init_scroll() {
    if( $(".scroll-wrap").attr('count') >= $(".scroll-pane a img").length ) {
      $('.scroll-pane').jScrollPane({showArrows: true});
      $('.scroll-pane-arrows').jScrollPane({
		  	showArrows: true,
			  horizontalGutter: 10
		  });
    }else {
      setTimeout(init_scroll,'1000');
    }
  };
  if( $('.scroll-pane').length > 0 ){
    init_scroll();  
  }
  
  if( $("a[rel=group]").length > 0 ) {
    $("a[rel=group]").fancybox({
    'titlePosition'	: 'inside',
	  'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
	    return 'Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '';
	    }
  	});
  }
});
