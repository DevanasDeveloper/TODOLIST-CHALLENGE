<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
        'completed_at'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
