// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
    $("#search").submit(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/reports/reports.php";
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
            $('input:checkbox.asset').each(function () 
                    {
                        $('input:checkbox.asset').prop('checked',true);
                    });     
        });
        $(document).on('click',"#addUnselectAll", function()
        {
            $('input:checkbox.ticket').each(function () 
            {
              $('input:checkbox.ticket').prop('checked',false);
            });     
            $('input:checkbox.asset').each(function () 
                    {
                      $('input:checkbox.asset').prop('checked',false);
                    });     
        });
    }


});