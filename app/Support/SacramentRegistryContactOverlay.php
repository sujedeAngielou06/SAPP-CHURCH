<?php

namespace App\Support;

class SacramentRegistryContactOverlay
{
    /** Payment, certification, and schedule modals: only these header fields sync from application. */
    private const OVERLAY_KEYS = ['client', 'contact_number', 'address'];

    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $fromApplication
     * @return array<string, mixed>
     */
    public static function mergeEmptyFields(array $payload, array $fromApplication): array
    {
        foreach (self::OVERLAY_KEYS as $key) {
            if (! array_key_exists($key, $fromApplication)) {
                continue;
            }
            if (trim((string) ($payload[$key] ?? '')) !== '') {
                continue;
            }
            $incoming = trim((string) $fromApplication[$key]);
            if ($incoming === '') {
                continue;
            }
            $payload[$key] = $key === 'address'
                ? ClientNameDisplay::formatAddress($incoming)
                : $incoming;
        }

        return $payload;
    }

    /**
     * @param  array<string, mixed>  $parts
     */
    public static function clientFromNameParts(array $parts): string
    {
        $name = array_filter([
            trim((string) ($parts['first_name'] ?? $parts['first'] ?? '')),
            trim((string) ($parts['middle_name'] ?? $parts['middle'] ?? '')),
            trim((string) ($parts['family_name'] ?? $parts['last'] ?? '')),
        ], fn ($s) => $s !== '');

        return implode(' ', $name);
    }
}
