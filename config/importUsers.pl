#!/usr/bin/perl -l
use strict;
use DBI;

my $dbh = DBI->connect('dbi:mysql:trackerVS','root','') or die "Connection Error: $DBI::errstr\n";

my $sthUser = $dbh->prepare("select * from users where email = ?");
my $sthInsertUser = $dbh->prepare("Insert into users (email,password,fullName,active) values (?,md5(?),?,1)");
my $shtOrganization = $dbh->prepare("select * from organization where name = ?");
my $sthInsertUserToOrganization = $dbh->prepare("Insert into userToOrganization (userId,organizationId) values (?,?)");
my $sthInsertUserToGroup = $dbh->prepare("Insert into userToGroup (userId,userGroupId) values (?,?)");

my %hash;
open my $fh, '<', 'ExportData.csv' or die "Cannot open: $!";
my $file = "ExportData.csv";
open my $in, "<:encoding(utf8)", $file or die "$file: $!";
my @lines = <$in>;
close $in;
 
chomp @lines;
for my $line (@lines) {
	chomp $line;
    my ($fullName, $email) = split /,/, $line;
    #print $email."\n";
    $sthUser->execute($email);
    my $user = $sthUser->fetchrow_hashref();
    if (!exists($user->{userId}))
    {
    	my ($name,$domain) = split /@/,$email;
    	my $orgName = "unknown";
        print "domain:".$domain."\n";
    	if ($domain eq "villagesoup.com")
    	{
    		$orgName = "Courier Publications";
    	}

    	if ($domain eq "courierpublicationsllc.com")
    	{
    		$orgName = "Courier Publications";
    	}
    	if ($domain eq "meseniors.com")
    	{
    		$orgName = "Maine Senior Living";    		
    	}
    	if ($orgName eq "unknown")
    	{
    		print "unknown:".$email."\n";
    	}
    	else
    	{
    		print $email."\n";
    		$shtOrganization->execute($orgName);
    		my $organization = $shtOrganization->fetchrow_hashref();
    		print "orgname:".$organization->{name}."\n";
    		my $password ="password";
    		$sthInsertUser->execute($email,$password,$fullName);
    		my $userId =$sthInsertUser->{mysql_insertid};
    		$sthInsertUserToOrganization->execute($userId,$organization->{organizationId});
    		$sthInsertUserToGroup->execute($userId,5);
    	}
    	
    }
}