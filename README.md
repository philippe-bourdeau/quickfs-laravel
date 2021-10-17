This is a laravel/jetstream application

# Helpers 

check docker/bin/tools.sh for project related tools

## Xdebug on the commandline 
XDEBUG_TRIGGER=yes ./vendor/bin/phpunit ./tests

* Jump into the cli container to interact with the code base (cli-sh)
* Manage docker containers

# Onboarding and cli common operations

```sh
composer install;
npm test;
```

# Handling views

To ensure you are working with an up-to-date version of you views, recompile your assets

```sh
# Compile your CSS / JavaScript for development...
npm run dev

# Compile your CSS / JavaScript for production...
npm run prod

# Compile your CSS / JavaScript for development and recompile on change...
npm run watch
```

TODO
* Arrange layout
* Test summary and other classes
* Add pay-to-access functionality
* Landing page
* Add operating cash flow
* Redis 
    -add job support (start with mail)
    -cache quickfs-statements
* Add database for tests (Featured)
