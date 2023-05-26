<?php
//
//  Tracker - Version 1.9.0
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
//  See the License for the specific language governing users and
//  limitations under the License.
//
?>
<?php
include_once "globals.php";
include_once "tracker/user.php";
include_once "tracker/userToService.php";
include_once "tracker/service.php";
$serviceId = 0;
if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$serviceId = $request_uri[2];
		DebugText("using param 2:".$serviceId);
	}
}
$service = new Service($serviceId);
?>
<h2>Users for : <?php echo $service->name;?></h2>
<form id="serviceUserForm" method="post" autocomplete="<?php echo $autoComplete;?>" class="cmxform" action="/process/serviceUsers.php">
  <table class="width100">
    <tr>
    <?php
    $cnt = 0;
    $userToService = new UserToService();
    $user = new User();
		$user->SetOrderBy("fullName");
    $ok = $user->Get("active=1");
    while ($ok)
    {
    	if (($cnt % 3) == 0)
    	{
    		echo "</tr>";
    		echo "<tr>";
    	}
    	$field = "user".$user->userId;
    	$checked = "";

    	$param = AddEscapedParam("","serviceId",$serviceId);
    	$param = AddEscapedParam($param,"userId",$user->userId);
  //  	$param = AddEscapedParam($param, "organizationId", $service->organizationId);
    	if ($userToService->Get($param))
    	{
    		$checked ="checked='checked'";
    	}
    	?>
    	<td>
    	  <input type="checkbox" name="<?php echo $field;?>" <?php echo $checked;?> value="1">&nbsp;<?php echo $user->fullName;?>
    	</td>
    	<?php
    	$cnt++;
    	$ok = $user->Next();
    }
    for ($i = 0; $i<=$cnt%3;$i++)
    {
    	echo "<td>&nbsp;</td>";
    }
    ?>
    </tr>
    <tr>
      <td>
      &nbsp;<input type="hidden" name="serviceId" value="<?php echo $serviceId;?>"/>
      <input type="hidden" name="submitTest" value="1"/>
      </td>
      <td>
        <center><input type ="submit" name="submit" value="Update"/></center>
				<?php 	PrintFormKey();
				?>
      </td>
      <td>
      &nbsp;
      </td>
    </tr>
  </table>
</form>
<?php
DebugOutput();
?>
