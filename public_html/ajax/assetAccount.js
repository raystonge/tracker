$(document).ready(function () {
	//alert("ready");
    $(".button").click(function() {

        $("#myform #valueFromMyButton").text($(this).val().trim());
        $("#myform input[type=text]").val('');
        $("#valueFromMyModal").val('');
        $("#myform").show(500);
    });
    $("#btnOK").click(function() {
    	//alert("btnOk");
      //alert($userPassword);
      //alert($userPassword);
    	$pwd = $("#myform input[type=password]").val().trim();
      //alert("|"+$pwd+"|");

        if ($userPassword == $pwd)
        {
      	 $('#adminPassword').get(0).setAttribute('type', 'text');
      	 $("#formPWDprompt").attr('class', 'hide');
        }
        //$("#valueFromMyModal").val($("#myform input[type=text]").val().trim());
        $("#myform").hide(400);
    });
});
