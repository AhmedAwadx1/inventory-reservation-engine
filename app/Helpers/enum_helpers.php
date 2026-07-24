<?php

use Illuminate\Support\Str;

if (! function_exists('enum_label')) {
    /**
     * Get the translated label for any backed enum case.
     *
     * @param  BackedEnum  $enum   The enum case
     * @param  string|null $locale Optional locale override
     * @return string
     *
     * Usage:
     *   enum_label(OrderStatus::PENDING)       → "في الانتظار"
     *   enum_label(OrderStatus::PENDING, 'en') → "Pending"
     */
    function enum_label(BackedEnum $enum, ?string $locale = null): string
    {
        $enumName = Str::snake(class_basename($enum::class));
        $caseName = Str::lower($enum->name);
        $key = "enums.{$enumName}.{$caseName}";

        return $locale ? __($key, [], $locale) : __($key);
    }
}
