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

Publish the config file:

```bash
php artisan vendor:publish --provider="Matscode\\PaystackLaravel\\PaystackServiceProvider" --tag="config"
```

Set your Paystack secret key in your `.env` file:

```
PAYSTACK_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxxxxxxxxx
```

---

## Usage

You can use the Paystack SDK in Laravel via:
- The `Paystack` Facade (recommended)
- Dependency Injection (`Matscode\Paystack\Paystack`)
- The `paystack()` helper (just like `request()` or `auth()`)

**All examples below use the Facade approach, but you may use DI or the helper if you prefer.**

---

### Transaction Resource

#### Initialize Transaction

Initializes a new transaction and returns an authorization URL for the customer to complete payment. The response contains the transaction reference and other details.

```php
Paystack::transaction->initialize([
    'email' => 'customer@email.com',
    'amount' => 500000, // amount in kobo
    'callback_url' => 'https://yourapp.com/paystack/transaction/verify',
]);
```

#### List Transactions

Retrieves a list of all transactions carried out on your Paystack account. Returns an array of transaction objects.

```php
Paystack::transaction->list();
```

#### Verify Transaction

Verifies the status of a transaction using its reference. Returns the transaction details if found.

```php
$verification = Paystack::transaction->verify($reference);
```

#### Check if Transaction is Successful

Checks if a transaction was successful using its reference. Returns `true` if successful, otherwise `false`.

```php
$isSuccessful = Paystack::transaction->isSuccessful($reference); // returns true/false
```

---

### Bank Resource

#### List Banks

Retrieves a list of all supported banks for your Paystack account. Useful for populating bank selection dropdowns in forms.

```php
Paystack::bank->list();
```

#### Resolve Account Information

Resolves and validates a Nigerian bank account number and bank code. Returns the account name and other details if valid.

```php
$account = Paystack::bank->resolve($bankCode, $accountNumber);
```

---

> **Note:** More resources (Customers, Plans, Subscription, Transfers, etc.) may be added as the SDK evolves. For the latest, see the [PHP SDK documentation](https://packagist.org/packages/matscode/paystack-php-sdk).

---

## License

This library is licensed under the GNU General Public License v3.0 (GPL-3.0). See the [LICENSE](./LICENSE) file for the full license text.
