<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBackup extends Model
{
    use HasFactory;

    protected $fillable = [
        'reff',
        'name',
        'code',
        'amount',
        'status',
        'expired_at',
    ];
}
