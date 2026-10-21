<?php

return [
    // Durasi pinjam default (hari)
    'durasi_pinjam_hari' => (int) env('PINJAM_DURASI_HARI', 7),

    // Denda per hari keterlambatan (rupiah)
    'denda_per_hari' => (int) env('DENDA_PER_HARI', 1000),
];
