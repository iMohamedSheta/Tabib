<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
class Clinic extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function list(): array
    {
        return self::pluck('name', 'id')->toArray();
    }

    public function subClinics()
    {
        return $this->hasMany(self::class, 'parent_clinic_id', 'id');
    }

    public function parentClinic()
    {
        return $this->belongsTo(self::class, 'parent_clinic_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
