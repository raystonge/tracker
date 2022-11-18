$(document).ready(function () {
    $( "#organization" ).change(function() {
      link = "/ajax/controls/poNumber.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#poNumberResults").html(theResponse);
      });
    });

    
    $("#organization").change();
	
});
