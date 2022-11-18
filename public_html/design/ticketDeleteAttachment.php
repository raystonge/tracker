<?php
/*
 * Created on Jan 23, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div class="adminArea">
<?php
include_once "tracker/attachment.php";
include_once "tracker/ticket.php";

$attachmentId = 0;
if (isset($request_uri[2]))
{
	$attachmentId = $request_uri[2];
}
$attachment = new Attachment($attachmentId);
$ticket = new Asset($attachment->ticketId);
$ticketId = $ticket->ticketId;
$url = "/ticketAttachment/".$ticket->ticketId."/";
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
	include $sitePath."/design/common/attachmentDelete.php";
	?>
	</div>
</div>