Main tools : 
 * Laravel
 * JetStream
 * Inertia ("SSR" for Laravel + Vue)
 * Cashier (Stripe Integration)

# Helpers 

check docker/bin/tools.sh for project related tools

## Xdebug on the commandline 
XDEBUG_TRIGGER=yes ./vendor/bin/phpunit ./tests

* sh into the cli container to interact with the code base (cli-sh)
* Manage docker containers

# Onboarding and cli common operations

```sh
composer install;
npm test;
```

This application requires migrations !

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

### TODO : Next up
* Ensure user can manage his subscription (billing portal)
* Redirect to billing portal
* Add pay-to-access functionality - checkForActiveSubscriptionMiddleware
* inspect stripe portal


### UI 
* Add summary data
    * outstanding shares
    * operating cash flow
* Improve top form readability(with market cap)
* Improve display for intrinsic value
* Landing page
* Separate ticker country / ticker ?
* text input for ticker
* select input for country


### Backend
* Backup mysql database
* Webhooks + user sync Application <=> Stripe
* Redis 
    -add job support (start with mail)
    -cache quickfs-statements
* Taxes

### Tests
* Stripe mountebank
* Test database for featured jetstream tests (not working atm)
