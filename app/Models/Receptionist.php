<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ScopedBy(OrganizationScope::class)]
/**
 * 
 *
 * @property int $id
 * @property int|null $organization_id
 * @property string|null $phone
 * @property string|null $other_phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist whereOtherPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Receptionist whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Receptionist extends Model
{
    use HasFactory;

    protected $guarded = [];
}
