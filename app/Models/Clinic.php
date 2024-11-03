<?php

namespace App\Models;

use App\Models\Scopes\ClinicIdScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ScopedBy(ClinicIdScope::class)]
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
