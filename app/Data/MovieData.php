<?php

namespace App\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;

class MovieData extends Data
{
    public function __construct(
      #[WithoutValidation]
      public ?int $id,
      #[Rule('unique:movies')]
      public string $title,
      #[Rule(['url'])]
      public string $image_url,
      #[Rule(['gte:1900'])]
      public int $published_year,
      #[Rule(['boolean'])]
      public bool $is_showing,
      #[WithoutValidation]
      public ?int $genre_id,
    ) {}
}
