<?php

namespace KDuma\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class Ulidable.
 */
trait Ulidable
{
    /**
     * Boot the trait.
     */
    protected static function bootUlidable()
    {
        static::creating(function (Model $model) {
            $model->generateUlidOnCreateOrUpdate();
        });

        static::updating(function (Model $model) {
            $model->generateUlidOnCreateOrUpdate();
        });
    }

    /**
     * Gets first model by ulid
     */
    public static function byUlid(string $ulid): self
    {
        return static::whereUlid($ulid)->first();
    }

    /**
     * @throws \Exception
     */
    public function regenerateUlid()
    {
        $this->{$this->getUlidField()} = $this->ulidGenerate();
    }

    /**
     * Get the ULID field name associated with the model.
     *
     * @return string
     */
    public function getUlidField()
    {
        if (!isset($this->ulid_field))
            return 'ulid';

        return $this->ulid_field;
    }

    /**
     * @param $query
     * @param $ulid
     * @return mixed
     */
    public function scopeWhereUlid($query, $ulid)
    {
        return $query->where($this->getTable().'.'.$this->getUlidField(), $ulid);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function ulidGenerate()
    {
        $ulid = strtolower((string) Str::ulid());

        if (!isset($this->check_for_ulid_duplicates) || !$this->check_for_ulid_duplicates)
            return $ulid;

        $rowCount = DB::table($this->getTable())->where($this->getUlidField(), $ulid)->count();

        return $rowCount > 0 ? $this->ulidGenerate() : $ulid;
    }

    /**
     * @throws \Exception
     */
    protected function generateUlidOnCreateOrUpdate()
    {
        if($this->{$this->getUlidField()} == null)
            $this->regenerateUlid();
    }
}
