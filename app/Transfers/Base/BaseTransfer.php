<?php

namespace App\Transfers\Base;

use App\Transfers\Base\Interfaces\ITransfer;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseTransfer implements ITransfer
{
    /**
     * 新しいインスタンスを返す
     */
    public static function create() :static
    {
        return app()->make(static::class);
    }
}