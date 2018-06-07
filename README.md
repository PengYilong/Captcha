A simple php captcha class

## Installation

Use [composer](http://getcomposer.org) to install nezumi/captcha in your project:
```
composer require nezumi/captcha
```


## Usage
```php
use Nezumi\captcha;

$captcha = new Captcha;
$captcha->build();
$_SESSION['captcha'] = $captcha->get_code();
```