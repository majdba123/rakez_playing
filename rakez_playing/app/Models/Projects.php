<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value_discount',
        'type_discount',
    ];

    protected $casts = [
        'value_discount' => 'decimal:2',
    ];

    // Constants for project types
    const TYPE_APARTMENT = 'apartment';
    const TYPE_FLOOR = 'floor';
    const TYPE_UNIT = 'unit';

    // Constants for discount types
    const DISCOUNT_PERCENTAGE = 'percentage';
    const DISCOUNT_FIXED = 'fixed';

    // Get all available types
    public static function getTypes()
    {
        return [
            self::TYPE_APARTMENT => 'Apartment',
            self::TYPE_FLOOR => 'Floor',
            self::TYPE_UNIT => 'Unit',
        ];
    }

    // Get all available discount types
    public static function getDiscountTypes()
    {
        return [
            self::DISCOUNT_PERCENTAGE => 'Percentage (%)',
            self::DISCOUNT_FIXED => 'Fixed Amount',
        ];
    }

    // Accessor for formatted type
    public function getFormattedTypeAttribute()
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }

    // Accessor for formatted discount type
    public function getFormattedDiscountTypeAttribute()
    {
        return self::getDiscountTypes()[$this->type_discount] ?? $this->type_discount;
    }

    // Format value discount based on type
    public function getFormattedValueDiscountAttribute()
    {
        if (!$this->value_discount) return 'N/A';
        
        if ($this->type_discount === self::DISCOUNT_PERCENTAGE) {
            return $this->value_discount . '%';
        }
        
        return number_format($this->value_discount, 2);
    }

    public function selectedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_projects')
                    ->withTimestamps()
                    ->withPivot('selected_at');
    }
}