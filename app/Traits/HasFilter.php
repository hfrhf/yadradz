<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Filter;

trait HasFilter
{
    public function scopeFilter(Builder $query, Filter $filters): Builder
    {
        return $filters->apply($query);
    }
}
