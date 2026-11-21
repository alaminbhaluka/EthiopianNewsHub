<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecivedMail extends Model
{
    protected $table = 'recived_mails';

    protected $fillable = ['email', 'subject', 'message', 'seen'];
}
