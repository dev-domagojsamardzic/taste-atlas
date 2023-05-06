<?php

namespace App\Repositories;

use App\Interfaces\ModelRepositoryInterface;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;

abstract class ModelRepository implements ModelRepositoryInterface {

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        // App instance
        $this->app = $app;
        // Model instance
        $this->getModel();
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    abstract protected function setModelName();

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function getModel(): Model
    {
        $model = $this->app->make($this->setModelName());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->setModelName()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }
}
