#!/usr/bin/perl -l
use strict;
use DBI;
use Net::Ping;

use MIME::Lite;

my $host = "http://tracker.villagesoup.com";
#use Switch;
use LWP::Simple;
my $dbh = DBI->connect('dbi:mysql:trackerVS','root','') or die "Connection Error: $DBI::errstr\n";

my $sthTickets = $dbh->prepare("select * from ticket where ownerId=? and statusId not in (4,6) and dueDate<=? and dueDate !='0000-00-00'");
my $sthUsers = $dbh->prepare("select * from users u inner join  userToGroup utg  on u.userId=utg.userId where utg.userGroupId=2");
my $sthStatus = $dbh->prepare("select * from status where statusId = ?");
my $sthUser = $dbh->prepare("select * from users where userId = ?");
my $sthQueue = $dbh->prepare("select * from queue where queueId=?");
$sthUsers->execute();
my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time+(3 * 86400));
my $today = sprintf "%.4d-%.2d-%.2d", $year+1900, $mon+1, $mday;
print $today."\n";
my $user;
while ($user = $sthUsers->fetchrow_hashref)
{

	$sthTickets->execute($user->{userId},$today);
	if ($sthTickets->rows > 0)
	{
		print $user->{fullName}."\n";

   	    my $msg = "  <table id='myTickets' class='tablesorter' width='100%'>
                      <tr>
                        <th>Ticket</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Requestor</th>
                        <th>Queue</th>
                        <th>Last Updated</th>
                      </tr>\n";

		my $ticket;
		while ($ticket = $sthTickets->fetchrow_hashref)
		{
			$sthStatus->execute($ticket->{statusId});
			my $status = $sthStatus->fetchrow_hashref;
			$sthUser->execute($ticket->{requestorId});
			my $requestor = $sthUser->fetchrow_hashref;
			$sthQueue->execute($ticket->{queueId});
			my $queue = $sthQueue->fetchrow_hashref;
			print $ticket->{ticketId}."\n";
			$msg = $msg."<tr  class='mritem'>
                          <td>
                            <a href='$host/ticketEdit/$ticket->{ticketId}'>$ticket->{ticketId}</a>
                          </td>
                          <td>$ticket->{subject}</td>
                          <td>$status->{name}</td>
                          <td>$requestor->{fullName}</td>
                          <td>$queue->{name}</td>
                          <td>$ticket->{lastUpdated}</td>
                         </tr>\n";
		}
		$msg = $msg."</table>";
		my $from = "systems\@villagesoup.com";
		my $subject = "Priority Tickets";
		print $msg."\n";
		    my $to = $user->{'email'};
    my $msg = MIME::Lite->new(
                 From     => $from,
                 To       => $to,
                 #Cc       => $cc,
                 Subject  => $subject,
                 Data     => $msg
                 );

    $msg->attr("content-type" => "text/html");
    $msg->send;

	}

}
