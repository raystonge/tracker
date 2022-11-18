// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
     
	$( "#monitorType" ).change(function() {
		alert("monitorType");
	});
   function monitor()
   {
       /*
        link = "/ajax/results/monitor/assetMonitor.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
            // Display Results.
        	$("#assetState").html(theResponse);
        });
         */
        return false;
    }
   monitor();
    var interval = 1000 * 60 * 1;   //number of mili seconds between each call

    setInterval(monitor, interval);
});
