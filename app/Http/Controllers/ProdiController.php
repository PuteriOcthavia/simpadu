<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['nama' => 'puteri', 'foto' => 'avatar2.png'];
        $prodi = Prodi::all();
        return view('prodi.index', compact('data', 'prodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = ['nama' => "puteri", 'foto' => 'avatar2.png'];
        $prodi = Prodi::all();
        return view('prodi.create', compact('data', 'prodi'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
                'nama' => 'required|max:100',
                'kaprodi' => 'required|max:50',
                'jurusan' => 'required|max:50',
            ],[
                'nama.required' => 'Nama Prodi harus diisi',
                'kaprodi.required' => 'Nama Kaprodi harus diisi',
                'jurusan.required' => 'Jurusan wajib diisi',
            ] );
        Prodi::create($validateData);
        return redirect('/prodi')->with('success', 'Data prodi berhasil ditambahkan.');
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
        $prodi = Prodi::findOrFail($id);
        return view('prodi.edit', compact('data', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $prodi = Prodi::findOrFail($id);

         $validateData = $request->validate([
                'nama' => 'required|max:100',
                'kaprodi' => 'required|max:50',
                'jurusan' => 'required|max:50',
            ],[
                'nama.required' => 'Nama Prodi harus diisi',
                'kaprodi.required' => 'Nama Kaprodi harus diisi',
                'jurusan.required' => 'Jurusan wajib diisi',
            ] );

        $prodi->update($validateData);
        return redirect('/prodi')->with('success', 'Data Prodi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->mahasiswa()->delete(); // 
        $prodi->delete();

        return redirect()->route('prodi.index')->with('success', 'Prodi dan data mahasiswa terkait berhasil dihapus.');
    }
}
