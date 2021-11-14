Main tools : 
 * Laravel
 * JetStream
 * Inertia ("SSR" for Laravel + Vue)
 * Cashier (Stripe Integration)
 
## Onboarding

```sh
composer install
php artisan migrate
```

## Tests

### PHP tests with debugger
Install XDEBUG locally and update configuration (pecl install xdebug, modify local php.ini,etc.)
```shell
XDEBUG_TRIGGER=yes ./vendor/bin/phpunit -c phpunit.xml
```

### Javascript tests
```shell
docker exec -it cli sh
npm test
```

## Helpers

source docker/bin/tools.sh for project related helper functions


## Run the application

```shell
docker exec -it cli sh
```

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
* user data sync Application <=> Stripe
* Webhooks
* Redis 
    -add job support (start with mail)
    -cache quickfs-statements
* SCA - Strong customer authentication
* Taxes

### Tests
* Stripe mountebank
* Test database for featured jetstream tests (not working atm)
