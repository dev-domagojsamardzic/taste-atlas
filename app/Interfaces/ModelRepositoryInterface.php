<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface ModelRepositoryInterface
{

    public function getModel(): Model;
}