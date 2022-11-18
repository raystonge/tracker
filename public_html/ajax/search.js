// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
    editingControl = 0;
    deletingControl = 0;
   
    $("#search").submit(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/search.php";
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

                $('#search').submit();

            });
            Checkboxes();

        });
        return false;
    });
    $('#search').submit();
    function Checkboxes()
    {
        $(document).on('click',"#addSelectAll", function()
        { 
            $('input:checkbox.ticket').each(function () 
            {
                $('input:checkbox.ticket').prop('checked',true);
            });     
        });
        $(document).on('click',"#addUnselectAll", function()
        {
            $('input:checkbox.ticket').each(function () 
            {
              $('input:checkbox.ticket').prop('checked',false);
            });     
        });
        /*
        $(document).on('click',"addSelectAll", function()
        {
            $('input:checkbox.ticket').each(function () {
               var sThisVal = (this.checked ? $(this).val() : "");
          });       
            
        });
        */
        /*
        $(document).on('click', '#jumboTicket', function ()
        {
          var formData = $(":input").serializeArray();
          var link = "/process/ticket/jumbo.php";
          $.post(link, formData);
          //document.location = link;
        });
        */
    }


});