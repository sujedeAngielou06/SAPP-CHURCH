<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $service_heading ?? 'Certification' }} Report</title>
    @include('pdf.partials.report-styles')
</head>
<body>
    @include('pdf.partials.letterhead')

    <h1 class="report-title">
        <span class="report-title-line">{{ strtoupper($service_heading ?? 'CHRISTENING') }}</span>
        <span class="report-title-line">CERTIFICATION REPORT</span>
        <span class="report-title-line">OF {{ strtoupper($report_label ?? '') }}</span>
    </h1>

    <table class="report-table">
        <thead>
            <tr>
                <th scope="col">NO.</th>
                <th scope="col">REFERENCE CODE</th>
                <th scope="col">CLIENT</th>
                <th scope="col">ADDRESS</th>
                <th scope="col">CONTACT NUMBER</th>
                <th scope="col">DATE &amp; TIME</th>
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
                    <td colspan="6" class="report-empty">No certification records found.</td>
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
