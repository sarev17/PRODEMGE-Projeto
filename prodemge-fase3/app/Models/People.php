<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class People extends Model
{
    use HasFactory;
    protected $table = 'peoples';
    protected $fillable = [
        'user_id',
        'document',
        'father_name',
        'mother_name',
    ];

    /**
     * relationships
     */
    /**
     * Get the user associated with the People
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    /**
     * Get all of the address for the People
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address(): HasMany
    {
        return $this->hasMany(Adress::class, 'people_id', 'id');
    }
}
