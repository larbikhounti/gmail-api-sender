<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    use HasFactory;
   public  $fillable = ['email','token','alias'];
}
