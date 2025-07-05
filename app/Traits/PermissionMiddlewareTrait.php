<?php

namespace App\Traits;

trait PermissionMiddlewareTrait
{
    public function applyPermissionMiddleware(string $resource)
    {
        $this->middleware("permission:{$resource}_access")->only(['index']);
        $this->middleware("permission:{$resource}_create")->only(['create', 'store']);
        $this->middleware("permission:{$resource}_show")->only(['show']);
        $this->middleware("permission:{$resource}_edit")->only(['edit', 'update']);
        $this->middleware("permission:{$resource}_delete")->only(['destroy']);
    }
}
