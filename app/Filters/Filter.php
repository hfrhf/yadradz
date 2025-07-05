<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

abstract class Filter
{
    protected Builder $query;
    protected array $filters = [];
    protected array $verified_methods = [];

    public function apply(Builder $query): Builder
    {
        $this->query = $query;

        foreach ($this->filters as $filter) {
            if (
                $this->isFilterReceived($filter) &&
                $this->isFilterVerified($filter) &&
                method_exists($this, $filter)
            ) {
                $this->$filter(); // نفذ الدالة المطابقة للفلتر
            }
        }

        return $query;
    }

    private function isFilterReceived($filter): bool
    {
        return request()->has($filter);
    }

    private function isFilterVerified($filter): bool
    {
        if (!in_array($filter, $this->verified_methods, true)) {
            throw new \RuntimeException("You must verify the '{$filter}' method");
        }
        return true;
    }

    public function validateInput(array $rules)
    {
        $validator = Validator::make(request()->all(), $rules);

        return $validator->fails() ? null : $validator->validated();
    }
}
