<?php

namespace App\Http\Controllers;
use App\Models\SiswaModel as Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    private const Kelas = [
        'X', 'XI', 'XII',
    ];
    private const JURUSAN = [
    'RPL'  => 'RPL (Rekayasa Perangkat Lunak)',
    'TKJ'  => 'TKJ (Teknik Komputer dan Jaringan)',
    'AKL'  => 'AKL (Akuntansi dan Keuangan Lembaga)',
    'MP' => 'MP (Manajemen Perkantoran)',
    'PM'  => 'PM (Pemasaran)',
    'KLN' => 'KLN (Kuliner)',
    'TKKR' => 'TKKR (Tata Kecantikan Laut dan Rambut)',
];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::orderBy('nama_lengkap')->get();

        return view('pages.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.siswa.create', [
            'DaftarKelas' => self::Kelas,
            'DaftarJurusan' => self::JURUSAN,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nis' => 'required|string|max:20|unique:siswas,nis',
            'nama_lengkap' => 'required|string|max:255',
            'kelas'        => ['required', Rule::in(self::Kelas)],
            'jurusan' => ['required', Rule::in(array_keys(self::JURUSAN))],
            'telp'         => ['nullable', 'regex:/^[0-9+]{8,15}$/'],
        ], $this->pesan());

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->load(['peminjamans' => fn ($q) => $q->latest(), 'peminjamans.buku']);

        return view('pages.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view ('pages.siswa.edit', [
            'siswa' => Siswa::findOrFail($id),
            'DaftarKelas' => self::Kelas,
            'DaftarJurusan' => self::JURUSAN,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::findOrFail($id);

        $data = $request->validate([
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswas', 'nis')->ignore($siswa->id)],
            'nama_lengkap' => 'required|string|max:255',
            'kelas'        => ['required', Rule::in(self::Kelas)],
            'jurusan' => ['required', Rule::in(array_keys(self::JURUSAN))],
            'telp'         => ['nullable', 'regex:/^[0-9+]{8,15}$/'],
        ], $this->pesan());

        $siswa->update($data);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        if ($siswa->peminjamans()->exists()) {
            return redirect()->route('siswa.index')
                ->with('error', "Siswa \"{$siswa->nama_lengkap}\" masih meminjam {$siswa->peminjamans()->count()} buku, jadi tidak bisa dihapus");
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
    private function pesan(): array
    {
        return [
            'nis.required' => 'NIS wajib diisi',
            'nis.string'   => 'NIS harus berupa teks',
            'nis.max'      => 'NIS maksimal 20 karakter',
            'nis.unique'   => 'NIS sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_lengkap.string'   => 'Nama lengkap harus berupa teks',
            'nama_lengkap.max'      => 'Nama lengkap maksimal 255 karakter',
            'kelas.required'        => 'Kelas wajib dipilih',
            'kelas.in'              => 'Kelas tidak valid',
            'jurusan.required'      => 'Jurusan wajib dipilih',
            'jurusan.in'            => 'Jurusan tidak valid',
            'telp.regex'            => 'Nomor telepon tidak valid, hanya boleh angka dan tanda +, dengan panjang 8-15 karakter',
        ];
    }
    public function kartu(Siswa $siswa)
{
    return view('pages.siswa.kartu', ['siswas' => collect([$siswa])]);
}

public function kartuSemua(Request $request)
{
    $siswas = Siswa::query()
        ->when($request->kelas, fn ($q, $kelas) => $q->where('kelas', $kelas))
        ->when($request->jurusan, fn ($q, $jurusan) => $q->where('jurusan', $jurusan))
        ->orderBy('kelas')
        ->orderBy('nama_lengkap')
        ->get();

    return view('pages.siswa.kartu', compact('siswas'));
}
}
