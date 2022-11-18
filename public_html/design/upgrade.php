<?php
/*
 * upgrade.php
 * Created: Nov 20, 2012
 * Administrator
 * @author: My Name
 * @version
 * Copyright 2012 RaywareSoftware - Raymond St. Onge
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
 */

include_once "tracker/user.php";
include_once "tracker/permission.php";
PageAccess("Config: Upgrade");
?>
<h2>Upgrade</h2>
<?php
$control = new Control();
$param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
$control->Get($param);
$currentVersion = $control->valueInt;
$fileList = array();
$arrayIndex = 0;
$dir = $siteRootPath."/sysUpdates";
if ($dh = opendir($dir))
{
	while (($file = readdir($dh)) !== false)
    {
    	if (!is_dir($file))
    	{
    		$file = str_replace(".txt","",$file);
    		if ($file > $currentVersion &&  is_numeric($file))
    		{
    			$fileList[$arrayIndex++] = $file;
    		}
    	}

	}
	closedir($dh);
	if (sizeof($fileList))
	{
		echo "New Versions:<br>";
		sort($fileList);
		foreach ($fileList as &$file)
		{
			echo $file."<BR>";
		}
			?>
			<form method="post" action="/doUpgrade/" autocomplete="<?php echo $autoComplete;?>">
			  <input type="hidden" name="formKey" value="<?php echo getFormKey();?>"/>
			  <input type="submit" name="submit" value="Do Upgrade" />
			</form>
		<?php
	}
}
?>
