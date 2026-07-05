from pathlib import Path

root = Path(r"c:\xampp\htdocs\SAPP-CHURCH\resources\views")
jobs = [
    (
        "christening/view/christening.blade.php",
        "sappcChristeningCertificationModal",
        "christening.partials.certificationModal",
        "@include('partials.sappcCertificatePreviewModal')",
    ),
    (
        "wedding/view/wedding.blade.php",
        "sappcWeddingCertificationModal",
        "wedding.partials.certificationModal",
        "@include('wedding.partials.marriageCertificatePrintable')",
    ),
]

for rel, wrapper_class, partial, marker in jobs:
    path = root / rel
    text = path.read_text(encoding="utf-8")
    start = text.find(f'<div class="{wrapper_class}">')
    end = text.find(marker, start)
    if start == -1 or end == -1:
        print("FAIL", rel, start, end)
        continue
    include = f"    @include('{partial}', ['generatedReferenceCode' => $generatedReferenceCode ?? ''])\n\n    "
    path.write_text(text[:start] + include + text[end:], encoding="utf-8")
    print("OK", rel, "removed", end - start, "chars")
