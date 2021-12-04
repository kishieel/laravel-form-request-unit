# Laravel Form Request Unit

[![Integration](https://github.com/kishieel/laravel-form-request-unit/actions/workflows/integration.yml/badge.svg)](https://github.com/kishieel/laravel-form-request-unit/actions/workflows/integration.yml)

Helpers for laravel form request unit testing. It allows you to keep your controller tests clean and focus on testing 
their proper purpose by taking form request assertions to separate tests.

## Installation

You can install the package via composer:

```bash
composer require --dev kishieel/laravel-form-request-unit
```

## Usage

### Rules Validation

With `FormRequestValidator` trait you may test your `FormRequest` without direct request to controller. Mentioned trait 
provide `validate` method which takes `FormRequest` and data which should be validated as arguments. 

```php
use Kishieel\RequestUnit\FormRequestValidator;

public function some_example_test()
{
    $formRequest = new YourFormRequest();
    $data = [
        'property_1' => 12, 
        'property_2' => 'string'
    ];

    $result = $this->validate($formRequest, $data);
    // ..
}
```

As a result you will get `ValidatorResponse` which provide `passes` and `errors` methods. First method allow you to 
determinate whether data passes validation against form request rules. Second method may be used when you expected 
validation fail and want to determinate whether data failed against expected rule.   

```php
use Kishieel\RequestUnit\FormRequestValidator;

public function some_example_test()
{
    // ..
    
    $this->assertFalse($result->passes());
    $this->assertArrayHasKey('property_3', $result->errors());
}
```

### Selective Validation

With a very complex `FormRequest`, you may want to test data against only specified rules. You may achieve this by 
passing array of rule keys as third parameter of `validate` method.

```php
use Kishieel\RequestUnit\FormRequestValidator;

public function some_example_test()
{
    // ..
    $result = $this->validate($formRequest, $data, ['property_1']);
    
    // will keep errors only for `property_1`
    $result->errors(); 
}
```

### Authorization Validation

With `FormRequestValidator` you may validate `FormRequest` authorization method. Result will be available via
`passes` method on validation result.

### Testing Custom Validation Rules

In case of custom validation rules you may use `FormRequestCreator` to create `FormRequest` on runtime and test it 
against your data. `FormRequestCreator` takes rules array and authorization callback as constructor arguments. Arguments
are optional. You may use `setRules` and `setAuthorization` methods if you prefer.

```php
Validator::extend('mac_address', function ($attribute, $value) {
    return preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', strval($value));
});
```
```php
use Kishieel\RequestUnit\FormRequestValidator;

public function some_example_test()
{
    $formRequest = new \Kishieel\RequestUnit\FormRequestCreator([
        'mac_address' => 'required|mac_address'    
    ]);
    
    $result = $this->validate($formRequest, ['mac_address' => 'invalid_mac_address']);
    
    $this->assertFalse($result->passes());
    $this->assertArrayHasKey('mac_address', $result->errors());
}
```

## Contributing

Before any pull request to `master` branch please run cs fixer and unit test.  

```bash
composer fix 
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
