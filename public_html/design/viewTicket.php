<?php
$formKey = "";
PageAccess("Ticket: View");
?>
<div class="adminArea">
<!--
	<h2>
	<?php
	$listTicket = 0;
	if ($permission->hasPermission("Ticket: List"))
	{
		$listTicket = 1;
	?>
	<a href="/listTickets/" class="breadCrumb">Tickets</a>
	<?php
	}
	?>
	</h2>
	-->
	
<?php
$ticketId = 0;
if (isset($request_uri[2]))
{
	$ticketId = $request_uri[2];
}

include_once "tracker/ticket.php";
$ticket = new Ticket($ticketId);
include $sitePath."/design/ticket/ticketInfoHeader.php";
?>
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
     include $sitePath."/design/ticket/editor.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>