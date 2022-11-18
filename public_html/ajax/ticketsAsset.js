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
        link = "/ajax/results/assets/tickets.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData, function (theResponse) {
            // Display Results.
        	$("#assetTickets").html(theResponse);
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
        return false;
    });
    $('#search').submit();
    // ============================
    // New Control.
    // ============================
    function newControl() {
        link = "/ajax/control/newControl.php";

        function saveItem() {
            if ($('#popup').length != 0) {
                $('input[type="submit"]', $('#popup')).bind('click', function () {
                    link = "/ajax/control/newControl.php";
                    var options = {
                            success: postSubmit,
                            // post-submit callback
                            url: link,
                            dataType: 'json'
                        }
                        $form = $('#popup form');
                    $form.ajaxSubmit(options);

                    function postSubmit(data) {
                    	if (data.status == 'improperAccess')
                    	{
                    		$('#popup-close').click();
                    	}
                        if (data.status == 'success') {
                            // Close Popup.
                            $('#popup-close').click();
                            $('.main_rlist tbody').append(urldecode(data.html));

                            // Setup List Functionality
                            reorderMain($('.main_rlist tbody'));
                        } else {
                            $('.feedback', $('#popup')).addClass('error');
                            $('.feedback', $('#popup')).empty().append(urldecode(data.html)).slideDown('fast');
                        }
                    }
                    return false;
                });
            }
        }
        // Init New Control.
        var options = {};
        options.content = link;
        options.title = 'New Control';
        options.callback = saveItem;
        $('#newControl').bind('click', function () {
            popUp(options);
            return false;
        });
    }
    // ============================
    // Edit Control.
    // ============================
    function editControl() {
        link = "/ajax/control/editControl.php"

        function saveItem() {
            if ($('#popup').length != 0) {
                $('input[type="submit"]', $('#popup')).bind('click', function () {
                    link = "/ajax/control/editControl.php"
                    var options = {
                            success: postSubmit,
                            // post-submit callback
                            url: link,
                            dataType: 'json'
                        }
                        $form = $('#popup form');
                    $form.ajaxSubmit(options);

                    function postSubmit(data) {
                        if (data.status == 'improperAccess')
                        {
                            $('#popup-close').click();
                        }
                        if (data.status == 'success') {
                            // Close Popup.
                            $('#popup-close').click();
                            $('#' + data.id, $('.main_rlist tbody')).replaceWith(urldecode(data.html));
                            // Setup List Functionality
                            reorderMain($('.main_rlist tbody'));
                        } else {
                            $('.feedback', $('#popup')).addClass('error');
                            $('.feedback', $('#popup')).empty().append(urldecode(data.html)).slideDown('fast');
                        }
                    }
                    return false;
                });
            }
        }
        // Init Edit Control.
        var options = {};
        options.content = link;
        options.title = 'Update Control';
        options.callback = saveItem;
        $(document).on('click', '.edit_control', function ()
        {
            options.controlId = $(this).parent().parent().attr('id');
            popUp(options);
            return false;
        });
    }

    function deleteControl() {
        link = "/ajax/control/deleteControl.php";

        function saveItem() {
            if ($('#popup').length != 0) {
                $('input[type="submit"]', $('#popup')).bind('click', function () {
                    link = "/ajax/control/deleteControl.php";
                    var options = {
                            success: postSubmit,
                            // post-submit callback
                            url: link,
                            dataType: 'json'
                        }
                        $form = $('#popup form');
                    $form.ajaxSubmit(options);

                    function postSubmit(data) {
                        if (data.status == 'improperAccess')
                        {
                            $('#popup-close').click();
                        }
                        if (data.status == 'success') {
                            // Close Popup.
                            $('#popup-close').click();
                            $('#' + data.id, $('.main_rlist tbody')).remove(); //replaceWith(urldecode(data.html));
                            reorderMain($('.main_rlist tbody'));
                        } else {
                            $('.feedback', $('#popup')).addClass('error');
                            $('.feedback', $('#popup')).empty().append(urldecode(data.html)).slideDown('fast');
                        }
                    }
                    return false;
                });
            }
        }
        // Init Delete.
        var options = {};
        options.content = link;
        options.title = 'Delete Control';
        options.callback = saveItem;
        $(document).on('click', '.delete_control', function ()
        {
            options.controlId = $(this).parent().parent().attr('id');
            popUp(options);
            return false;
        });
    }


});
