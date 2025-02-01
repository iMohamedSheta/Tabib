<?php

namespace App\Models;

use App\Contracts\UserRoleModelInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model implements UserRoleModelInterface
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        self::deleting(function ($manager): void {
            $manager->user->delete();
        });
    }
}
