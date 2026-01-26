<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    // Allow all these fields to be saved to the database
    protected $fillable = [
        'laboratory_id',
        'name',
        'description',
        'image_path',
        'size',
        'quantity',
        'available',
        'status',
        'hazard_code',
        'location',
    ];

    // RELATIONSHIP: Equipment belongs to a Laboratory
    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}