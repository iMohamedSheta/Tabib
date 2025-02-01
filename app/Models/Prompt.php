<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Prompt extends Model
{
	use HasFactory;

	protected $guarded = [];

	public function messages()
	{
		return $this->morphMany(Message::class, 'model');
	}

	protected static function booted()
	{
		self::creating(function ($prompt): void {
			$prompt->organization_id = Auth::user()->organization_id;
		});
	}
}
