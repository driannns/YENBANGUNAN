<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Ambil semua setting sebagai [key => value], dipakai controller supaya
     * tidak query per-field satu-satu.
     */
    public static function allValues(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Gabungkan default dari config/page_content_defaults.php dengan override
     * yang tersimpan di DB (key disimpan flat, mis. "product.category.cat.label").
     */
    public static function resolvePage(string $page): array
    {
        $result = config("page_content_defaults.{$page}", []);
        $overrides = static::allValues();

        foreach ($result as $field => $value) {
            if ($field === 'categories') {
                foreach ($value as $slug => $category) {
                    foreach ($category as $sub => $default) {
                        $key = "{$page}.category.{$slug}.{$sub}";
                        if (!empty($overrides[$key])) {
                            $result['categories'][$slug][$sub] = $overrides[$key];
                        }
                    }
                }
                continue;
            }

            $key = "{$page}.{$field}";
            if (!empty($overrides[$key])) {
                $result[$field] = $overrides[$key];
            }
        }

        return $result;
    }
}
