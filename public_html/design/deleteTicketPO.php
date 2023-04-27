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
<?php
include_once "tracker/ticketPO.php";
include_once "tracker/poNumber.php";
$ticketPOId = $request_uri[2];
$ticketPO = new TicketPO($ticketPOId);
$po = new poNumber($ticketPO->poNumberId);
$ticketPO->Delete($ticketPOId);
echo "PO Number ".$po->poNumber." has been removed from ticket ".$ticketPO->ticketId;
?>
<a href="/ticketPO/<?php echo $ticketPO->ticketId;?>/">Click here to return to the ticket</a>
