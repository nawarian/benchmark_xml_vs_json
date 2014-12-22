Vagrant.configure("2") do |config|
    config.vm.box = "debian32"

    config.ssh.forward_agent = true

    config.vm.provider :virtualbox do |v, override|
        override.vm.box_url = "http://opscode-vm-bento.s3.amazonaws.com/vagrant/virtualbox/opscode_debian-6.0.8-i386_chef-provisionerless.box"
  
        v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
        v.customize ["modifyvm", :id, "--memory", 256]
    end

    config.vm.provision :shell, :path => "./provision.sh"

end