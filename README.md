# Introduction
This is an inertia app (think "modern monolith" !)
*  Always return Inertia responses, not the usual Illuminate\Http\Response

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

### Known limitations
* Cashier has a basic implementation of webhooks (ex. customer.updated only updates default payment method - not user info)
* Generating tls certificates / dhparam.pem and onboarding those files in the nginx container has to be done manually 

### First time
* generate tls cert & key (certbot) ; dhparam
* composer install
* npm install
* migration
* .env file

## Run the app
To launch the containers with appropriate dockerfile
```sh
docker-compose -f docker-compose.production.yml up --build
```

```sh
composer install
php artisan migrate
ngrok http 8080
# Jump in container and run
docker exec -it cli sh
npm run dev
php artisan cache clear
php artisan cashier:webhook --url "https://b896-70-81-68-170.ngrok.io"
```
Then 
* configure endpoint on Stripe dashboard
* copy webhook secret and set it in the .env file

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
* Backup mysql database
* email verified
* Double check on
  * CORS
  * CSP

### Backend
* Tests
  * Inertia responses ?
  * Stripe test clocks
  * Stripe mocks ?
* Redis cache & queue (dispatch events when receiving webhook OR user update, etc.)
* Logger webhooks / events
* Taxes

### UI & prod
* Revoir landing page et menu
* message si webhook pending ? https://laravel.com/docs/8.x/billing#stripe-checkout-subscriptions-and-webhooks
* améliorer redirections après achat ou registration
    * éviter la page home et retourner directement sur dashboard
    * en ce moment fonctionne mais casse sur la page register si loggé (redirige vers dashboard)
* checkout billing portal returns to home instead of returning to last page before entering portal (i.e. dashboard)
* Add summary data
    * outstanding shares
    * operating cash flow
* Improve top form readability(with market cap)
* Improve display for intrinsic value
* Separate ticker country / ticker ?
* text input for ticker
* select input for country
