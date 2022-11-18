$(document).ready(function () {

	itemToRemove = "";
	loadAvailableModules();
	loadMyModules();

	function loadAvailableModules()
	{

	link = "/ajax/spec/listAvailableModules.php";
	  $("#availableModules").load(link, function () {
		  initAvailMods();

	  });
	}
	function loadMyModules()
	{
	  link = "/ajax/spec/listMyModules.php";
	  $("#myModules").load(link, function () {
		  initMyMods();
	  });
	}
	function initAvailMods()
	{
	    $(".mods").draggable({
	        helper: function () {
	         // alert("get item");
	          var $item = $(this).clone();
	          $item.removeClass('lritem').addClass('mritem');
	          moduleId = $(this).attr('id');
	          itemToRemove = $(this);
	          return $item;
	        }
	      });
	}
	function initMyMods()
	{
	    $("#myModules ul").sortable({
	        opacity: 0.6,
	        cursor: 'move',
	        update: function () {
	          var cnt = 1;
	          $('.list_num', this).each(function () {
	            $(this).text(cnt);
	            cnt++;
	          })
	          var moduleId = $("#module_Id").attr('value');
	         // var order = $(this).sortable("serialize") + '&action=addRecordsListings&moduleId=' + moduleId;
	         // $.post("/ajax/spec/resortModules.php", order, function (data) {});
	                           var array = jQuery('#myModList li').map(function(){
                      return 'module[]=' + this.id.match(/(\d+)$/)[1]
                  }).get()
                    var order = array.join('&') + '&action=addRecordsListings&moduleId=' + moduleId;
                      $.post("/ajax/spec/resortModules.php", order, function (data) {});

	        }
	      });

		$(".myMods").droppable({
	        accept: ".mods",
	        tolerance: 'touch',
	        drop: function (event, ui) {
	            link = "/ajax/spec/addModule.php";
	            $.getJSON(link,{"moduleId": moduleId},

	            function (data)
	            {
	              if (data.status == 'success')
	              {
	                //alert(data.html);
	            	  itemToRemove.remove();
	            	  loadAvailableModules();
	                 $('.myMods').prepend(urldecode(data.html));
	                // Setup List Functionality
	                //initLessonPlans();
	                // Auto click new assessment.
	                $('.myMods #' + data.id).click();

	                reorderAvailList();
	            	  reorderMyList();
		  	          var moduleId = $("#module_Id").attr('value');
			          //var order = $(this).sortable("serialize") + '&action=addRecordsListings&moduleId=' + moduleId;
		  	        var array = jQuery('#myModList li').map(function(){
		  	          return 'module[]=' + this.id.match(/(\d+)$/)[1]
		  	      }).get()
		  	        var order = array.join('&') + '&action=addRecordsListings&moduleId=' + moduleId;
			          $.post("/ajax/spec/resortModules.php", order, function (data) {});
	               initMyMods();
	              }
	              else
	              {
	                //alert("fail");
	                //$('.feedback', $('#popup')).empty().prepend(urldecode(data.html));
	              }
	            }
	            //return false;
	          );
	        }

	      });
	    $('.r_delete').bind('click', function () {
	        link = "/ajax/spec/deleteModule.php";
	        itemToRemove = $(this);
	        moduleId = $(this).parent().parent().attr('id');
	        //alert(moduleId);
            $.getJSON(link,{"moduleId": moduleId},

    	            function (data)
    	            {
    	              if (data.status == 'success')
    	              {
    	                //alert(data.html);
    	            	  //itemToRemove.remove();
    	            	//  $(this).parent().parent().remove();
    	                // Setup List Functionality
    	                //initLessonPlans();
    	                // Auto click new assessment.
    	            	  loadMyModules();
    	            	  loadAvailableModules();
    	                $('.myMods #' + data.id).click();

    	                //reorderAvailList();
    	            	 // reorderMyList();
    		  	          var moduleId = $("#module_Id").attr('value');
    			          //var order = $(this).sortable("serialize") + '&action=addRecordsListings&moduleId=' + moduleId;
    		  	          /*
    		  	        var array = jQuery('#myModList li').map(function(){
    		  	          return 'module[]=' + this.id.match(/(\d+)$/)[1]
    		  	      }).get()
    		  	        var order = array.join('&') + '&action=addRecordsListings&moduleId=' + moduleId;
    			          $.post("/ajax/spec/resortModules.php", order, function (data) {});
    	                */
    	              }
    	              else
    	              {
    	                //alert("fail");
    	                //$('.feedback', $('#popup')).empty().prepend(urldecode(data.html));
    	              }
    	            }
    	            //return false;
    	          );

	        return false;
	      });

		reorderMyList();
	}
	  function reorderAvailList() {
		    //alert('order list');
		    // Reorder.
		    var cnt = 0;
		    $('.list_num', $('#availableMods_rlist ul')).each(function () {
		      cnt++;
		      $(this).text(cnt);
		    });
		    if (cnt != 0) {
		      $('#availableMods_rlist ul li.instruction').remove();
		    } else {
		      // No Resources in this lesson plan.
		      if ($('.instruction', $('#availableMods_rlist ul')).length == 0) $('#availableMods_rlist ul').append('<li class="instruction"><p>Drag &amp; drop questions here to add them to this assessment.</p></li>');
		    }
		  }

	  function reorderMyList() {
		    //alert('order list');
		    // Reorder.
		    var cnt = 0;
		    $('.list_num', $('#myMods_rlist ul')).each(function () {
		      cnt++;
		      $(this).text(cnt);
		    });
		    if (cnt != 0) {
		      $('#myMods_rlist ul li.instruction').remove();
		    } else {
		      // No Resources in this lesson plan.
		      if ($('.instruction', $('#myMods_rlist ul')).length == 0) $('#myMods_rlist ul').append('<li class="instruction"><p>Drag &amp; drop modules here to add them to your home page.</p></li>');
		    }
		  }

}
);
