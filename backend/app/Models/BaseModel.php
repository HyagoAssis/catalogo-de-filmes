<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getId()
    {
        return $this->id;
    }

    public static function table($alias = null): string
    {
        return static::getModel()->getTable() . (is_null($alias) ? '' : ' as ' . $alias);
    }

    public static function column($column, $alias = null): string
    {
        return (is_null($alias) ? static::table() : $alias) . '.' . $column;
    }
}
