# AppSumo Laravel Package

A Laravel package for seamless integration with AppSumo Licensing. This package handles the OAuth flow and webhook events automatically, so you can easily manage license activations, upgrades, downgrades, and deactivations directly from your Laravel application.

## Features

- **OAuth Integration:** Automatically handles the OAuth callback from AppSumo, exchanges the code for an access token, and retrieves the user’s license data.
- **Webhook Handling:** Receives and processes webhook events (purchase, activate, upgrade, downgrade, deactivate) from AppSumo.
- **HMAC Signature Verification:** Validates incoming webhook requests to ensure authenticity.
- **Simple Configuration:** Easily configure your AppSumo credentials and endpoint URLs using Laravel’s config system.
- **Extensible:** Customize business logic in the provided controllers to suit your application's needs.

## Requirements

- PHP >= 7.3
- Laravel 8.x, 9.x, or 10.x
- [GuzzleHTTP](https://github.com/guzzle/guzzle) (installed as a dependency)

## Installation

Install the package via Composer:

```bash
composer require your-namespace/appsumo
```

## Configuration

Publish the configuration file to your Laravel application's `config` directory:

```bash
php artisan vendor:publish --tag=config
```

This command will create a file named `config/appsumo.php` where you can set your AppSumo credentials and endpoint URLs. For example:

```php
<?php
return [
    // OAuth credentials
    'client_id'     => env('APPSUMO_CLIENT_ID', ''),
    'client_secret' => env('APPSUMO_CLIENT_SECRET', ''),
    'redirect_url'  => env('APPSUMO_REDIRECT_URL', 'https://your-app.com/appsumo/oauth/callback'),

    // Webhook settings
    'webhook_url'   => env('APPSUMO_WEBHOOK_URL', 'https://your-app.com/appsumo/webhook'),
    'webhook_secret'=> env('APPSUMO_WEBHOOK_SECRET', ''),

    // Licensing API key
    'api_key'       => env('APPSUMO_API_KEY', ''),
];
```

Update your `.env` file with the corresponding values:

```dotenv
APPSUMO_CLIENT_ID=your-client-id
APPSUMO_CLIENT_SECRET=your-client-secret
APPSUMO_REDIRECT_URL=https://your-app.com/appsumo/oauth/callback
APPSUMO_WEBHOOK_URL=https://your-app.com/appsumo/webhook
APPSUMO_WEBHOOK_SECRET=your-webhook-secret
APPSUMO_API_KEY=your-licensing-api-key
```

## Usage

### OAuth Flow

After a user authorizes your application on AppSumo, they will be redirected to your OAuth callback URL:

```
https://your-app.com/appsumo/oauth/callback
```

The `OAuthController` will:

- Extract the OAuth code from the query parameters.
- Exchange the code for an access token.
- Fetch the user's license key using the access token.

You can customize the logic inside `OAuthController.php` to create or update user accounts based on the license information.

### Webhook Endpoint

Set your webhook URL in the AppSumo Partner Portal to:

```
https://your-app.com/appsumo/webhook
```

The `WebhookController` automatically:

- Validates the incoming webhook request using HMAC SHA256 signature verification.
- Processes the event data (purchase, activate, upgrade, downgrade, deactivate).
- Logs or updates your system based on the event type.

Customize the processing logic in `WebhookController.php` to suit your business requirements.

### Facade (Optional)

If you prefer a static interface, you can use the provided facade:

```php
use AppSumo;

$accessToken = AppSumo::getAccessToken($code);
$licenseData = AppSumo::getLicense($accessToken);
```

### Routes

The package automatically registers the following routes (prefixed with `appsumo`):

- **OAuth Callback:** `GET /appsumo/oauth/callback`
- **Webhook Endpoint:** `POST /appsumo/webhook`

Ensure these routes do not conflict with any existing routes in your application.

## Testing

To test your integration:

1. **Set Up in AppSumo:**
   - Configure your test product in the AppSumo Partner Portal with the proper OAuth Redirect and Webhook URLs.
2. **Trigger OAuth Flow:**
   - Initiate the OAuth process and confirm that your callback correctly processes the code and retrieves the license data.
3. **Simulate Webhook Events:**
   - Use the test webhook feature in the AppSumo Partner Portal to simulate events and verify that your application processes them as expected. Check your logs for confirmation messages.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your improvements. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).
