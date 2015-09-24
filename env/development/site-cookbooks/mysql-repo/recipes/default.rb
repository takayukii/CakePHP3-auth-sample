#
# Cookbook Name:: mysql-repo
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
remote_file "/tmp/mysql-community-release-el6-5.noarch.rpm" do
  source 'http://repo.mysql.com/mysql-community-release-el6-5.noarch.rpm'
  action :create
end

rpm_package "mysql-community-release" do
  source "/tmp/mysql-community-release-el6-5.noarch.rpm"
  action :install
end