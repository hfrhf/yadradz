<?php

namespace App\Filters;

class CustomerOrderFilter extends Filter
{
    protected array $filters = ['search', 'status','state'];
    protected array $verified_methods = ['search', 'status','state'];

    public function search()
    {
        $data = $this->validateInput([
            'search' => 'required|string'
        ]);
        if (!$data) return $this->query;

        $this->query->where(function ($query) use ($data) {
            $query->where('fullname', 'like', "%{$data['search']}%")
                  ->orWhere('phone', 'like', "%{$data['search']}%")
                  ->orWhereHas('product', function ($q) use ($data) {
                      $q->where('name', 'like', "%{$data['search']}%");
                  });
        });

    }

    public function status()
    {
        $data = $this->validateInput([
            'status' => 'required|string'
        ]);
        if (!$data) return $this->query;

        $this->query->where('status', $data['status']);
    }
    public function state(){
        $data = $this->validateInput([
            'state' => 'required|string'
        ]);
        if (!$data) return $this->query;

        $this->query->where('state_id', $data['state']);
    }
}
