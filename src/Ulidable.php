<?php

declare(strict_types=1);

namespace KDuma\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use KDuma\Eloquent\Attributes\HasUlid;

trait Ulidable
{
    protected static function bootUlidable(): void
    {
        static::creating(function (Model $model): void {
            $model->generateUlidOnCreateOrUpdate();
        });

        static::updating(function (Model $model): void {
            $model->generateUlidOnCreateOrUpdate();
        });
    }

    public static function byUlid(string $ulid): ?static
    {
        return static::whereUlid($ulid)->first();
    }

    public function regenerateUlid(): void
    {
        $this->{$this->getUlidField()} = $this->ulidGenerate();
    }

    public function getUlidField(): string
    {
        return $this->resolveUlidableConfig('field', 'ulid_field', 'ulid');
    }

    public function scopeWhereUlid(Builder $query, string $ulid): Builder
    {
        return $query->where($this->getTable() . '.' . $this->getUlidField(), $ulid);
    }

    protected function ulidGenerate(): string
    {
        $ulid = strtolower((string) Str::ulid());

        $checkDuplicates = $this->resolveUlidableConfig('checkDuplicates', 'check_for_ulid_duplicates', false);
        if (!$checkDuplicates) {
            return $ulid;
        }

        $rowCount = DB::table($this->getTable())
            ->where($this->getUlidField(), $ulid)
            ->count();

        return $rowCount > 0 ? $this->ulidGenerate() : $ulid;
    }

    protected function generateUlidOnCreateOrUpdate(): void
    {
        if ($this->{$this->getUlidField()} === null) {
            $this->regenerateUlid();
        }
    }

    private function resolveUlidableConfig(string $attrProperty, string $legacyProperty, mixed $default): mixed
    {
        $value = static::resolveClassAttribute(HasUlid::class, $attrProperty);
        if ($value !== null) {
            return $value;
        }

        if (property_exists($this, $legacyProperty)) {
            trigger_error(
                "Using \${$legacyProperty} on " . static::class . ' is deprecated. Use #[HasUlid] attribute instead.',
                E_USER_DEPRECATED,
            );

            return $this->{$legacyProperty} ?? $default;
        }

        return $default;
    }
}
