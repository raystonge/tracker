// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
Checkboxes();
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

});
