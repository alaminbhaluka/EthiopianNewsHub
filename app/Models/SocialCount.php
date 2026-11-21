<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialCount extends Model
{
    protected $fillable = ['language', 'icon', 'url', 'fan_count', 'fan_type', 'button_text', 'color', 'status'];
}
