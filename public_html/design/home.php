<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
<?php
include_once "tracker/queue.php";
include_once "tracker/ticket.php";
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/status.php";
include_once "tracker/module.php";
include_once "tracker/priority.php";
include_once "tracker/organization.php";
?>
<script type="text/javascript" src="/js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#myTickets").tablesorter();
	showRSS("Google");
function showRSS(str)
{
if (str.length==0)
  {
  document.getElementById("rssOutput").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("rssOutput").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","/ajax/getRSSFeed.php?q="+str,true);
xmlhttp.send();
}
}
);
</script>
<div id="widget-boxes-container" class="row-fluid">


</div><!-- end row-fluid -->
        <div id="container" class="row-fluid">
          <div id="content" class=" span9 content-sidebar-right">
          <?php
          echo UpgradeAvailable();
          ?>
<?php
$control = new Control();
$param = "sectionValue='userId$currentUser->userId' and keyValue like 'myMod%'";
$ok = $control->Get($param);
if (!$ok)
{
	$control->section = "userId".$currentUser->userId;
	$control->key = "myMod1";
	$control->valueInt = 2;
	$control->Insert();
	$ok = $control->Get($param);
}
while ($ok)
{
    $module = new Module($control->valueInt);
    ?>
    <strong>
    <?php
    if ($permission->hasPermission("Report: View"))
    {
    	echo CreateLink("/viewReports/".$module->moduleId."/",$module->name,"","View ".$module->name);
    }
    else
    {
    	echo $module->name;
    }
	?>
	</strong>
	<?php
	$param = $module->GetParam();
	DebugText("Module:".$module->name);
	$modType = strtolower($module->moduleType);
	DebugText("moduleType:".$modType);
	switch ($modType)
	{
		case "ticket" : include $sitePath."/design/common/homeTickets.php";
		                break;
		case "asset" : include $sitePath."/design/common/homeAssets.php";
		                break;
	}
?>
  <hr>
 <?php
  $ok = $control->Next();
}
?>
          </div><!-- #content -->

          <div id="secondary" class="widget-area span3">
	        <div id="sidebar">
	          <?php
	          if ($showISC)
	          {
	          	?>
	          	<div class="widget-containger">
	          	  <h3 class="widget-title">Internet Storm Center</h3>
	          	  <a href="http://isc.sans.edu" target="_blank"><img alt="Internet Storm Center Infocon Status" src="http://isc.sans.edu/images/status.gif"></a>
	          	</div>
	          	<?php
	          }
	          ?>
	          <?php
	          if ($permission->hasPermission("Queue: View Tickets"))
	          {
	          	?>
              <div class="widget-container">
			    <h3 class="widget-title">Queues</h3>
			    <ul>
			      <?php
			      $queue = new Queue();
			      $ok = $queue->Get("");
			      while ($ok)
			      {
			      	$queueCnt = 0;
			      	$queueCnt = $ticket->ItemsInQueue($queue->queueId);
			      	if ($queueCnt)
			      	{
			      		$organization = new Organization($queue->organizationId);
			      	?>
			      	<li class="cat-item cat-item-<?php echo $queue->queueId;?> mritem"><a href="/queue/<?php echo $queue->queueId;?>" title="View all posts filed under <?php echo $queue->name;?>"><?php echo $organization->name." - ".$queue->name;?></a> (<?php echo $queueCnt;?>) </li>
			      	<?php
			      	}
			      	$ok = $queue->Next();
			      }
			      ?>
			      </div>
			      <?php
			     }
	          if ($showGoogleRSS)
	          {
	          	?>
	          	<div class="widget-containger">
	          	  <h3 class="widget-title">Google Status</h3>
	          	  <div id="rssOutput"></div>
	          	</div>
	          	<?php
	          }
	          ?>

			    </ul>
              </div>
	        </div><!-- #sidebar -->
          </div><!-- #secondary .widget-area .span3 -->
