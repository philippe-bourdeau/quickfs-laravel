Main tools : 
 * Laravel
 * JetStream
 * Inertia ("SSR" for Laravel + Vue)
 * Cashier (Stripe Integration)
 * Ngrok (for development - provides tunnel for Stripe webhooks)

## Stripe
* Stripe has 2 environments (TEST AND PRODUCTION)
* Stripe checkout REQUIRES webhooks
* Specify webhook url in development (have to run it every time you open a new ngrok tunnel)
```shell
ngrok http 8080
php artisan cashier:webhook --url "https://bfef-70-81-68-170.ngrok.io/stripe/webhook"
``` 
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
* Manage user subscription (billing portal)
  * on dashboard too ?
  * inspect stripe portal
* laravel logo in reset password
* add inertia tests ? (redirects, middleware...)

Double check on :
* CORS
* CSP

### Backend
* Backup mysql database
* user data sync Application <=> Stripe
* Redis
    - cache financial data
* SCA - Strong customer authentication
* Taxes

### UI & prod
* Add summary data
    * outstanding shares
    * operating cash flow
* Improve top form readability(with market cap)
* Improve display for intrinsic value
* Landing page
* Separate ticker country / ticker ?
* text input for ticker
* select input for country
