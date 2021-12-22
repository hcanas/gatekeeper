<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'short_name',
        'office_id',
    ];

    public function rolePermissions()
    {
        return $this->belongsToMany(PermissionRole::class, 'office_permission_role');
    }

    public function parentOffice()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function childOffice()
    {
        return $this->hasMany(Office::class);
    }
}
