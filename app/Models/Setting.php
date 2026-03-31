<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Parse value based on type
        switch ($setting->type) {
            case 'json':
                return json_decode($setting->value, true) ?? $default;
            case 'integer':
                return (int)$setting->value;
            case 'boolean':
                return filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
            default:
                return $setting->value ?? $default;
        }
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        // Convert value based on type
        $valueToStore = $value;
        if ($type === 'json' && is_array($value)) {
            $valueToStore = json_encode($value);
        } elseif ($type === 'boolean') {
            $valueToStore = $value ? '1' : '0';
        } else {
            $valueToStore = (string)$value;
        }

        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $valueToStore,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    /**
     * Check if a setting exists
     */
    public static function has($key)
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Delete a setting
     */
    public static function remove($key)
    {
        return self::where('key', $key)->delete();
    }
}
