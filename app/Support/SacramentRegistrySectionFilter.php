<?php

namespace App\Support;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Registry workflow pages share the same rows once an application is saved.
 * Payment, certification, and schedule tabs list those records (ref, client, address, contact)
 * so staff can open each modal when ready — steps are not required before the row appears.
 */
final class SacramentRegistrySectionFilter
{
    public const SECTION_APPLICATION = 'application';

    public const SECTION_SCHEDULE = 'schedule';

    public const SECTION_PAYMENT = 'payment';

    public const SECTION_CERTIFICATION = 'certification';

    public static function apply(Builder $query, string $registryTable, string $section): void
    {
        $section = strtolower(trim($section));
        if ($section === '') {
            return;
        }

        match ($registryTable) {
            'christening' => self::applyChristening($query, $section),
            'confirmation' => self::applyConfirmation($query, $section),
            'wedding' => self::applyWedding($query, $section),
            'burial' => self::applyBurial($query, $section),
            default => null,
        };
    }

    private static function applyChristening(Builder $query, string $section): void
    {
        match ($section) {
            self::SECTION_APPLICATION,
            self::SECTION_SCHEDULE,
            self::SECTION_PAYMENT,
            self::SECTION_CERTIFICATION => self::whereChristeningApplicationSaved($query),
            default => null,
        };
    }

    private static function applyConfirmation(Builder $query, string $section): void
    {
        match ($section) {
            self::SECTION_APPLICATION,
            self::SECTION_SCHEDULE,
            self::SECTION_PAYMENT,
            self::SECTION_CERTIFICATION => self::whereConfirmationApplicationSaved($query),
            default => null,
        };
    }

    private static function applyWedding(Builder $query, string $section): void
    {
        match ($section) {
            self::SECTION_APPLICATION,
            self::SECTION_SCHEDULE,
            self::SECTION_PAYMENT,
            self::SECTION_CERTIFICATION => self::whereWeddingApplicationSaved($query),
            default => null,
        };
    }

    private static function applyBurial(Builder $query, string $section): void
    {
        match ($section) {
            self::SECTION_APPLICATION,
            self::SECTION_SCHEDULE,
            self::SECTION_PAYMENT,
            self::SECTION_CERTIFICATION => self::whereBurialApplicationSaved($query),
            default => null,
        };
    }

    private static function whereChristeningApplicationSaved(Builder $query): void
    {
        $query->whereExists(function (Builder $sub) {
            $sub->select(DB::raw('1'))
                ->from('christening_details as cd')
                ->whereColumn('cd.christeningId', 'christening.christeningId')
                ->whereRaw("TRIM(COALESCE(cd.firstName, '')) <> ''")
                ->whereRaw("TRIM(COALESCE(cd.familyName, '')) <> ''");
        });
    }

    private static function whereConfirmationApplicationSaved(Builder $query): void
    {
        $query->where(function (Builder $w) {
            if (Schema::hasTable('confirmation_details')) {
                $w->whereExists(function (Builder $sub) {
                    $sub->select(DB::raw('1'))
                        ->from('confirmation_details as cd')
                        ->whereColumn('cd.confirmationId', 'confirmation.confirmationId')
                        ->whereRaw("TRIM(COALESCE(cd.firstName, '')) <> ''")
                        ->whereRaw("TRIM(COALESCE(cd.familyName, '')) <> ''");
                });
            }
            $w->orWhere(function (Builder $w2) {
                $w2->whereNotNull('confirmationApplication')
                    ->whereRaw("TRIM(COALESCE(confirmationApplication, '')) <> ''")
                    ->whereRaw("TRIM(COALESCE(confirmationApplication, '')) <> '[]'");
            });
        });
    }

    private static function whereWeddingApplicationSaved(Builder $query): void
    {
        $query->whereNotNull('marriageApplication')
            ->whereRaw("TRIM(COALESCE(marriageApplication, '')) <> ''")
            ->whereRaw("TRIM(COALESCE(marriageApplication, '')) <> '[]'");
    }

    private static function whereBurialApplicationSaved(Builder $query): void
    {
        if (! Schema::hasTable('burial_details')) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->whereExists(function (Builder $sub) {
            $sub->select(DB::raw('1'))
                ->from('burial_details as bd')
                ->whereColumn('bd.burialId', 'burial.burialId')
                ->whereRaw("TRIM(COALESCE(bd.deceasedName, '')) <> ''");
        });
    }
}
