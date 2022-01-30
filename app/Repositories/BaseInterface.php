<?php

namespace App\Repositories;

interface BaseInterface
{
    public function all();

    public function getById($id);

    public function paginateData($perPage);

}
