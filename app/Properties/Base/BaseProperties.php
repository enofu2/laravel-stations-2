<?php

namespace App\Properties\Base;

use App\Properties\Base\Interfaces\IProperties;

abstract class BaseProperties implements IProperties
{
    /**
     * 新しいインスタンスを返す
     */
    public static function create() :static
    {
        return app()->make(static::class);
    }
}