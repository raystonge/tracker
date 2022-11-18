update monitor set name=fqdn;
update monitor set monitorType='URL' where length(monitorURL) >0;
update monitor set monitorType='ping' where length(pingAddress) > 0;
update monitor set monitorType='pingAddress' where length(ipAddress) > 0;
