<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $service_heading ?? 'Report' }} Report</title>
    @include('pdf.partials.report-styles')
</head>
<body>
    @include('pdf.partials.letterhead')

    <h1 class="report-title">
        {{ strtoupper($service_heading ?? '') }} REPORT OF {{ strtoupper($report_label ?? '') }}
    </h1>

    <table class="report-table">
        <thead>
            <tr>
                <th scope="col">NO.</th>
                <th scope="col">REFERENCE CODE</th>
                <th scope="col">CLIENT</th>
                <th scope="col">ADDRESS</th>
                <th scope="col">CONTACT NUMBER</th>
                <th scope="col">DATE</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rows ?? [] as $r)
                <tr>
                    <td class="col-no">{{ $r['no'] ?? '' }}</td>
                    <td>{{ $r['reference_code'] ?? '' }}</td>
                    <td>{{ $r['client'] ?? '' }}</td>
                    <td>{{ $r['address'] ?? '' }}</td>
                    <td>{{ $r['contact_number'] ?? '' }}</td>
                    <td>{{ $r['date'] ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="report-empty">No records for this month.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="signature">
        <p class="signature-name">REV. FR. RAMON A. NAVALLASCA</p>
        <p class="signature-role">Parish Priest</p>
    </div>
</body>
</html>
