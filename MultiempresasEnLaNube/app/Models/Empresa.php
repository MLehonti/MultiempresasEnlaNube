<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BalanceApertura;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'rubro_id', 'user_id'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el rubro
    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

     // Relación con los balances de apertura asociados a la empresa
     public function balances()
     {
         return $this->hasMany(BalanceApertura::class);
     }
}
