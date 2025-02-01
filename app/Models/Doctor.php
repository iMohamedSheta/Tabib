<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(OrganizationScope::class)]
class Doctor extends Model implements UserRoleModelInterface
{
	use HasFactory;

	protected $guarded = [];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function clinic(): BelongsTo
	{
		return $this->belongsTo(Clinic::class, 'clinic_id', 'id');
	}

	protected static function booted()
	{
		self::deleting(function ($doctor): void {
			$doctor->user->delete();
		});
	}
}
