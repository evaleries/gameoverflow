<?php

namespace App\Models;

interface CrudContracts
{
    public static function all();

    public static function create();

    public function update();

    public function delete();
}
