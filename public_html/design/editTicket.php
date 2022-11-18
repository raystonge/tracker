<?php
$formKey = "";
$permission = new Permission();
if (!$permission->hasPermission("Ticket: Edit"))
{
	include $sitePath."/design/noAccess.php";
}
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
if ($ticket->ticketId)
{
	echo "Ticket: ".$ticket->ticketId." - ".$ticket->subject."<br>";
}
?>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active">
	                    <a href='/editTicket/<?php echo $ticketId;?>/' title='Ticket'><span>Ticket</span></a>
	                  </li>
	                  <?php
	                  if ($permission->hasPermission("Ticket: View Assets"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/assetTicket/<?php echo $ticketId;?>/' title='Assets'><span>Assets</span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View Attachments"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/attachmentTicket/<?php echo $ticketId;?>/' title='Attachments'><span>Attachments</span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View Insurance"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/insuranceTicket/<?php echo $ticketId;?>/' title='Insurance'><span>Insurance</span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View History"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/historyTicket/<?php echo $ticketId;?>/' title='History'><span>History</span></a></li>
	                  <?php
	                  }
	                  ?>
	                </ul>
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