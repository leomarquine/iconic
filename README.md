# Iconic
SVG icons in PHP

## Installation
You can install this package via Composer by running this command in your terminal in the root of your project:
```
composer require marquine/iconic
```

## Setup
### The configuration array
```php
$config = [
    // Path to svg icons
    'path' => '/path/to/icons',

    // Default options applied to icons
    'defaults' => [
        'color'  => 'currentColor',
        'height' => '1em',
        'width'  => '1em',
        'class'  => 'icon'
    ],

    // Custom states of the icons
    'states' => [
        //
    ],
];
```
### Gerenal setup
New up an instance of `Marquine\Iconic\Icon` with the required parameters as the icon helper instance:
```php
use Marquine\Iconic\Icon;
use Marquine\Iconic\Repository;

$config = [
    // Configuration array
]

icon(new Icon(new Repository, $config));
```

### Laravel setup
Add the IconicServiceProvider to the providers array in the config/app.php file:
```php
'providers' => [
    //...
    Marquine\Iconic\IconicServiceProvider::class
],
```

Publish the package configuration:
```
php artisan vendor:publish --tag iconic
```

## Usage
### Basic rendering
Rendering the icon `/path/to/icons/menu.svg`:
```php
echo icon('menu');
```

You can use dot notation to render icons in sub-directories `/path/to/icons/category/menu.svg`:
```php
echo icon('category.menu');
```

### Size
Set the icon height:
```php
echo icon('menu')->height(16);
```

Set the icon width:
```php
echo icon('menu')->width(16);
```

Set the icon height and width to the same value:
```php
echo icon('menu')->size(16);
```

### Color
Set the color of the icon (fill attribute):
```php
echo icon('menu')->color('#416e61');
```

### Class
Set the icon class (appends to existing classes):
```php
echo icon('menu')->class('success');
```

To override existing classes, set the override parameter of the class method to `true`:
```php
echo icon('menu')->class('success', true);
```

### Style
Set the icon style:
```php
echo icon('menu')->style('z-index', 10);
```

Use an array to set multiple properties:
```php
echo icon('menu')->style(['margin' => '10px', 'z-index' => 10]);
```

### Id
Set the id of the icon:
```php
echo icon('menu')->id('icon_id');
```

### States
States are defined in the configuration array as css classes or callbacks:
```php
'states' => [
    'warning' => 'warning',
    'success' => function ($icon) {
        $icon->color('#4d6968')->class('icon')->size(23);
    }
],
```
To apply states, call the name of the state as a method:
```php
echo icon('menu')->warning();
echo icon('menu')->success();
```
Applying multiple states:
```php
echo icon('menu')->stateOne()->stateTwo();
```
Conditionally adding states. If a parameter is passed to the state, it will only be applied if the parameter is truthy (in the example below, only the inactive state will be applied):
```php
$active = false;

echo icon('menu')->active($active)->inactive(! $active);
```

### Chaining methods
Of course, you can chain any of the methods above:
```php
echo icon('menu')->color('#414d4e')->size('23')->class('icon');
```

## License
Iconic is licensed under the [MIT license](http://opensource.org/licenses/MIT).
