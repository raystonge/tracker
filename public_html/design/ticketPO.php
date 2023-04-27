<?php
//
//  Tracker - Version 1.8.0
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
<div class="adminArea">
<?php
$assetId = 0;
if (isset($request_uri[2]))
{
	$ticketId = $request_uri[2];
}
include_once "tracker/ticket.php";
include_once "tracker/ticketPO.php";
include_once "tracker/poNumber.php";
$timeWorked = 0;
$ticket = new Ticket($ticketId);
include $sitePath."/design/ticket/ticketInfoHeader.php";

?>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/ticket/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

<div class="clear"></div>
<?php
if (FormErrors())
{
   	DisplayFormErrors();
}
if (FormSuccess())
{
	DisplayFormSuccess();
}
 ?>
  <form method="post" action ="/process/ticket/ticketPO.php">
    <table width="100%">
      <tr>
        <td>
          PO Number : <select id="poNumberId" name="poNumberId">
                        <option value="0">Select PO Number</option>
                        <?php
                        $po = new poNumber();
                        $param = "poType = 'AssetTicket'";
                        $ok = $po->Get($param);
                        while ($ok)
                        {
                          $param = AddEscapedParam("","ticketId",$ticketId);
                          $param = AddEscapedParam($param,"poNumberId",$po->poNumberId);
                          $ticketPO = new TicketPO();
                          if (!$ticketPO->Get($param))
                          {
                          ?>
                            <option value="<?php echo $po->poNumberId;?>"><?php echo $po->poNumber;?></option>
                          <?php
                          }
                          $ok = $po->Next();
                        }
                         ?>
                      </select>
        </td>
      </tr>
      <tr>
        <td>
          <?php
          CreateHiddenField("ticketId",$ticketId);
          PrintFormKey();
          CreateHiddenField("submitTest",1);
          CreateSubmit("submit","Add");
          ?>
        </td>
      </tr>
    </table>
  </form>
  <table width="100%">
    <tr>
      <th>
        PO Number
      </th>
      <th>
        Description
      </th>
      <th>
        Date
      </th>
      <th>
        Amount
      </th>
      <th>
        &nbsp;
      </th>
    </tr>
    <?php
    $ticketPO = new TicketPO();
    $param = AddEscapedParam("","ticketId",$ticketId);
    $ok = $ticketPO->Get($param);
    while ($ok)
    {
      $po = new poNumber($ticketPO->poNumberId);
      ?>
      <tr>
        <td>
          <a href="/poNumberEdit/<?php echo $po->poNumberId;?>"><?php echo $po->poNumber;?></a>
        </td>
        <td>
          <?php echo $po->description;?>
        </td>
        <td>
          <?php echo $po->poDate;?>
        </td>
        <td>
          <?php echo $po->cost;?>
        </td>
        <td>
          <?php
          $htmlAction = "";
          $htmlAction=$htmlAction.'<a href="/deleteTicketPO/'.$ticketPO->ticketPOId.'/" class="delete_ticketPO" ';
          if ($showMouseOvers)
          {
          	$htmlAction = $htmlAction.' title="Delete"';
          }
          $htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
          echo $htmlAction;
           ?>
        </td>
      </tr>
      <?php
      $ok = $ticketPO->Next();
    }
     ?>
  </table>
</div>
</div>
