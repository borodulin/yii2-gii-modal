# Modal CRUD Gii templates for Yii2 framework

[![Latest Version](https://img.shields.io/packagist/v/conquer/gii-modal.svg)](https://packagist.org/packages/conquer/gii-modal)
[![Total Downloads](https://img.shields.io/packagist/dt/conquer/gii-modal.svg)](https://packagist.org/packages/conquer/gii-modal)
[![License](https://img.shields.io/packagist/l/conquer/gii-modal.svg)](LICENSE)

## Description

This generator generates, controller and views that allow you to edit and view the data in the modal windows.
Uses the Bootstrap Modals. 

## Requirements

- PHP 7.4 or 8.x
- Yii 2.0

## Installation

Install the extension via [Composer](https://getcomposer.org):

```bash
composer require conquer/gii-modal:^1.2
```

## Usage

Add to config file:

```php
if (YII_ENV_DEV) {

    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',      
        'allowedIPs' => ['127.0.0.1', '::1'],  
        'generators' => [
            'modal_crud' => [ // generator name
                'class' => 'conquer\gii\templates\crud\Generator', // generator class
            ]
        ],
    ]; 
}
```

## License

**conquer/gii-modal** is released under the MIT License. See the bundled [`LICENSE`](LICENSE) for details.
