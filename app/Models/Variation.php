<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    public function options()
    {
        return $this->hasMany(VariationOption::class);
    }
}
