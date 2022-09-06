# Introduction
This is an inertia app (think "modern monolith" !)
*  Always return Inertia responses, not the usual 

## Main tools
 * Laravel (backend framework)
 * JetStream (laravel "starter kit" bundle : auth, profile management etc.)
 * Vue.js (frontend framework)
 * Inertia (Adapter for Laravel + Vue)
 * Cashier (Stripe Checkout Integration)
 * Ngrok (for development - provides tunnel for Stripe webhooks)

## Stripe
* Checkout integration
* Stripe checkout REQUIRES webhooks
* Webhook url in development ***have to run it every time you open a new ngrok tunnel***
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
```shell
XDEBUG_TRIGGER=yes ./vendor/bin/phpunit
```

### Javascript tests
```shell
npm test
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
* Tests 
  * Inertia responses ?
  * Stripe test clocks
  * Stripe mocks ?

* tester portail stripe 
* Landing page ; revoir page accueil ; menu dashboard vs landing page (connnecté / non-connecté ... )
* message si webhook pending ? https://laravel.com/docs/8.x/billing#stripe-checkout-subscriptions-and-webhooks

Double check on :
* CORS
* CSP

### Backend
* Backup mysql database
* améliorer webhooks : user data sync limité (ex. customer.update vise seulement la méthode de paiment @see WebhookController )  - extend Webhook Controller
* Redis cache & queue
* Logger webhooks ?
* Taxes

### UI & prod
* Add summary data
    * outstanding shares
    * operating cash flow
* Improve top form readability(with market cap)
* Improve display for intrinsic value
* Separate ticker country / ticker ?
* text input for ticker
* select input for country
