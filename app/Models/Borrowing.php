<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'attendance_id', // For manual walk-ins
        'equipment_id',
        'quantity',
        'status',        // pending, active, returned, rejected
        'borrowed_at',
        'returned_at'
    ];

    // Ensure dates are treated as Carbon objects (so you can format them)
    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Relationship: Who borrowed it?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: What did they borrow?
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Relationship: Was it a manual walk-in?
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}