<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subClinics()
    {
        return $this->hasMany(Clinic::class, 'parent_clinic_id', 'id');
    }

    public function parentClinic()
    {
        return $this->belongsTo(Clinic::class, 'parent_clinic_id', 'id');
    }
}
