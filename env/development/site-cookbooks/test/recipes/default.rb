#
# Cookbook Name:: tools
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
template "/tmp/test" do
  owner "root"
  mode  0644
  source "test.ini.erb"
  
  variables ({
        :host => "a",
        :user => "b",
        :password => "c",
        :db => "d"
 })
end
