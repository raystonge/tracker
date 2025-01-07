#!/usr/bin/perl -l
use strict;

use Net::Ping;
use LWP::Simple;
use Net::Ping;
use WWW::Curl::Easy;
#use Switch;
#use MIME::Lite;

my $contents;
my $domain;
$domain = "http://tracker.dev.raywaresoftware.com";
my $url;
$url = $domain."/api/getKey.php";
print "getKey";
$contents = get($url);
die "Can't get $url" if (! defined $contents);
my $key = $contents;
my $name   = $ARGV[0];
#print $contents
$url = $domain."/api/getMonitorData.php?key=".$contents."&monitor=".$name;

print $url;
print "getMonitorData";
$contents = get($url);

print $contents;

my $data;

$data = "";

my @lines = split /\n/,$contents;

foreach my $line (@lines)
{
    chomp $line;
    $line =~ s/\n//g;
    $line =~ s/\r//g;
    my $id;
    my $ip;
    my $monitorType;
    ($id,$monitorType,$ip) = split(/,/,$line);
    if ($monitorType eq "ping" || $monitorType eq "pingAddress")
    {
      my $pinger = Net::Ping->new("icmp");
      if ($pinger->ping($ip))
      {
        #print  $id.",",$ip.",1\n";
        $data = $data.$id."|".$ip."|1\n";
      }
      else
      {
        #print  $id.",",$ip."0\n";
        $data = $data.$id."|".$ip."|0\n";
      }
    }
    if ($monitorType eq "URL")
    {

    }

}

my $ch;
$url = $domain."/api/postMonitorData.php";
#$ch = curl_init($url);
my $postData;
my $postItems;

my $value;
$postItems = "key=".$key."&data=".$data."&monitor=".$name;
print $postItems;

$url = $url.'?'.$postItems;
print $url;
print "postMonitorData";
$contents = get($url);
print  "results";
print $contents;
