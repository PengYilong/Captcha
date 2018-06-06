A simple php captcha class

## Installation

Use [composer](http://getcomposer.org) to install yilongpeng/captcha in your project:
```
composer require yilongpeng/captcha
```


## Usage
```php
use yilongpeng\captcha;

$captcha = new Captcha;
$captcha->build();
$_SESSION['captcha'] = $captcha->get_code();
```