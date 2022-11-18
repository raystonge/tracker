#!/usr/bin/perl -l

use strict;
use warnings;
use LWP::UserAgent;

my $url = 'https://knox-cloud-web-2.villagesoup.com/clients/CourierPublications/sites/knox/img/headerLogo.gif';
#my $url = 'https://knox-dev.villagesoup.com/clients/CourierPublications/sites/knox/img/headerLogo.gif';
#my $url = 'http://knox.villagesoup.com/clients/CourierPublications/sites/knox/img/headerLogo.gif';

my $ua;

print $url."\n";
if (index($url, "https") != -1)
{
  $ua = LWP::UserAgent->new(ssl_opts => { verify_hostname => 0 },    protocols_allowed => ['https'],);
}
else
{
  $ua = LWP::UserAgent->new(ssl_opts => { verify_hostname => 0 },

);

}


my $req = HTTP::Request->new(
    GET => $url,
);

my $res = $ua->request($req);
print $res->code;
my $siteDown = 1;
my $isUp = 0;
if ($res->code == 200)
{
 $siteDown = 0;
 #print "success\n";
 #return 0;
}
my $currentState;
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
print "state:".$currentState."\n";
