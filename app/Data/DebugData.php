<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class DebugData extends Data
{
    public function __construct(
      public string $data,
    ) {}
}
