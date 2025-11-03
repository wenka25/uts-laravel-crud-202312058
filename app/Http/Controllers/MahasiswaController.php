<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    // READ
    public function index(Request $request)
    {
        $search = $request->search;

        $mahasiswa = Mahasiswa::when($search, function($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nim', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(5); // <-- tambahkan paginate() di sini

        return view('mahasiswa.index', compact('mahasiswa'));
    }

    // CREATE FORM
    public function create()
    {
        return view('mahasiswa.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'email' => 'required|email|unique:mahasiswas',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil ditambahkan!');
    }

    // EDIT FORM
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // UPDATE
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,'.$mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,'.$mahasiswa->id,
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil dihapus!');
    }

    // CETAK PDF
    public function cetakPdf()
    {
        $mahasiswa = Mahasiswa::all();

        $pdf = PDF::loadView('mahasiswa.pdf', compact('mahasiswa'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('daftar_mahasiswa.pdf');
    }
    
    // Export Excel
    public function export()
    {
        return Excel::download(new MahasiswaExport, 'mahasiswa.xlsx');
    }
}