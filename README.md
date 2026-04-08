# Eloquent ULID-able

Eloquent trait that adds a ULID as an additional column alongside the numeric `id` in Laravel models.

Full documentation: [opensource.duma.sh/libraries/php/eloquent-ulidable](https://opensource.duma.sh/libraries/php/eloquent-ulidable)

## Requirements

- PHP `^8.3`
- Laravel `^13.0`

## Installation

```bash
composer require kduma/eloquent-ulidable
```

## Usage

```php
use KDuma\Eloquent\Ulidable;
use KDuma\Eloquent\Attributes\HasUlid;

#[HasUlid(field: 'ulid')]
class Post extends Model
{
    use Ulidable;
}
```

Add a `ulid` column to your migration:

```php
$table->ulid()->unique();
```

ULID is auto-generated on create. Find by ULID with `Post::whereUlid($ulid)` or `Post::byUlid($ulid)`.

> Unlike Laravel's built-in `HasUlids`, this package keeps the numeric `id` as the primary key and stores the ULID in a separate column.
