<?php

namespace App\Services;

interface ServiceInterface
{

    public function store(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);
}
