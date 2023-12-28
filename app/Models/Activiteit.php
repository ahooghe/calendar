<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activiteit extends Model
{
    use HasFactory;

    protected $table = 'activiteiten';

    protected $dates = ['start_time', 'end_time'];

    protected $fillable = [
        'name',
        'description',
        'start_time',
        'end_time',
        'location',
        'leeftijdsgroep',
        'hoofdAnimatoren',
        'maxAnimatoren',
        'beschikbarePlaatsen',
        'typeActiviteit',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'inschrijvingen', 'activiteit_id', 'user_id')
                    ->withTimestamps()
                    ->orderBy('pivot_created_at');
    }
}
