<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    // Allow these fields to be filled
    protected $fillable = ['name', 'slug'];

    // RELATIONSHIP: A Lab has many Equipment items
    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}