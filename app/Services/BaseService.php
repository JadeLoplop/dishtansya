<?php

namespace App\Services;
use DB;
use App;


class BaseService implements ServiceInterface
{
    protected function transaction($closure, $retry = 5)
    {
        // TODO: Implement transaction() method.
        return DB::transaction($closure, $retry);
    }

    public function store(array $attributes)
    {
        // TODO: Implement store() method.
        return $this->transaction(function () use ($attributes){
            return $this->model->create($attributes);
        });

    }

    public function update($id, $attributes)
    {

        // TODO: Implement update() method.
        return $this->transaction(function () use ($id, $attributes){
            $model = $this->model->findOrFail($id);
            $model->fill($attributes);
            $model->save();

            return $model;
        });

    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}
