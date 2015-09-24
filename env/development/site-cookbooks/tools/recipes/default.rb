#
# Cookbook Name:: tools
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
%w{ vim dstat htop }.each do |pkgname|
  package "#{pkgname}" do
    action :install
    options '--enablerepo=epel,remi'
  end
end
