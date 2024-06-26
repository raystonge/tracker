19// =================================
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
			$("#searchQueueId").val(0);
      $("#searchRequestorId").val(0);
      $("#searchPriorityId").val(0);
      $("#searchOwnerId").val(0);
      $("#searchStatusId").val(-1);
			$("#assignee").val(0);
			$("#searchTicketId").val("");
    });
		$( "#organizationId").change(function() {
        link = "/ajax/controls/searchQueue.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#queueResults").html(theResponse);
        });
        link = "/ajax/controls/owner.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#assigneeResults").html(theResponse);
        });
        link = "/ajax/controls/searchRequestor.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
          // Display Results.
          $("#requestorResults").html(theResponse);
        });

    });
		$("#organizationId").change();
    $("#search").click(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/tickets/tickets.php";
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
    $( "#searchOrganizationId").change(function() {
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
    $("#searchOrganizationId").change();
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
