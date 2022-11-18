// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
    $("#search").submit(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
    	linkSearch = "/ajax/results/tickets/searchAssets.php";
        link = "/ajax/results/tickets/assets.php";
        var formData = $(":input").serializeArray();
        $.post(linkSearch,formData,function (theResponse){
        	$("#assetResults").html(theResponse);
        });
        $.post(link, formData, function (theResponse) {
            // Display Results.
        	$("#assetTickets").html(theResponse);
        	AddAsset();
        	RemoveAsset();

        });
        return false;
    });
    $('#search').submit();
    function AddAsset()
    {
    	$(document).on('click',"#addSelectAll", function()
    	{
    		$('input:checkbox.toAddAsset').each(function () 
    	    {
    	    	$('input:checkbox.toAddAsset').prop('checked',true);
    	    });    	
    	});
    	$(document).on('click',"#addUnselectAll", function()
    	{
    		$('input:checkbox.toAddAsset').each(function () 
    	    {
    	      $('input:checkbox.toAddAsset').prop('checked',false);
    	    });    	
    	});
    	$(document).on('click',"addSelectAll", function()
    	{
        	$('input:checkbox.toAddAsset').each(function () {
     	       var sThisVal = (this.checked ? $(this).val() : "");
     	  });    	
    		
    	});
    	$(document).on('click', '#addAsset', function ()
        {
    	  var formData = $(":input").serializeArray();
          var link = "/process/addAsset.php";
    	  $.post(link,formData,function (theResponse){
			  $('#search').submit();
          });
        });
    }
    function RemoveAsset()
    {
    	$(document).on('click',"#removeSelectAll", function()
    	{
    		$('input:checkbox.toRemoveAsset').each(function () 
    		{
    			$('input:checkbox.toRemoveAsset').attr('checked',true);
            });    	
    	    		
    	});
    	$(document).on('click',"#removeUnselectAll", function()
    	{
    		$('input:checkbox.toRemoveAsset').each(function () 
    		{
    			$('input:checkbox.toRemoveAsset').attr('checked',false);
    		});    	
    	});
    	$(document).on('click', '#removeAsset', function ()
        {
    	  var formData = $(":input").serializeArray();
          var link = "/process/removeAsset.php";
    	  $.post(link,formData,function (theResponse){
			  $('#search').submit();
          });
        });
    }

});