# Eloquent ULID-able

[![Latest Stable Version](https://poser.pugx.org/kduma/eloquent-ulidable/v/stable.svg)](https://packagist.org/packages/kduma/eloquent-ulidable)
[![Total Downloads](https://poser.pugx.org/kduma/eloquent-ulidable/downloads.svg)](https://packagist.org/packages/kduma/eloquent-ulidable)
[![License](https://poser.pugx.org/kduma/eloquent-ulidable/license.svg)](https://packagist.org/packages/kduma/eloquent-ulidable)

Eases using and generating ULIDs in Laravel Eloquent models as an additional column alongside the numeric `id`.

Check full documentation here: [opensource.duma.sh/libraries/php/eloquent-ulidable](https://opensource.duma.sh/libraries/php/eloquent-ulidable)

## Requirements

- PHP `^8.3`
- Laravel `^13.0`

## Installation

```bash
composer require kduma/eloquent-ulidable
```

## Setup

Add the `Ulidable` trait to your model:

```php
use KDuma\Eloquent\Ulidable;

class Post extends Model
{
    use Ulidable;
}
```

In your migration, create a `ulid` column:

```php
$table->ulid()->unique();
```

## Configuration

### New style — PHP Attribute (recommended)

```php
use KDuma\Eloquent\Ulidable;
use KDuma\Eloquent\Attributes\HasUlid;

#[HasUlid(field: 'public_id', checkDuplicates: true)]
class Post extends Model
{
    use Ulidable;
}
```

Available `HasUlid` parameters:
- `field` — column name to store the ULID (default: `'ulid'`)
- `checkDuplicates` — query DB to ensure uniqueness before saving (default: `false`)

### Old style — model properties (deprecated, triggers `E_USER_DEPRECATED`)

```php
class Post extends Model
{
    use Ulidable;

    protected string $ulid_field = 'public_id';         // ⚠️ deprecated
    protected bool $check_for_ulid_duplicates = true;    // ⚠️ deprecated
}
```

## Usage

- ULID is automatically generated on `create` and `update` if the field is `null`
- `$model->regenerateUlid()` — manually regenerate (save afterwards)
- `Model::whereUlid($ulid)` — query scope to find by ULID
- `Model::byUlid($ulid)` — shorthand to retrieve a model by ULID
- `$model->getUlidField()` — returns the configured ULID field name

> **Note:** This package adds ULID as an *additional column* alongside the numeric auto-increment `id`. This is different from Laravel's built-in `HasUlids` trait which replaces the primary key.

## Packagist

[kduma/eloquent-ulidable](https://packagist.org/packages/kduma/eloquent-ulidable)
