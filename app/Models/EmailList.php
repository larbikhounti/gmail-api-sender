<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory;
    protected $table = 'email_lists';

    protected $fillable = [
        'name',
    ];
    // add with
    public function emails()
    {
        return $this->hasMany(EmailData::class);
    }
    public function send_jobs()
    {
        return $this->hasMany(SendJobs::class);
    }
}
