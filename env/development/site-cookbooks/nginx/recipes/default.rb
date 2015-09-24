#
# Cookbook Name:: nginx
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
package "nginx" do
  action :install
  version "#{node[:nginx][:version]}"
end

service "nginx" do
  supports status: true, restart: true, reload: true
  action [:enable, :start]
end


template "/etc/nginx/conf.d/default.conf" do
  owner "root"
  mode  0644
  source "conf.d/default.conf.erb"
  notifies :restart, "service[nginx]"
end
