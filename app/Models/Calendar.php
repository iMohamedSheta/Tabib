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
 * @property int|null                        $patient_id
 * @property int|null                        $clinic_service_id
 * @property int                             $type
 * @property string                          $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property ClinicService|null              $clinicServices
 * @property object|null                     $decoded_data
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereClinicServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Calendar whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Calendar extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clinicServices()
    {
        return $this->belongsTo(ClinicService::class, 'clinic_service_id', 'id');
    }

    // In CalendarModel.php
    public function getDecodedDataAttribute(): ?object
    {
        $decoded = json_decode($this->data, false);

        // Ensure the decoded data is an object
        return is_object($decoded) ? $decoded : null;
    }
}
