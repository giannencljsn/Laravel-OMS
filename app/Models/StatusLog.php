<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    use HasFactory;

    protected $table = 'status_logs';

    protected $fillable = [
        'order_id',
        'imei',
        'new_status',
        'changed_at',
        'processed',
    ];

    protected $casts = [
        'processed' => 'boolean',
        'changed_at' => 'datetime',
    ];
}
