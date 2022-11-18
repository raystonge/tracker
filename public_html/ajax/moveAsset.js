$(document).ready(function () {
  //alert('moveAsset');
  $( '#organization' ).change(function() {
    //alert( "Handler for .change() called." );
    link = "/ajax/controls/orgBuilding.php";
    var formData = $(":input").serializeArray();
    $.post(link, formData, function (theResponse) {
      // Display Results.
      $("#resultsBuilding").html(theResponse);

     });
     link = "/ajax/controls/orgAssetType.php";
     var formData = $(":input").serializeArray();
     $.post(link, formData, function (theResponse) {
       // Display Results.
       $("#resultsAssetType").html(theResponse);

      });
   });
});
