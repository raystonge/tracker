#!/usr/bin/perl

use strict;
use warnings;
use LWP::UserAgent;

#my $server = $ARGV[0];
 
#if (not defined $server) {
#  die "Need server\n";
#}
#print "server:".$server."\n";
my $lwp = LWP::UserAgent->new(agent=>' Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0', cookie_jar=>{});

my $link = 'http://knox.villagesoup.com/clients/CourierPublications/sites/knox/img/headerLogo.gif';
my $file = "/tmp/i.jpg";
unlink ($file)  or warn "Could not unlink $file: $!";

my $resp = $lwp->mirror($link, $file);

if ($resp->is_success)
{
 print "success\n";
 #return 0;
}
unless($resp->is_success) {
    print " did not respond\n";
    #print $resp->status_line;
}