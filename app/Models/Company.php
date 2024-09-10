<?php

namespace App\Models;

use App\Models\User;
use App\Models\Typology;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'domain',
        'typology',
        'admin_id'
    ];


    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_id');
    }

    public function type()
    {
        return $this->hasOne(Typology::class, 'id', 'typology');
    }
}
