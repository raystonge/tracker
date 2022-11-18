<?php
PageAccess("Queue: View Tickets");
include_once "tracker/queue.php";
include_once "tracker/ticket.php";
include_once "tracker/queue.php";
include_once "tracker/user.php";
include_once "tracker/organization.php";
?>
<script type="text/javascript" src="/js/jquery.tablesorter.js"></script>
<script type="text/javascript">
$(document).ready(function()
    {
        $("#myTickets").tablesorter();
    }
);
</script>
<div id="widget-boxes-container" class="row-fluid">


</div><!-- end row-fluid -->
        <div id="container" class="row-fluid">
          <div id="content" class=" span9 content-sidebar-right">
          <?php
              $queueId = 0;
              if (isset($request_uri[2]))
              {
              	$queueId = $request_uri[2];
              }
              $userId = $_SESSION['userId'];
              $param = AddEscapedParam("","queueId",$queueId);
              $param = AddParam($param,"statusId not in (4,6)");
              include $sitePath."/design/common/homeTickets.php";
           ?>
          </div><!-- #content -->
          <div id="secondary" class="widget-area span3">
	        <div id="sidebar">


              <div class="widget-container">
			    <h3 class="widget-title">Queues</h3>
			    <ul>
			      <?php
			      $queue = new Queue();
            $queue->SetOrderBy("organizationId");
			      $ok = $queue->Get("");
			      while ($ok)
			      {
              $organization = new Organization($queue->organizationId);
			      	$queueCnt = 0;
			      	$queueCnt = $ticket->ItemsInQueue($queue->queueId);
			      	if ($queueCnt)
			      	{
			      	?>
			      	<li class="cat-item cat-item-<?php echo $queue->queueId;?> mritem"><a href="/queue/<?php echo $queue->queueId;?>" title="View all posts filed under <?php echo $organization->name." - ".$queue->name;?>"><?php echo $organization->name." - ".$queue->name;?></a> (<?php echo $queueCnt;?>)
			      	<?php
			      	}
			      	$ok = $queue->Next();
			      }
			      ?>

                   <!-- <ul class="children">
	                  <li class="cat-item cat-item-4"><a href="http://wordpress.raywaresoftware.com/blog/category/news/local/" title="View all posts filed under Local">Local</a> (2)
                      </li>
                    </ul> -->
                  </li>
			    </ul>
              </div>
	        </div><!-- #sidebar -->
          </div><!-- #secondary .widget-area .span3 -->
