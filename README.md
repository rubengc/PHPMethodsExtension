# PHP Methods Extension

in development

# Symfony Installation

composer.json:

```sh
[...]
    "require" : {
        [...]
        "rubengc/PHPMethodsExtension" : "dev-master"
    },
    "repositories" : [{
        "type" : "vcs",
    }],
[...]
```

Then execute this in your terminal:

```sh
php composer.phar update rubengc/PHPMethodsExtension
```

And add this line into your app/autoload.php file:

```php
require_once __DIR__."/../vendor/rubengc/PHPMethodsExtension/PHPMethodsExtension.php";
```

