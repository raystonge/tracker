$(document).ready(function () {
    $( "#organizationId" ).change(function() {
      link = "/ajax/controls/buildingQueue.php";
      var formData = $(":input").serializeArray();
      $.post(link, formData, function (theResponse) {
        // Display Results.
        $("#queueResults").html(theResponse);
      });
    });
    $("#organizationId").change();
});
