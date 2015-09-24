#
# Cookbook Name:: mysql
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

#server install
package "mysql-community-server" do
  action :install
  version "#{node[:mysql][:version]}"
end

service "mysqld" do
  supports status: true, restart: true, reload: true
  action [:enable, :start]
end

#server setting
template "/etc/my.cnf" do
  owner "root"
  mode  0644
  source "my.cnf.erb"
  notifies :restart, "service[mysqld]"
end

# data create
mysql_database = node[:mysql][:database]
mysql_user = node[:mysql][:user]
mysql_password = node[:mysql][:password]

execute "prepare database" do
  command "mysql -u root -e 'create database #{mysql_database} default charset utf8;'"
  not_if "mysql -u root -e 'show databases;' | grep #{mysql_database}"
end

grant_statement = "GRANT ALL PRIVILEGES ON *.* TO '#{mysql_user}'@'%' IDENTIFIED BY '#{mysql_password}' WITH GRANT OPTION;"
grant_statement += "GRANT ALL PRIVILEGES ON *.* TO '#{mysql_user}'@'localhost' IDENTIFIED BY '#{mysql_password}' WITH GRANT OPTION;"

sql_statement = "SELECT User FROM mysql.user WHERE User = '#{mysql_user}';"

execute "prepare user" do
  command "mysql -u root -e \"#{grant_statement}\""
  not_if "mysql -u root -e \"#{sql_statement}\" | grep #{mysql_user}"
end