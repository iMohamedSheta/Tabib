<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
/**
 * @property int                             $id
 * @property int                             $organization_id
 * @property int|null                        $clinic_id
 * @property string                          $name
 * @property string                          $price
 * @property string|null                     $description
 * @property string|null                     $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereClinicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClinicService whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ClinicService extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function list()
    {
        return self::pluck('name', 'id')->toArray();
    }
}
