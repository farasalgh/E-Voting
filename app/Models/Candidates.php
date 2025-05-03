<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    protected $fillable = ['name', 'photo', 'vision', 'mission', 'slogan'];

    public function votes()
    {
        return $this->hasMany(Votes::class, 'candidate_id');
    }
}