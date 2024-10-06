<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendJobs extends Model
{
    use HasFactory;
    protected $fillable = [
        'data_list_id',
        'total_recipients',
        'progress',
        'status',
    ];
    public function data_list() {
        return $this->belongsTo(EmailList::class);
    }
}
