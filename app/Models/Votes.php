<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    protected $fillable = ['user_id', 'candidate_id'];

    public function candidate()
    {
        return $this->belongsTo(Candidates::class, 'candidate_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}