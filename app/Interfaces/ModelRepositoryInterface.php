<?php

namespace App\Interfaces;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface ModelRepositoryInterface
{
    /**
     * Returns an instance of the query builder for the specified model
    */
    public function baseModelQuery(): Builder;
    
    /**
     * Make Model instance
    */
    public function getModel(): Model;
}