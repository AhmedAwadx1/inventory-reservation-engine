<?php

namespace App\Enums\Concerns;

use Illuminate\Support\Str;

/**
 * Trait to add translatable labels to any backed enum.
 *
 * Uses Laravel's JSON localization files (lang/ar.json, lang/en.json).
 * Translation keys follow the pattern: enums.{enum_snake_name}.{case_lower_name}
 *
 * Example:
 *   OrderStatus::PENDING->label()        → "في الانتظار" (when locale = ar)
 *   OrderStatus::PENDING->labelIn('en')  → "Pending"
 *   OrderStatus::options()               → [1 => "في الانتظار", 2 => "مأكد", ...]
 */
trait HasTranslatableLabel
{
    /**
     * Get label in the current application locale.
     */
    public function label(): string
    {
        return __($this->translationKey());
    }

    /**
     * Get label in a specific locale.
     */
    public function labelIn(string $locale): string
    {
        return __($this->translationKey(), [], $locale);
    }

    /**
     * Build the translation key.
     *
     * OrderStatus::PENDING → "enums.order_status.pending"
     * ReservationStatus::ACTIVE → "enums.reservation_status.active"
     */
    public function translationKey(): string
    {
        $enumName = Str::snake(class_basename(static::class));
        $caseName = Str::lower($this->name);

        return "enums.{$enumName}.{$caseName}";
    }

    /**
     * Get all cases as value => label pairs (useful for dropdowns).
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        $options = [];
        foreach (static::cases() as $case) {
            $options[$case->value] = $case->label();
        }
        return $options;
    }

    /**
     * Get all cases as array of objects (useful for API responses).
     *
     * @return array<int, array{value: int, name: string, label: string}>
     */
    public static function toArray(): array
    {
        return array_map(fn ($case) => [
            'value' => $case->value,
            'name'  => $case->name,
            'label' => $case->label(),
        ], static::cases());
    }
}
