<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                             $id
 * @property int|null                        $organization_id
 * @property string                          $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property User|null                       $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Manager whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Manager extends Model implements UserRoleModelInterface
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
