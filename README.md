# Introduction
This is an inertia app (think "modern monolith" !)
*  Always return Inertia responses, not the usual Illuminate\Http\Response

## Main tools
 * [Laravel](https://laravel.com) : Web backend framework
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

### Known limitations
* Cashier has a basic implementation of webhooks (ex. customer.updated only updates default payment method - not user info)
* Generating tls certificates / dhparam.pem and onboarding those files in the nginx container has to be done manually 

### First time
* publish assets (inertia and cashier assets)
* generate tls cert & key (certbot) & ssl_dhparam
* migration
* adjust .env file

## Start ngrok for local dev (webhook tunneling)
```shell
ngrok http 8080
```

## Run the app
To launch the containers with appropriate dockerfile
```sh
docker-compose -f docker-compose.production.yml up --build
```

## Configure Stripe webhook with cashier command
*** Required to be done on each container start ***
1. This command will create a webhook on the stripe api, will listen only to relevant events
```shell
php artisan cashier:webhook --url "https://b896-70-81-68-170.ngrok.io/stripe/webhook"
```
2. Go retrieve webhook secret on the Stripe dashboard, then put it in the .env file

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
* Add dockerignore
* Add checkout success page
* Vérification expiration
* Free trial
* Email verified
* Backup mysql database
* Double check on
  * CORS
  * CSP

### Backend
* CI/CD
* Tests
  * Inertia responses ?
  * Stripe test clocks
  * Stripe mocks ?
* Redis cache & queue (dispatch events when receiving webhook OR user update, etc.)
* Logger webhooks / events
* Taxes
* update node container
* update php 8.1

### UI & prod
* Améliorer navigation, menu et layouts
* message si webhook pending ? https://laravel.com/docs/8.x/billing#stripe-checkout-subscriptions-and-webhooks
* Add summary data
    * outstanding shares
    * operating cash flow
* Improve top form readability(with market cap)
* Improve display for intrinsic value
* Separate ticker country / ticker ?
* text input for ticker
* select input for country
