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
<script type="text/javascript">
$(document).ready(function () {
	url = '<?php echo $url;?>';
	$("#yes").click(function () {
        link = "/process/attachment/delete.php";
        var formData = $(":input").serializeArray();
        $.post(link, formData), function (theResponse) {
        }
	document.location.href=url;
	});
	$("#no").click(function () {
		document.location.href=url;
	});


});
</script>
<form method="post" >
<p>Are you sure you want to delete <?php echo $attachment->originalName;?>?
</p>
<?php CreateHiddenField("attachmentId",$attachment->attachmentId);?>
<?php CreateYesNo();?>
</form>
