<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = ['nama' => "puteri", 'foto' => 'avatar2.png'];
        $mahasiswa = Mahasiswa::with('prodi')->get();
        //dd($mahasiswa);
        return view('mahasiswa.index', compact('data', 'mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['nama' => "puteri", 'foto' => 'avatar2.png'];
        $prodi = Prodi::all();
        return view('mahasiswa.create', compact('data', 'prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'nim' => 'required|unique:mahasiswa|max:10',
                'password' => 'required',
                'nama' => 'required|max:100',
                'tanggal_lahir' => 'required|date',
                'telp' => 'required|max:20',
                'email' => 'required|unique:mahasiswa|max:100',
                'foto' => 'image|file|max:2048',
                'id_prodi' => 'required|exists:prodi,id'
            ],
            [
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'nim.max' => 'NIM maksimal 10 karakter',
                'password.required' => 'Password wajib diisi',
                'password.min' => 'Password minimal 6 karakter',
                'nama.required' => 'Nama wajib diisi',
                'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi',
                'tanggal_lahir.date' => 'Format Tanggal Lahir tidak valid',
                'telp.required' => 'Telepon wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Format Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'foto.image' => 'File harus berupa gambar',
                'foto.max' => 'Ukuran gambar maksimal 2MB',
                'id_prodi.required' => 'Prodi wajib dipilih',
                'id_prodi.exists' => 'Prodi tidak ditemukan',
            ]
        );
        if ($request->file('foto')) {
            $validateData['foto'] = $request->file('foto')->store('image');
        }
        $validateData['password'] = Hash::make($validateData['password']);
        $data = array_merge($validateData, $request->only(['id_prodi']));
        Mahasiswa::create($data);
        return redirect('/mahasiswa');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ['nama' => "puteri", 'foto' => 'avatar2.png'];
        $mahasiswa = Mahasiswa::find($id);
        $prodi = Prodi::all();
        return view('mahasiswa.edit', compact('data', 'mahasiswa', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        
        $validateData = $request->validate(
            [
                'nama' => 'required|max:100',
                'tanggal_lahir' => 'required|date',
                'telp' => 'required|max:20',
                'email' => 'required|email|max:100',
                'foto' => 'image|file|max:2048',
                'id_prodi' => 'required|exists:prodi,id'
            ],
            [
                'password.required' => 'Password wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi',
                'telp.required' => 'Telepon wajib diisi',
                'email.required' => 'Email wajib diisi',
            ]
        );
        $mahasiswa->update($validateData);
        if ($request->file('foto')) {
            if ($mahasiswa->foto) {
                Storage::delete($mahasiswa->foto);
            }
            $validateData['foto'] = $request->file('foto')->store('image');
        }
        if ($request->input(['password'])) {
            $validateData['password'] = Hash::make($request->password);
        }
        $data = array_merge($validateData, $request->only(['id_prodi']));
        Mahasiswa::where('nim', $id)->update($data);
        return redirect('/mahasiswa');
    }

    /**
     * Remove the specified resource from storage.
     */
     public function destroy($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        if ($mahasiswa->foto && Storage::exists('public/foto/' . $mahasiswa->foto)) {
            Storage::delete('public/foto/' . $mahasiswa->foto);
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

}
