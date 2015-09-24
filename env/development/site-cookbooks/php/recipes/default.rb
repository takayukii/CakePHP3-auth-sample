#
# Cookbook Name:: php
# Recipe:: default
#
# Copyright 2015, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
package "php" do
  action :install
  options '--enablerepo=remi,remi-php56'
  version '5.6.13-1.el6.remi'
end

%w{ php-mbstring php-mysqlnd php-fpm php-opcache php-intl php-devel php-mcrypt php-pecl-xdebug }.each do |pkgname|
  package "#{pkgname}" do
    action :install
    options '--enablerepo=remi,remi-php56'
  end
end

service "php-fpm" do
  supports status: true, restart: true, reload: true
  action [:enable, :start]
end

execute "composer_install" do
  command "curl -sS https://getcomposer.org/installer | php ;mv composer.phar /usr/local/bin/composer"
  not_if { ::File.exists?("/usr/local/bin/composer")}
end

template "/etc/php.ini" do
  owner "root"
  mode  0644
  source "php/php.ini.erb"
  notifies :restart, "service[php-fpm]"
end

template "/etc/php.d/10-opcache.ini" do
  owner "root"
  mode  0644
  source "php/php.d/10-opcache.ini.erb"
  notifies :restart, "service[php-fpm]"
end

template "/etc/php.d/15-xdebug.ini" do
  owner "root"
  mode  0644
  source "php/php.d/15-xdebug.ini.erb"
  notifies :restart, "service[php-fpm]"
end

template "/etc/php-fpm.d/www.conf" do
  owner "root"
  mode  0644
  source "php-fpm/www.conf.erb"
  notifies :restart, "service[php-fpm]"
end