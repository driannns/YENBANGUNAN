<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'description',
        'image_path',
        'detail_image_path',
        'category',
        'type',
        'status',
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
     * Konten dengan status 'active' — dipakai di semua halaman publik supaya
     * yang diarsipkan lewat admin tidak lagi tampil di list maupun detail.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * URL publik record ini. Konten lama hasil import WordPress punya slug
     * berisi path bertanggal penuh (mis. "2026/05/15/nama-produk") — itu
     * SUDAH jadi URL-nya sendiri (lewat route blog.show), bukan digabung
     * dengan prefix /{category}/ punya rute produk baru. Cuma produk/artikel
     * yang dibuat lewat admin (slug polos tanpa "/") yang pakai URL pendek.
     */
    public function publicUrl(): string
    {
        $isLegacyUrl = str_contains($this->slug, '/');

        if ($this->type === 'product') {
            return $isLegacyUrl
                ? url('/' . $this->slug)
                : route('content.product.show', ['category' => $this->category, 'slug' => $this->slug]);
        }

        if (!$isLegacyUrl) {
            return route('content.blog.show', ['slug' => $this->slug]);
        }

        $parts = explode('/', $this->slug, 4);
        if (!empty($parts[0]) && preg_match('/^\d{4}$/', $parts[0])) {
            return route('blog.show', [
                'year' => $parts[0],
                'month' => $parts[1] ?? '01',
                'day' => $parts[2] ?? '01',
                'slug' => $parts[3] ?? $this->slug,
            ]);
        }

        return url('/' . $this->slug);
    }

    /**
     * Gambar utama di halaman detail. `detail_image_path` opsional — kalau
     * admin tidak mengisinya, fallback ke thumbnail (`image_path`) supaya
     * halaman detail tidak pernah tampil tanpa gambar sama sekali.
     */
    public function detailImagePath(): ?string
    {
        return $this->detail_image_path ?: $this->image_path;
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
