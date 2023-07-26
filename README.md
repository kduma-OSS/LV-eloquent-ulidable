# L5-eloquent-ulidable
[![Latest Stable Version](https://poser.pugx.org/kduma/eloquent-ulidable/v/stable.svg)](https://packagist.org/packages/kduma/eloquent-ulidable) 
[![Total Downloads](https://poser.pugx.org/kduma/eloquent-ulidable/downloads.svg)](https://packagist.org/packages/kduma/eloquent-ulidable) 
[![Latest Unstable Version](https://poser.pugx.org/kduma/eloquent-ulidable/v/unstable.svg)](https://packagist.org/packages/kduma/eloquent-ulidable) 
[![License](https://poser.pugx.org/kduma/eloquent-ulidable/license.svg)](https://packagist.org/packages/kduma/eloquent-ulidable)

Eases using and generating ulid's in Laravel Eloquent models.

# Setup
Install it using composer

    composer require kduma/eloquent-ulidable

# Prepare models
Inside your model (not on top of file) add following lines:
    
    use \KDuma\Eloquent\Ulidable;

In database create `ulid` string field. If you use migrations, you can use following snippet:

    $table->ulid()->unique();

# Usage
By default, it generates slug on first save.

- `$model->regenerateUlid()` - Generate new ulid. (Remember to save it by yourself)
- `Model::whereUlid($ulid)->first()` - Find by ulid. (`whereUlid` is query scope)

# Packagist
View this package on Packagist.org: [kduma/eloquent-ulidable](https://packagist.org/packages/kduma/eloquent-ulidable)
