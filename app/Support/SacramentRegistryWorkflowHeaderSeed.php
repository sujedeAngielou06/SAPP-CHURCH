<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * After an application is saved, persist ref / client / address / contact for
 * certification and schedule workflow pages (header-only — no cert body or schedule date).
 */
final class SacramentRegistryWorkflowHeaderSeed
{
    public const CHRISTENING = 'Christening';

    public const CONFIRMATION = 'Confirmation';

    public const WEDDING = 'Wedding';

    public const BURIAL = 'Burial';

    public static function afterApplicationSave(string $registryType, int $recordId): void
    {
        if ($recordId <= 0) {
            return;
        }

        match ($registryType) {
            self::CHRISTENING => self::seedFromRegistryRow(self::CHRISTENING, 'christening', 'christeningId', $recordId, true, false),
            self::CONFIRMATION => self::seedFromRegistryRow(self::CONFIRMATION, 'confirmation', 'confirmationId', $recordId, false, false),
            self::WEDDING => self::seedFromRegistryRow(self::WEDDING, 'wedding', 'weddingId', $recordId, false, true),
            self::BURIAL => self::seedFromRegistryRow(self::BURIAL, 'burial', 'burialId', $recordId, false, false),
            default => null,
        };
    }

    private static function seedFromRegistryRow(
        string $registryType,
        string $table,
        string $pkColumn,
        int $recordId,
        bool $seedChristeningCert,
        bool $seedWeddingCert,
    ): void {
        if (! Schema::hasTable($table)) {
            return;
        }

        $row = DB::table($table)->where($pkColumn, $recordId)->first();
        if ($row === null) {
            return;
        }

        $client = ClientNameDisplay::fullDisplayName(
            $row->clientFName ?? null,
            $row->clientMName ?? null,
            $row->clientLName ?? null,
        );

        self::seedCertificationDetailsRow(
            $registryType,
            $recordId,
            trim((string) ($row->referenceCode ?? '')),
            $client,
            trim((string) ($row->address ?? '')),
            trim((string) ($row->contactNum ?? '')),
        );

        if ($seedChristeningCert) {
            self::seedChristeningCertificationStub($recordId);
        }
        if ($seedWeddingCert) {
            self::seedWeddingCertificationStub($recordId);
        }
    }

    private static function seedCertificationDetailsRow(
        string $registryType,
        int $recordId,
        string $referenceCode,
        string $client,
        string $address,
        string $contactNumber,
    ): void {
        if (! Schema::hasTable('certification_details')) {
            return;
        }

        $existing = DB::table('certification_details')
            ->where('registryType', $registryType)
            ->where('registryRecordId', $recordId)
            ->orderByDesc('certificationDetailsId')
            ->first();

        if ($existing === null) {
            DB::table('certification_details')->insert([
                'registryType' => $registryType,
                'registryRecordId' => $recordId,
                'referenceCode' => self::nullable($referenceCode),
                'client' => self::nullable($client),
                'address' => ClientNameDisplay::nullableFormattedAddress($address),
                'contactNumber' => self::nullable($contactNumber),
                'date' => now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        $update = [];
        if (trim((string) ($existing->referenceCode ?? '')) === '' && $referenceCode !== '') {
            $update['referenceCode'] = $referenceCode;
        }
        if (trim((string) ($existing->client ?? '')) === '' && $client !== '') {
            $update['client'] = $client;
        }
        if (trim((string) ($existing->address ?? '')) === '' && $address !== '') {
            $update['address'] = ClientNameDisplay::nullableFormattedAddress($address);
        }
        if (trim((string) ($existing->contactNumber ?? '')) === '' && $contactNumber !== '') {
            $update['contactNumber'] = $contactNumber;
        }

        if ($update !== []) {
            $update['updated_at'] = now();
            DB::table('certification_details')
                ->where('certificationDetailsId', $existing->certificationDetailsId)
                ->update($update);
        }
    }

    private static function seedChristeningCertificationStub(int $christeningId): void
    {
        if (! Schema::hasTable('christening_certification')) {
            return;
        }

        if (DB::table('christening_certification')->where('christeningId', $christeningId)->exists()) {
            return;
        }

        DB::table('christening_certification')->insert([
            'christeningId' => $christeningId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private static function seedWeddingCertificationStub(int $weddingId): void
    {
        if (! Schema::hasTable('wedding_certification')) {
            return;
        }

        if (DB::table('wedding_certification')->where('weddingId', $weddingId)->exists()) {
            return;
        }

        DB::table('wedding_certification')->insert([
            'weddingId' => $weddingId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private static function nullable(string $value): ?string
    {
        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }
}
