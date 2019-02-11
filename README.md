# Pixan CFDI

CFDI is a package that provides electronic invoicing capabilities through different PAC providers in Mexico for Laravel applications.

## Installation

To install this package using composer:

```bash
composer require pixan/cfdi
```

## Configuration

Add the service provider to the `providers` array in app.php:

```php
Pixan\Cfdi\CfdiServiceProvider::class,
```

Publish the configuration file, make sure you select *Pixan\Cfdi\CfdiServiceProvider* from the provided menu:
```bash
php artisan vendor:publish
```

Set the configuration parameters in the newly created configuration file:
```bash
config/cfdi.php
```


## Usage

### Generate an XML seal
To generate the seal of a previously formed XML file, create an array containing a valid CFDi certificate and its key file in PEM format. Calling the `seal` method on the *cfdi* instance will return a valid seal string for the provided XML document:
```php
$config = [
    'certificate' => $certificateFileContents,
    'pem' => $pemFileContents
];
$cfdi = new Cfdi($config);
$seal = $cfdi->seal($xml);
```

### Stamp an XML

Calling the `stamp` method on the _cfdi_ instance will return a valid xml that has been stamped by the requested PAC service and configured environment. *Make sure that the proper configuration was provided when constructing the *cfdi* instance.
```php
$config = [
    'certificate' => $certificateFileContents,
    'pem' => $pemFileContents
];
$cfdi = new Cfdi($config);
$seal = $cfdi->stamp($xml);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
