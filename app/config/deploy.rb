set :application, "jet"
set :domain,      "108.59.12.8"
set :user,        "ebay"
set :port,        "10022"
set :deploy_to,   "/var/www/default/jet"

set :app_path,    "app"
set :bin_path, "bin"
set :var_path, "var"
set :web_path, "web"
set :symfony_console, app_path + "/console"
set :log_path, app_path + "/logs"
set :cache_path, app_path + "/cache"

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]

set :writable_dirs, [cache_path, log_path]
set :webserver_user, "www-data"
set :permission_method, :acl
set :use_set_permissions, false

set :use_composer, true
set :update_vendors, true
set :vendors_mode, "install"
set :dump_assetic_assets, true

set :repository,  "git@bitbucket.org:projektcs/jet-new.git"

set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server


set  :use_sudo,      false
set  :keep_releases,  3
set  :user,       "ebay"

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

after "deploy", "deploy:cleanup"