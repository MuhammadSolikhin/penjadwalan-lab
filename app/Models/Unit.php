<?php

// app/Models/Unit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['nama_unit', 'jenis_unit','kode_unit'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function laboratoriums()
    {
        return $this->hasMany(LaboratoriumUnpam::class);
    }
}
