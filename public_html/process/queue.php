<?php
/*
 * Created on Mar 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/queue.php";
include_once "tracker/defaultUser.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";

if (isset($_POST['submitTest']))
{
	$validated = false;
	$status='fail';
	$html="";
	$name = "";
	$assignee = 0;
	$organizationId = 0;
	$errorMsg  = "";
	$numErrors = 0;
	$cnt = 0;
	if (!validateAJAXFormKey())
	{
		DebugPause("/improperAccess/");
	}
    $queue = new Queue();

	if (isset($_POST['queueId']))
	{
		$queueId=strip_tags($_POST['queueId']);
		$queue->GetById($queueId);
	}
	$organizationId = GetTextField("organization",0);
	if (isset($_POST['name']))
	{
		$name = trim(strip_tags($_POST['name']));
	}

	if (strlen($name) == 0)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify Name</li>";

	}

	if (!$organizationId)
	{
		$numErrors++;
		$errorMsg=$errorMsg."<li>Please Specify ".$orgOrDept."</li>";
	}
	if ($numErrors)
	{
		$param = "queueId<>".$queueId;
		$param = AddEscapedParam($param,"name",$name);
		$testQueue = new Queue();
		if ($testQueue->Get($param))
		{
			$numErrors++;
			$errorMsg=$errorMsg."<li>Queue already in use</li>";

		}
	}


	if ($numErrors ==0)
	{
		$queue->name = $name;
		$queue->organizationId = $organizationId;

		if ($queue->queueId)
		{
			$queue->Update();
		}
		else
		{
			$queue->Insert();
		}
		$defaultUser = new DefaultUser();
		$defaultUser->Reset($queue->queueId);
		if (isset($_POST['assignee']))
		{
			if ($_POST['assignee'])
			{
				$defaultUser->userType = "assignee";
				$defaultUser->userId = $_POST['assignee'];
				$defaultUser->queueId = $queue->queueId;
				$defaultUser->Insert();
			}
		}
		if (isset($_POST['cc']))
		{
			@$ccs = $_POST['cc'];
			if ($ccs)
		{
			while (list ($key, $cc) = each ($ccs))
			{
				$defaultUser->userId=$cc;
				$defaultUser->queueId = $queue->queueId;
				$defaultUser->userType = "cc";
				$defaultUser->Insert();
			}
		}

		}
		DebugPause("/listQueues/");
	}
	else
	{
		$html = "<ul>".$errorMsg."</ul>";
		$_SESSION['name']=$name;
		$_SESSION['assignee'] = $assignee;
		$_SESSION['organizationId'] = $organizationId;
		$_SESSION['formErrors'] = $html;
		if ($queue->queueId)
		{
			DebugPause("/editQueue/".$queue->queueId."/");
		}
		DebugPause("/newQueue/");
	}
	//echo '{"status":"'.$status.'","html":"'.urlencode($html).'","id":"'.$queue->queueId.'"}';
//DebugOutput();
}
DebugPause("/listQueues/");
?>
