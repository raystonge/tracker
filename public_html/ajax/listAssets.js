// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
	function parseLineSeperated(data)
	{

	   data = data.split("\n");
	   return data;
	}

   $(document).on('click','#reset',function()
    {
     $("#organizationId").val(0);
     $("#searchConditionId").val(0);
     $("#searchSerialNumber").val("");
     $("#searchAssetTag").val("");
     $("#searchMacAddress").val("");
     $("#searchName").val("");
     $("#searchEmployeeName").val("");
     $("#searchMake").val("");
     $( "#organizationId").change();
    });

    $("#search").click(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/assets/assets.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
            // Display Results.
        	$("#results").html(theResponse);
            //Default Starting Page Results
            //$("#paginationResults li:first").addClass('is_selected');
            //Pagination Click
        	$("#paginationResults li").click(function () {

                $('#paginationResults li').removeClass('is_selected');
                $(this).addClass('is_selected');
                //Display_Load();
                var pageNum = this.id;
                $("#page").attr({
                    'value': pageNum
                });

                $("#search").click();

            });
        	Checkboxes();

        });
        return false;
    });
    $('#search').click();
    $("#paginationResults li").click(function () {
        $('#paginationResults li').removeClass('is_selectend');
        $(this).addClass('is_selected');
        //Display_Load();
        //
        //CSS Styles
        var pageNum = this.id;
        $("#page").attr({
          'value': pageNum
        });
        $('#search').click();
      });
    function Checkboxes()
    {
    	$(document).on('click',"#addSelectAll", function()
    	{
    		$('input:checkbox.asset').each(function ()
    	    {
    	    	$('input:checkbox.asset').prop('checked',true);
    	    });
    	});
    	$(document).on('click',"#addUnselectAll", function()
    	{
    		$('input:checkbox.asset').each(function ()
    	    {
    	      $('input:checkbox.asset').prop('checked',false);
    	    });
    	});
    	/*
    	$(document).on('click',"addSelectAll", function()
    	{
        	$('input:checkbox.asset').each(function () {
     	       var sThisVal = (this.checked ? $(this).val() : "");
     	  });

    	});
    	*/
    	/*
    	$(document).on('click', '#jumboAsset', function ()
        {
    	  var formData = $(":input").serializeArray();
          var link = "/process/asset/jumbo.php";
          $.post(link, formData);
          //document.location = link;
    	});
    	*/
    }
    $( "#organizationId").change(function() {
        link = "/ajax/controls/building.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#buildingResults").html(theResponse);
        });
        link = "/ajax/controls/poNumber.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#poNumberResults").html(theResponse);
        });
        link = "/ajax/controls/assetType.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#assetTypeResults").html(theResponse);
        });

    });
    $("#organizationId").change();
	 $('#searchMake').autocomplete({minLength:1,
	      source: function (request, response) {


	        var make = $("#searchMake").val(),
	            assetTypeId= $("#searchAssetType").val(),
	            organizationId = $("#organizationId").val();
	        $.ajax({
	            url: '/ajax/lookups/make.php?make=' + make + '&assetTypeId='+assetTypeId + "&organizationId="+organizationId,

	            success: function(data) {

	                response(parseLineSeperated(data));
	                //response(data);
	            },
	            error: function(req, str, exc) {
	                alert(str);
	            }
	        });
	    }
	 });

});
