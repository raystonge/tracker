<?php
/*
 * Created on Feb 10, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/user.php";
include_once "tracker/userToGroup.php";
include_once "tracker/userGroup.php";
 	$fname = $siteRootPath."/tmp/UserData-rsu20.org-20140207.csv";
 	$handle = fopen($fname,"r");
 	if (!$handle)
 	{
 		echo "error<br>";
 	}
 	$delimiter = ",";
 	$userGroup = new UserGroup();
 	$userGroup->Get("name='Users'");
 	while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
 	{
 		$email = $row[0];
 		DebugText("email:".$email);
 		$email = strtolower($email);
 		$tmp1 = substr($email,0,strpos($email,"@"));
 		$firstName = $row[1];
 		$lastName = $row[2];
 		$isStudent = 1;
 		$tmp = strtolower($lastName);
 		$tmp = strtolower(substr($firstName,0,1).$tmp);
 		DebugText("lastName:".$lastName);
 		$tmp = str_replace(" ","",$tmp);
 		$tmp = str_replace(".","",$tmp);
 		
 		//$tmp = str_replace("-","",$tmp);
 		$tmp = trim($tmp);
 		$tmp1 = trim($tmp1);
 		DebugText("tmp:".$tmp);
 		DebugText("tmp1:".$tmp1);
 		if ($tmp == $tmp1)
 		{
 			$isStudent = 0;
 		}
 		DebugText("isStudent:".$isStudent);
 		if (!$isStudent)
 		{
 			$user = new User();
 			$param = AddEscapedParam("","email",$email);
 			$user->Get($param);
 			$user->email = $email;
 			$user->fullName = $firstName." ".$lastName;
 			$user->active = 1;
 			if (!strlen($user->password))
 			{
 				$user->password = "P@\$\$W0rd";
 			}
 			$user->Persist();
 			$userToGroup = new UserToGroup();
 			$userToGroup->userId = $user->userId;
 			$userToGroup->Reset();
 			$userToGroup->userId = $user->userId;
 			$userToGroup->userGroupId = $userGroup->userGroupId;
 			$userToGroup->Insert();
 		}
 	}
DebugOutput(); 	
?>