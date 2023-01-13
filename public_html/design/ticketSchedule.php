<div class="adminArea">
<!--
	<h2><a href="/listTickets/" class="breadCrumb">Tickets</a> -> New Ticket</h2>
-->

<?php
$ticketId = 0;
if (isset($request_uri[2]))
{
	$ticketId = $request_uri[2];
}

include_once "tracker/ticket.php";
include_once "tracker/timeWorked.php";
$timeWorked = 0;
$ticket = new Ticket($ticketId);
include $sitePath."/design/ticket/ticketInfoHeader.php";
?>
<script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/<?php echo $tinyMCE;?>/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
tinymce.init({
//  selector: '#myeditablediv',
//  inline: true
	selector: 'textarea',
	height: 250,
	statusbar: false,
	toolbar: 'undo redo  bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
	plugins: 'code',
	menubar: false
});
</script>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/ticket/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

<div class="clear"></div>

	<div id='tab-editor'>
     <?php
     include $sitePath."/design/ticket/schedule.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
