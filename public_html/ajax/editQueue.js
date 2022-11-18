$(document).ready(function () {
    $( ".organization" ).change(function() {
      link = "/ajax/users/defaultUser.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#assigneeResults").html(theResponse);
      });

      link = "/ajax/users/ccUsers.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#ccUsersResults").html(theResponse);
      });
    
    });	
	
    
    $(".organization").change();
	
	
});

