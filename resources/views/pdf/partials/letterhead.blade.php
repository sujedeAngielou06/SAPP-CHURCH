@php
    $crestPath = public_path('assets/logos/DSA.jpg');
    $sealPath = public_path('assets/logos/SAPPC.png');
@endphp
<table class="letterhead" role="presentation">
    <tr>
        <td style="width: 72px;">
            @if (is_file($crestPath))
                <img class="letterhead-logo" src="{{ $crestPath }}" alt="">
            @endif
        </td>
        <td class="letterhead-center">
            <p class="letterhead-line letterhead-line--primary">THE ROMAN CATHOLIC PARISH OF ST. ANTHONY OF PADUA</p>
            <p class="letterhead-line letterhead-line--sub">DIOCESE OF SAN JOSE DE ANTIQUE</p>
            <p class="letterhead-line letterhead-line--sub">BARBAZA, 5706, ANTIQUE, PHILIPPINES</p>
        </td>
        <td style="width: 72px; text-align: right;">
            @if (is_file($sealPath))
                <img class="letterhead-logo" src="{{ $sealPath }}" alt="">
            @endif
        </td>
    </tr>
</table>
