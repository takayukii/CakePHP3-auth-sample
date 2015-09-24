cookbook_path    ["cookbooks", "site-cookbooks"]
node_path        "nodes"
role_path        "roles"
environment_path "environments"
data_bag_path    "data_bags"
#encrypted_data_bag_secret "data_bag_key"

knife[:berkshelf_path] = "cookbooks"
Chef::Config[:ssl_verify_mode] = :verify_peer if defined? ::Chef

knife[:cygdrive_prefix_local] = '/cygdrive'  # prefix for your local machine, set to empty string for MinGW
knife[:cygdrive_prefix_remote] = '/cygdrive' # prefix on the remote windows node

## knife zero ###
local_mode true
knife[:ssh_user] = "vagrant"
knife[:use_sudo] = true
knife[:ssh_attribute] = 'knife_zero.host'