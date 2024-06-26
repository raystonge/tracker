<?php
//
//  Tracker - Version 1.6.0
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
include_once "globals.php";
include_once "tracker/service.php";
include_once "tracker/userToService.php";
include_once "tracker/user.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listServices/">Services</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
   		$service->name = GetTextFromSession("name");
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/service.php">
  <table class="width100">
    <tr>
      <td>Service:
      </td>
      <td>
      <?php CreateTextField("name",$service->name,getFieldSize("service","name"),"Name for Service",$editFieldClass);?>
      </td>
      <td>
    </tr>
	  <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("serviceId",$service->serviceId);
      PrintFormKey();
      ?>
      </td>
      <td>
      <?php CreateSubmit("submit",$button);?>
      </td>
    </tr>
  </table>
</form>
<?php
if ($serviceId)
{
	?>
<table width="100%">
	<th>
		User
	</th>
	<th>
		Admin Access
	</th>
	<?php
	$userToService = new UserToService();
	$param = AddEscapedParam("","serviceId",$serviceId);
	$ok = $userToService->Get($param);
	while ($ok)
	{
		$user = new User($userToService->userId);
		?>
		<tr>
		<td>
			<?php echo $user->fullName;?>
		</td>
		<td>
		<?php
		 if ($userToService->adminAccess)
		 {
			 echo "Yes";
		 }
		 else {
		 	echo "No";
		 }
		 ?>
	 </td>
 </tr>
	 <?php
		$ok = $userToService->Next();
	}
	?>
</table>
<?php
}
 ?>
</div>
