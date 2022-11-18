<?php
$formKey = "";
PageAccess("Asset: View Tickets");
?>
<div class="adminArea">
<?php
$ticketId = GetURI(2,0);
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
     include $sitePath."/design/ticket/asset.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>