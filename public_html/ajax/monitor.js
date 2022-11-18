// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
    editingControl = 0;
    deletingControl = 0;
   // newControl(); // Popup to Create New Student.
   // editControl();
   // deleteControl();
    

   
    $("#search").submit(function () {
    	$("body").removeClass("waitOver");
    	$("body").addClass("waiting");
        link = "/ajax/results/monitor/monitor.php";
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

        });
    	link = "/ajax/results/monitor/pageTitle.php";
    	$.getJSON(link,'',

    	            function (data) 
    	            {
    	              if (data.status == 'success') 
    	              {
    	              	$(document).attr("title", data.pageTitle);
    	              }
    	            }
    	            );

        return false;
    });
    $('#search').submit();
    var interval = 1000 * 60 * 1;   //number of mili seconds between each call

    setInterval(submit_me, interval);
    function submit_me()
    {
    	$('#search').submit();
    }
});