# Captcha

## Installation

Use [composer](http://getcomposer.org) to install nezumi/captcha in your project:
```
composer require nezimi/captcha
```


## Usage
```php
use Nezimi\captcha;

$captcha = new Captcha;
$captcha->build();
$_SESSION['captcha'] = $captcha->get_code();
```