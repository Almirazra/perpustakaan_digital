<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak kartu anggota</title>
    <style>
        @page { size: A4; margin: 10mm; }
        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { margin: 0; background: #DEE6EE; color: #3E4A56; font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif; }

        .toolbar { display: flex; align-items: center; gap: 12px; padding: 12px 20px; background: #3E4A56; color: #DEE6EE; font-size: 14px; }
        .toolbar span { flex: 1; }
        .toolbar button, .toolbar a { background: #E6D2C2; color: #3E4A56; border: 0; border-radius: 6px; padding: 7px 14px; font-size: 14px; cursor: pointer; text-decoration: none; }
        .toolbar a { background: transparent; color: #DEE6EE; border: 1px solid #74879A; }

        .sheet {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 6mm;
    max-width: 177.2mm;
    margin: 0 auto;
    padding: 8mm 0;
}

        .kartu { width: 85.6mm; height: 54mm; border-radius: 3mm; overflow: hidden; background: #fff; border: 0.3mm solid #B2C1CF; display: flex; flex-direction: column; break-inside: avoid; page-break-inside: avoid; }
        .kartu-head { background: #3E4A56; color: #E6D2C2; padding: 2.4mm 4mm; display: flex; justify-content: space-between; align-items: center; }
        .kartu-head strong { font-size: 3.6mm; font-weight: 600; letter-spacing: .2mm; }
        .kartu-head small { font-size: 2.6mm; color: #B2C1CF; }

        .kartu-body { flex: 1; display: flex; align-items: center; gap: 4mm; padding: 0 4mm; }
        .avatar { width: 16mm; height: 16mm; border-radius: 50%; background: #E6D2C2; color: #3E4A56; display: flex; align-items: center; justify-content: center; font-size: 7mm; font-weight: 600; flex-shrink: 0; }
        .nama { font-size: 4.2mm; font-weight: 600; line-height: 1.2; }
        .meta { font-size: 3mm; color: #74879A; margin-top: 1mm; line-height: 1.5; }
        .meta b { color: #3E4A56; font-weight: 600; }

        .kartu-foot { padding: 1.6mm 4mm 2.4mm; border-top: 0.3mm dashed #B2C1CF; display: flex; align-items: center; justify-content: space-between; gap: 3mm; }
        .kartu-foot svg { height: 7mm; max-width: 42mm; }
        .kartu-foot p { margin: 0; font-size: 2.2mm; color: #74879A; text-align: right; line-height: 1.3; }

        .kosong { text-align: center; padding: 40px; color: #74879A; }

        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .sheet { padding: 0; }
        }
    </style>
</head>
<body>

<div class="toolbar">
    <span>{{ $siswas->count() }} kartu siap dicetak. </span>
    <a href="{{ route('siswa.index') }}">Kembali</a>
    <button type="button" onclick="window.print()">Cetak</button>
</div>

@if ($siswas->isEmpty())
    <div class="kosong">Tidak ada siswa yang cocok untuk dicetak.</div>
@else
    <div class="sheet">
        @foreach ($siswas as $s)
            <div class="kartu">
                <div class="kartu-head">
                    <strong>PERPUSTAKAAN DIGITAL</strong>
                    <small>Kartu anggota</small>
                </div>

                <div class="kartu-body">
                    <div class="avatar">{{ Str::upper(Str::substr($s->nama_lengkap, 0, 1)) }}</div>
                    <div>
                        <div class="nama">{{ $s->nama_lengkap }}</div>
                        <div class="meta">
                            NIS <b>{{ $s->nis }}</b><br>
                            Kelas <b>{{ $s->kelas }} {{ $s->jurusan }}</b>
                        </div>
                    </div>
                </div>

                <div class="kartu-foot">
                    <svg class="barcode" data-nis="{{ $s->nis }}"></svg>
                    <p>Wajib dibawa<br>saat meminjam buku</p>
                </div>
            </div>
        @endforeach
    </div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.6/JsBarcode.all.min.js"></script>
<script>
document.querySelectorAll('svg.barcode').forEach((el) => {
    JsBarcode(el, el.dataset.nis, { format: 'CODE128', height: 28, displayValue: false, margin: 0, width: 1.4 });
});
</script>
</body>
</html>
