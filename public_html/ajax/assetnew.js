// =================================
//   INITIALIZE
// =================================
$(document).ready(function () {
	$("form").submit(function () {
		var formData = $(":input").serializeArray();
		var organization = $("#organization").val();
		if (organization == 0)
		{
			alert("Please select an Organization");
			return false;			
		}
		else
		{
			return true;
		}	
	});
});