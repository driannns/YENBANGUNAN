<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image_path',
        'published_at',
        'author_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Author relationship.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Clean and normalize content before saving or when retrieving.
     */
    protected function cleanContent(?string $value): ?string
    {
        if (is_null($value)) {
            return $value;
        }

        // remove HTML comments (including WP blocks)
        $s = preg_replace('/<!--.*?-->/s', '', $value);

        // remove literal backslash-n sequences
        $s = str_replace('\\n', ' ', $s);

        // replace actual newlines and tabs with a single space
        $s = str_replace(["\r\n", "\r", "\n", "\t"], ' ', $s);

        // collapse multiple whitespace into single space and trim
        $s = preg_replace('/\s+/', ' ', $s);
        $s = trim($s);

        return $s;
    }

    /**
     * Accessor: return cleaned content.
     */
    public function getContentAttribute($value): ?string
    {
        return $this->cleanContent($value);
    }

    /**
     * Mutator: clean before saving (optional).
     */
    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = $this->cleanContent($value);
    }
}
