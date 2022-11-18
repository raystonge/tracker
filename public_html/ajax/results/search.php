<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/comment.php";
include_once "tracker/history.php";
include_once "tracker/queue.php";
include_once "tracker/set.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";


$searchText = GetTextField("searchText");
$searchType = GetTextField("searchType",0);
$_SESSION['searchText'] = $searchText;
$_SESSION['searchType'] = $searchType;
$param = "";
$comment = new Comment();
$comment->SetPerPage(25);
switch($searchType)
{
	case 0: $param = "(ticketId >0 or assetId >0 or poNumberId > 0 or contractId > 0)";
	        break;
	case 1: $param = "assetId >0";
	        break;
	case 2: $param = "ticketId >0";
	        break;
	case 3: $param = "poNumberId >0";
	        break;
	case 4: $param = "contractId >0";
	        break;

}
$ticketList = new Set(",");
$assetList = new Set(",");
$poList = new Set(",");
$contractList = new Set(",");
if (strlen($searchText))
{
	DebugText("searchText:".$searchText);
	$keywordList = explode(" ",$searchText);
	DebugText("size:".sizeof($keywordList));
	$keywords = "";
	$keywordParam = "";
	$titleParam = "";
	$employeeParam = "";
	$makeParam = "";
	$poParam = "";
	$descriptionParam = "";
	for ($i = 0; $i < sizeof($keywordList);$i++)
	{
		$historyParam = AddOrFullLikeEscapedParam($keywordParam,"action",$keywordList[$i]);
		$keywordParam = AddOrFullLikeEscapedParam($keywordParam,"comment",$keywordList[$i]);
		$titleParam = AddOrFullLikeEscapedParam($titleParam,"subject",$keywordList[$i]);
		$employeeParam = AddOrFullLikeEscapedParam($employeeParam,"employeeName",$keywordList[$i]);
		$makeParam = AddOrFullLikeEscapedParam($makeParam,"make",$keywordList[$i]);
		$poParam = AddOrFullLikeEscapedParam($poParam,"poNumber",$keywordList[$i]);
		$descriptionParam = AddOrFullLikeEscapedParam($descriptionParam,"description",$keywordList[$i]);
		$keywords = $keywords." ".$keywordList[$i]; //."*";
		DebugText("keywords:".$keywords);
	}
	$keywordParam = "(".$keywordParam.")";
	$historyParam = "(".$historyParam.")";
	$titleParam = "(".$titleParam.")";
	$commentParam =$param." and ".$keywordParam;
	$historyParam = $param." and ".$historyParam;
	$ticketParam = $titleParam;
	$assetParam = $employeeParam." or ".$makeParam;
	$poParam = $poParam." or ".$descriptionParam;
	$ok = $comment->Get($commentParam);
	while ($ok)
	{
		if ($comment->assetId)
		{
			$assetList->Add($comment->assetId);
		}
		if ($comment->ticketId)
		{
			$ticketList->Add($comment->ticketId);
		}
		if ($comment->poNumberId)
		{
			$poList->Add($comment->poNumberId);
		}
		if ($comment->contractId)
		{
			$contractList->Add($comment->contractId);
		}
		$ok = $comment->Next();
	}
	$history = new History();
	$ok = $history->Get($historyParam);
	while ($ok)
	{
		if ($history->assetId)
		{
			$assetList->Add($history->assetId);
		}
		if ($history->ticketId)
		{
			$ticketList->Add($history->ticketId);
		}
		$ok = $history->Next();
	}
	$ticket = new Ticket();
	$ok = $ticket->Get($ticketParam);
	while ($ok)
	{
		$ticketList->add($ticket->ticketId);
		$ok = $ticket->Next();
	}
	$asset = new Asset();
	$ok = $asset->Get($assetParam);
	while ($ok)
	{
		$assetList->Add($asset->assetId);
		$ok = $asset->Next();
	}

	$poNumber = new poNumber();
	$ok = $poNumber->Get($poParam);
	while ($ok)
	{
		$poList->Add($poNumber->poNumberId);
		$ok = $poNumber->Next();
	}
	$assetArray = $assetList->GetAsArray();
	$ticketArray = $ticketList->GetAsArray();
	$contractArray = $contractList->GetAsArray();
	$poNumberArray = $poList->GetAsArray();
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
	$cnt = $assetList->GetSize();
	for ($i = 0; $i < $cnt;$i++)
	{
		$asset = new Asset($assetArray[$i]);
		?>
		<tr>
		  <td>
		  <?php
		  	echo "Asset";
		  ?>
		  </td>
		  <td>
		  <?php
		  	$href = "/assetEdit/".$assetArray[$i]."/";
		  	$id = "asset".$assetArray[$i];
		  	$title = "";
		  	CreateLink($href,$asset->serialNumber,$id,$title);
		  ?>
		  </td>
		  <td>
		  <?php
		  	echo $asset->assetTag;
		  ?>
		  </td>

		</tr>
		<?php

	}
	?>
	<?php
	$cnt = $ticketList->GetSize();
	for ($i = 0; $i < $cnt;$i++)
	{
		$ticket = new Ticket($ticketArray[$i]);
		?>
		<tr>
		  <td>
		  <?php
		  	echo "Ticket";
		  ?>
		  </td>
		  <td>
		  <?php
			$href = "/ticketEdit/".$ticketArray[$i]."/";
			$id = "ticket".$ticketArray[$i];
			$title = "";
			CreateLink($href,$ticket->subject,$id,$title);
		  ?>
		  </td>
		  <td>
		  <?php
			$queue = new Queue($ticket->queueId);
			echo $queue->name;
		  ?>
		  </td>

		</tr>
		<?php

	}
?>
<?php
$cnt = $poList->GetSize();
for ($i = 0; $i < $cnt;$i++)
{
	$poNumber = new poNumber($poNumberArray[$i]);
	?>
	<tr>
		<td>
		<?php
			echo "PO Number";
		?>
		</td>
		<td>
		<?php
		$href = "/poNumberEdit/".$poNumberArray[$i]."/";
		$id = "poNumber".$poNumberArray[$i];
		$title = "";
		CreateLink($href,$poNumber->poNumber,$id,$title);
		?>
		</td>
		<td>
		<?php
		echo "$".$poNumber->cost;
		?>
		</td>

	</tr>
	<?php

}
?>
<?php
$cnt = $contractList->GetSize();
for ($i = 0; $i < $cnt;$i++)
{
	$contract = new Contract($contractArray[$i]);
	?>
	<tr>
		<td>
		<?php
			echo "Contract";
		?>
		</td>
		<td>
		<?php
		$href = "/ContractEdit/".$contractArray[$i]."/";
		$id = "contract".$contractArray[$i];
		$title = "";
		CreateLink($href,$contract->name,$id,$title);
		?>
		</td>
		<td>
		<?php
		PrintNBSP();

		?>
		</td>

	</tr>
	<?php

}
?>


	</table>
	<?php
}
?>
<?php DebugOutput();?>
