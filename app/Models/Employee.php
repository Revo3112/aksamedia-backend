<?php
// app/Models/Employee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'image',
        'name',
        'phone',
        'division_id',
        'position',
    ];

    protected $appends = [
        'image_url',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::url($this->image);
    }

    public function scopeByName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }

        return $query;
    }

    public function scopeByDivision($query, $divisionId)
    {
        if ($divisionId) {
            return $query->where('division_id', $divisionId);
        }

        return $query;
    }
}
