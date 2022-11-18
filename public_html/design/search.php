<?php
$searchText = GetTextFromSession("searchText");
$searchText = GetTextField("searchText",$searchText);
$searchType = GetTextFromSession("searchType",0);
$searchType = GetTextField("searchType",0);
$page = GetTextField("page",1);
?>
<div class="adminArea">
	<h2><a href="/search/" class="breadCrumb">Search</a></h2>
	<form method="post">
	<table>
	  <tr>
	    <td>Text: <?php CreateTextField("searchText",$searchText);?>
	    </td>
	    <td>Search Type:
	      <select name="searchType">
	        <option value="0" <?php if ($searchType == 0) {echo "selected='selected'";}?>>All</option>
	        <option value="1" <?php if ($searchType == 1) {echo "selected='selected'";}?>>Assets</option>
	        <option value="2" <?php if ($searchType == 2) {echo "selected='selected'";}?>>Tickets</option>
					<option value="3" <?php if ($searchType == 3) {echo "selected='selected'";}?>>PO Number</option>
					<option value="4" <?php if ($searchType == 4) {echo "selected='selected'";}?>>Contract</option>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td>
	    <?php
	    CreateSubmit("search","Search");
	    CreateHiddenField("page",$page);
	    ?>
	    </td>
	    <td>&nbsp;
	    </td>
	  </tr>
	</table>
	</form>
</div>
<div id="results"></div>
