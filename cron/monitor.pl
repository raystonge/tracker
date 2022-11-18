#!/usr/bin/perl -l
use strict;
use DBI;
use Net::Ping;

use MIME::Lite;


#use Switch;
use LWP::Simple;
my $network;
my $network;
my $ignore = "noIgnore";
my $args = @ARGV;
my $first = 1;
my $filename = '/tmp/monitor.tst';
if (-e $filename) {
 my $mtime = ( stat $filename )[9];
 my $current_time = time;
 my $diff = $current_time - $mtime;
 if ($diff < 1800)
 {
   exit;
 }
 unlink $filename;
}

open (MYFILE, ">$filename") || die "could not create file" ;
print MYFILE "monitor\n";
close (MYFILE);


unless (-e $filename) {
 print "File Doesn't Exist!\n";
 exit;
 }

#my $timeout = 5;
my $timeout = 10;
#print "testing network: $network\n";
my $dbh = DBI->connect('dbi:mysql:trackerVS:svn.villagesoup.com','villagesoup','ed81kc') or die "Connection Error: $DBI::errstr\n";

my $sqlReset = "update users set emailMessage=null";
my $sth = $dbh->prepare($sqlReset);
$sth->execute();


my $sql = "select * from monitor where active=1";
my  $sth = $dbh->prepare($sql);
  $sth->execute();

my $device;
my $i;
my $query;
my $ip;
my $monitorURL;
my $p = Net::Ping->new("icmp");
#print "In Monitor\n\r";
while ($device = $sth->fetchrow_hashref())
{
  my $isUp = 1;
  my $currentState = "up";
  my $lastState = "down";
  if ($device->{'state'})
  {
    $lastState = "up";
  }
  #print "Hello";
  my $monitorId = $device->{'monitorId'};
  my $ip;
  if (length($device->{'pingAddress'}))
  {
    $ip = $device->{'pingAddress'};
  }
  else
  {
    $ip = $device->{'ipAddress'};
  }
  $monitorURL = $device->{'monitorURL'};
  #print "URL";
  #print "monitorURL=$monitorURL\n\r";
  if (length($monitorURL))
  {
    my $siteDown = 1;

   # print "URL:$monitorURL\n\r";
    my $browser = LWP::UserAgent->new;
    my $lwp = LWP::UserAgent->new(agent=>' Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', cookie_jar=>{});
    my $file = "/tmp/i.jpg";
    if (-e $file)
    {
      unlink ($file)  or warn "Could not unlink $file: $!";
    }
    my $ua;
    my $url = $monitorURL;
   # print $url."\n";
    if (index($url, "https") != -1)
    {
      $ua = LWP::UserAgent->new(ssl_opts => { verify_hostname => 0 },    protocols_allowed => ['https'],);
    }
    else
    {
      $ua = LWP::UserAgent->new(ssl_opts => { verify_hostname => 0 },);
    }


    my $req = HTTP::Request->new(GET => $url,);

    my $res = $ua->request($req);

#    my $resp = $lwp->mirror($monitorURL, $file);
#    if ($resp->is_success)
    if ($res->code == 200)
    {
     $siteDown = 0;
     #print "success\n";
     #return 0;
    }
    if ($siteDown)
    {
      $isUp = 0;
      $currentState = "down";
    }
    else
    {
      $isUp = 1;
      $currentState = "up";
    }

    #print "siteDown:$siteDown\n\r";
  }
  else
  {

    if (!$p->ping($ip,$timeout))
    {
      $isUp = 0;
      $currentState = "down";
      for ($i = 0; $i < 3 && !$isUp; $i++)
      {
        if ($p->ping($ip,$timeout))
        {
          $isUp = 1;
          $currentState = "up";
        }
      }
    }
    else
    {
      $isUp = 1;
      $currentState = "up";
    }
  }
  my $stateChange = 0;
  if ($lastState ne $currentState)
  {
    $stateChange = 1;
  }
#  my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
#  my $now = sprintf("%04d-%02d-%02d %02d:%02d:%02d", $year+1900, $mon+1, $mday, $hour, $min, $sec);
#  $query = "update monitor set state=?,stateChangeDateTime=? where monitorId=?";
#  my $updateDBH = $dbh->prepare($query);
#  $updateDBH->execute($isUp,$now,$monitorId);

  #print $stateChange."-";
    my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);
    my $now = sprintf("%04d-%02d-%02d %02d:%02d:%02d", $year+1900, $mon+1, $mday, $hour, $min, $sec);
    if ($stateChange)
    {
      #print "updating db state ".$device->{'fqdn'}."\n";
      my $query = "update monitor set state=?,stateChangeDateTime=? where monitorId=?";
      my $updateDBH = $dbh->prepare($query);
      $updateDBH->execute($isUp,$now,$monitorId);
      $query = "select * from monitorToUser where monitorId=?";
      my  $sthMonitor = $dbh->prepare($query);
      $sthMonitor->execute($monitorId);
      my $historyQuery = "Insert into history (actionDate,action,assetId) value (?,?,?)";
      my $sthHistory = $dbh->prepare($historyQuery);
      my $action;
      if ($isUp)
      {
        $action = "Device is now online";
      }
      else
      {
        $action = "Device is now offline";
      }
      $sthHistory->execute($now,$action,$device->{'assetId'});
      my $monitorToUser;
      while ($monitorToUser = $sthMonitor->fetchrow_hashref())
      {
         my $userId = $monitorToUser->{'userId'};
         my $userQuery = "select * from users where userId=?";
         my $sthUser = $dbh->prepare($userQuery);
         $sthUser->execute($userId);
         my $user = $sthUser->fetchrow_hashref();
         my $emailMessage = $user->{'emailMessage'};
         my $txt = "down";
         if ($isUp)
         {
           $txt = "up";
         }
         my $msg = $device->{'ipAddress'}.":".$device->{'fqdn'}." is now ".$txt."\n";
         #print $msg."\n";
         $emailMessage = $emailMessage ."<br>\n\r". $msg;
         #print $emailMessage."\n";
         my $userUpdate = "update users set emailMessage=? where userId=?";
         my $sthUserUpdate = $dbh->prepare($userUpdate);
         $sthUserUpdate->execute($emailMessage,$userId);
      }

    }
}

my $userQuery = "select * from users where emailMessage is not null";
my $usersSth = $dbh->prepare($userQuery);
$usersSth->execute();
my $user;
my $from = "systems\@villagesoup.com";
my $subject = 'Device status has changed';
while ($user = $usersSth->fetchrow_hashref())
{
  my $emailMessage = $user->{'emailMessage'};
  $emailMessage =~ s/^\s+|\s+$//g;
  if (length($emailMessage) > 0)
  {
    my $to = $user->{'email'};
    #open(MAIL, "|/usr/sbin/sendmail -t");
    # Email Header
    #print MAIL "To: $to\n";
    #print MAIL "From: $from\n";
    #print MAIL "Subject: $subject\n";
    # Email Body
    #print MAIL $emailMessage;
    #print $emailMessage;
    #close(MAIL);


    my $msg = MIME::Lite->new(
                 From     => $from,
                 To       => $to,
                 #Cc       => $cc,
                 Subject  => $subject,
                 Data     => $emailMessage
                 );

$msg->attr("content-type" => "text/html");
#$msg->send;
  }
}
unlink $filename;