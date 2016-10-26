set :application, "jet"
set :domain,      "ebay@108.59.12.8:10022"
set :deploy_to,   "/var/www/default/jet"

set :repository,  "https://artur_yukhatov@bitbucket.org/projektcs/jet-new.git"
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