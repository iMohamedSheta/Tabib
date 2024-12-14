<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
class ClinicService extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function list()
    {
        return ClinicService::pluck('name', 'id')->toArray();
    }
}
