<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemItem extends Model
{
    protected $fillable = [
        'name',
        'description',
        'points_required',
        'unit',
        'is_active',
        'image_url',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function getIsCurrentlyActiveAttribute(): bool
    {
        $now = now()->startOfDay();
        $start = $this->start_date ? $this->start_date->startOfDay() : null;
        $end = $this->end_date ? $this->end_date->endOfDay() : null;

        $afterStart = !$start || $now->greaterThanOrEqualTo($start);
        $beforeEnd = !$end || $now->lessThanOrEqualTo($end);

        return $afterStart && $beforeEnd;
    }

    public function getStatusLabelAttribute(): string
    {
        $now = now()->startOfDay();
        $start = $this->start_date ? $this->start_date->startOfDay() : null;
        $end = $this->end_date ? $this->end_date->endOfDay() : null;

        // Coming Soon: sudah diaktifkan, tapi belum masuk periode mulai
        if ($this->is_active && $start && $now->lt($start)) {
            return 'Coming Soon';
        }

        // Expired: periode sudah berakhir
        if ($this->is_active && $end && $now->gt($end)) {
            return 'Expired';
        }

        // Jika tidak memakai periode tanggal, status ikut flag aktif/non-aktif
        if (!$this->is_active) {
            return 'Expired';
        }

        // Dalam periode dan aktif
        return 'Active';
    }
}
