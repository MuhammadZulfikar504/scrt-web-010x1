<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table    = 'transactions';
    protected $fillable = ['employee_id', 'user_id', 'start_date', 'end_date'];
}
