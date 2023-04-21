<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter {

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Initialize a new filter instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
    */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setProperties();
    }

    protected abstract function setProperties():void;

    /**
     *  Apply the filters on the builder
     *  -----------------------------------------------
     *  @param  \Illuminate\Database\Eloquent\Builder  $builder
     *  @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        // Execute every function whose name exist as query string param
        // Meaning: function names and query string params must match names!
        foreach ($this->request->all() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }
}
