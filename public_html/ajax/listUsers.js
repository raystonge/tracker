// =================================
//   INITIALIZE
// =================================
$(document).ready(function ()
{
    $("#search").submit(function ()
    {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/users.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse)
        {
            // Display Results.
            $("#results").html(theResponse);
            //Pagination Click
            $("#paginationResults li").click(function ()
            {
                //Display_Load();
                var pageNum = this.id;
                $("#page").attr(
                {
                    'value': pageNum
                });
                $('#search').submit();
            });
        });
        return false;
    });
    $('#search').submit();

});