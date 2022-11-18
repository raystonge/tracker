function urldecode(data){
	return unescape(String(data).replace(/\+/g," "));
}

function reorderMain($list){
        //alert('order list');
          // Reorder.
          var cnt = 0;
           $('.list_num',$list).each(function(){
                cnt++;
               $(this).text(cnt);
           });
      }
//======================
//Create Popup.
//======================
function popUp(options){

  $.get(options.content,options,function(data){
         // Popup HTML.
         html = '<div id="popup">\n\
              <div class="pane"><div class="header"><h1>'+options.title+'</h1><a href="#" title="Close" class="site_btn pop_close_btn" id="popup-close">Close</a></div>\n\
                 <div class="pane_content"><div class="feedback" style="display:none;"></div>';
         html += data;
         html += '</div></div><div class="pane_footer"></div></div><div id="popup_contain"></div>';
         $('body').prepend(html);
         if (typeof options.postLoad == "function")
			{
				options.postLoad();
			}

         if (typeof options.callback == "function") options.callback();

         // Common Popup Functionality.
         // Center Popup, Block User from rest of site.
         $('#popup_contain').height($('body').height());
             $('#popup_contain').hide().fadeIn('fast');
             $('#popup').center().hide().fadeIn('fast');
             $(window).bind('scroll',function(){
                  	
                 //$('#popup').center();
         });
             topPosition = ($(window).height() - $('#popup').outerHeight())/2 + $(window).scrollTop()-175;
             if (topPosition < 50)
             	{
             	topPosition = 50;
             	}
        		$('#popup').css({
     			position:'absolute',
     			left: ($(window).width() - $('#popup').outerWidth())/2,
     			top: topPosition
     		});
         // Popup Cancel / Close.
         $('#popup-close').bind('click',function(){
         
                 $(window).unbind('scroll');
                 $('#popup_contain').fadeOut('fast',function(){$(this).remove();});
                 $('#popup').fadeOut('fast',function(){$(this).remove();});
         });
  });
}
