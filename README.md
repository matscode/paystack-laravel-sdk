# Paystack Laravel SDK

A modern, maintainable, and extensible Paystack integration for Laravel, built on top of the [matscode/paystack-php-sdk](https://packagist.org/packages/matscode/paystack-php-sdk). Feel free to reference the main SDK to see other available api method/property

---

## Features

- Clean, service-based Paystack API integration
- Laravel service provider and facade
- Global `paystack()` helper for convenient access
- Uses [matscode/paystack-php-sdk](https://packagist.org/packages/matscode/paystack-php-sdk) under the hood
- Configurable via `config/paystack.php`
- Well-documented

---

## Requirements

- PHP 8.0+
- Laravel 9.0+
- [matscode/paystack-php-sdk](https://packagist.org/packages/matscode/paystack-php-sdk) (installed automatically)

---

## Installation

Install via Composer:

```bash
composer require matscode/paystack-laravel-sdk
```

---

## Configuration

Optionally, publish the config file:

```bash
php artisan vendor:publish --provider="Matscode\\PaystackLaravel\\PaystackServiceProvider" --tag="config"
```

Set your Paystack secret key in your `.env` file:

```bash
PAYSTACK_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxxxxxxxxx
```

---

## Usage

You can use the Paystack SDK in Laravel via:

- The `Paystack` Facade (recommended)
- Dependency Injection (`Matscode\Paystack\Paystack`)
- The `paystack()` helper (just like `request()` or `auth()`)

> **Note:**
>
> | Access Style         | Facade (`Paystack`) | DI (`app(...)`) | Helper (`paystack()`) |
> |---------------------|:------------------:|:---------------:|:--------------------:|
> | Method call         |      ✅ Yes         |      ✅ Yes      |        ✅ Yes         |
> | Property access     |      ❌ No          |      ✅ Yes      |        ✅ Yes         |
>
> - For the Facade, you must use static method calls for resources, such as `Paystack::transaction()`. Property access like `Paystack::transaction` will **not** work.
> - For DI and the helper, both method calls (`->transaction()`) and property access (`->transaction`) are supported.
> - Always use the method call syntax for maximum compatibility.


---

### Transaction Resource

#### Initialize Transaction

Initializes a new transaction and returns an authorization URL for the customer to complete payment. The response contains the transaction reference and other details.

```php
// Using the Facade
Paystack::transaction()->initialize([
    'email' => 'customer@email.com',
    'amount' => 500000, // amount in kobo
    'callback_url' => 'https://yourapp.com/paystack/transaction/verify',
]);

// Using the helper
paystack()->transaction->initialize([
    'email' => 'customer@email.com',
    'amount' => 500000, // amount in kobo
    'callback_url' => 'https://yourapp.com/paystack/transaction/verify',
]);
```

#### List Transactions

Retrieves a list of all transactions carried out on your Paystack account. Returns an array of transaction objects.

```php
// Using the Facade
Paystack::transaction()->list();

// Using the helper
paystack()->transaction->list();
```

#### Verify Transaction

Verifies the status of a transaction using its reference. Returns the transaction details if found.

```php
// Using the Facade
$verification = Paystack::transaction()->verify($reference);

// Using the helper
$verification = paystack()->transaction->verify($reference);
```

#### Check if Transaction is Successful

Checks if a transaction was successful using its reference. Returns `true` if successful, otherwise `false`.

```php
// Using the Facade
$isSuccessful = Paystack::transaction()->isSuccessful($reference); // returns true/false

// Using the helper
$isSuccessful = paystack()->transaction->isSuccessful($reference);
```

## Example: Initializing a Transaction with the Paystack Facade (Laravel)

You can use the Paystack facade with method chaining to initialize a transaction and get the payment authorization URL:

```php
use Paystack; // Make sure the facade is properly registered

// ... inside your controller or service

$response = Paystack::transaction()
    ->setCallbackUrl('https://yourapp.com/paystack/verify')
    ->setEmail('customer@email.com')
    ->setAmount(75000) // amount in Naira
    ->initialize();

$authorizationUrl = $response->data->authorization_url;

// Using the helper
$response = paystack()->transaction
    ->setCallbackUrl('https://yourapp.com/paystack/verify')
    ->setEmail('customer@email.com')
    ->setAmount(75000)
    ->initialize();
$authorizationUrl = $response->data->authorization_url;
```

- `setCallbackUrl()` sets the URL Paystack will redirect to after payment.
- `setEmail()` sets the customer's email.
- `setAmount()` sets the amount (in Naira, not kobo, when using this method).
- `initialize()` sends the request to Paystack and returns the response.
- The authorization URL for redirecting the user is in `$response->data->authorization_url`.

If you want to use the array method (amount in kobo):

```php
// Using the Facade
$response = Paystack::transaction()->initialize([
    'email' => 'customer@email.com',
    'amount' => 500000, // amount in kobo
    'callback_url' => 'https://yourapp.com/paystack/verify',
]);
$authorizationUrl = $response['data']['authorization_url'];

// Using the helper
$response = paystack()->transaction->initialize([
    'email' => 'customer@email.com',
    'amount' => 500000, // amount in kobo
    'callback_url' => 'https://yourapp.com/paystack/verify',
]);
$authorizationUrl = $response['data']['authorization_url'];
```

---

### Bank Resource

#### List Banks

Retrieves a list of all supported banks for your Paystack account. Useful for populating bank selection dropdowns in forms.

```php
// Using the Facade
Paystack::bank()->list();

// Using the helper
paystack()->bank->list();
```

#### Resolve Account Information

Resolves and validates a Nigerian bank account number and bank code. Returns the account name and other details if valid.

```php
// Using the Facade
$account = Paystack::bank()->resolve($bankCode, $accountNumber);

// Using the helper
$account = paystack()->bank->resolve($bankCode, $accountNumber);
```

---

> **Note:** More resources (Customers, Plans, Subscription, Transfers, etc.) may be added as the SDK evolves. For the latest, see the [PHP SDK documentation](https://packagist.org/packages/matscode/paystack-php-sdk).

---

## License

This library is licensed under the GNU General Public License v3.0 (GPL-3.0). See the [LICENSE](./LICENSE) file for the full license text.
