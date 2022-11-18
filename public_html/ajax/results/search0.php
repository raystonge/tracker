<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/comment.php";
include_once "tracker/queue.php";
$searchText = GetTextField("searchText");
$searchType = GetTextField("searchType",0);
$_SESSION['searchText'] = $searchText;
$_SESSION['searchType'] = $searchType;
$param = "";
$comment = new Comment();
$comment->SetPerPage(25);
switch($searchType)
{
	case 0: $param = "(ticketId >0 or assetId >0)";
	        break;
	case 1: $param = "assetId >0";
	        break;
	case 2: $param = "ticketId >0";
	        break;
}
if (strlen($searchText))
{
	DebugText("searchText:".$searchText);
	$keywordList = explode(" ",$searchText);
	DebugText("size:".sizeof($keywordList));
	$keywords = "";
	for ($i = 0; $i < sizeof($keywordList);$i++)
	{
		$keywords = $keywords." ".$keywordList[$i]; //."*";
		DebugText("keywords:".$keywords);
	}
	$comment->AddMatchParam($keywords);
	$pages = 1;
	$comment->SetOrderBy("score");
	$numRows = $comment->SearchCount($param);
	if ($comment->perPage)
	{
		$pages = ceil($numRows/$comment->perPage);
	}
	$_SESSION['searchNumPerPage'] = $comment->perPage;
	$page = 1;
	DebugText("Compute page we are on");
	$page = GetURI(1,1);
	$page = GetURI(2,1);
	if (!is_numeric($page))
	{
		DebugText("page:".$page);
		DebugText("default page used");
		$page = 1;
	}
	$page = GetTextField("page",$page);
    $comment->SetPage($page);
	$ok = $comment->Search($param);
	?>
	<table class="width100">
	  <th>
	  Type
	  </th>
	  <th>
	  SN / Subject
	  </th>
	  <th>
	  Asset Tag / Queue
	  </th>
	<?php
	while ($ok)
	{
		$asset = new Asset($comment->assetId);
		$ticket = new Ticket($comment->ticketId);
		?>
		<tr>
		  <td>
		  <?php
		  if ($comment->ticketId)
		  {
		  	echo "Ticket";
		  }
		  else
		  {
		  	echo "Asset";
		  }
		  ?>
		  </td>
		  <td>
		  <?php
		  if ($comment->ticketId)
		  {
		  	$href = "/ticketEdit/".$comment->ticketId."/";
		  	$id = "ticket".$comment->ticketId;
		  	$title = "";
		  	CreateLink($href,$ticket->subject,$id,$title);
		  }
		  else
		  {
		  	$href = "/assetEdit/".$comment->assetId."/";
		  	$id = "asset".$comment->assetId;
		  	$title = "";
		  	CreateLink($href,$asset->serialNumber,$id,$title);
		  }
		  ?>
		  </td>
		  <td>
		  <?php
		  if ($comment->ticketId)
		  {
		  	$queue = new Queue($ticket->queueId);
		  	echo $queue->name;
		  }
		  else
		  {
		  	echo $asset->assetTag;
		  }
		  ?>
		  </td>

		</tr>
		<?php
		$ok = $comment->Next();
	}
	?>
	</table>
	<?php
}
?>
<?php DebugOutput();?>