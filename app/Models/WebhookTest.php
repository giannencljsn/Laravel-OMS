<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookTest extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow the default naming convention
    protected $table = 'webhook_test';

    // Specify the fields that can be mass-assigned
    protected $fillable = ['first_name', 'last_name', 'email'];
}

