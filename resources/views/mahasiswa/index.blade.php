@extends('template.main')

@section('content')
    <!--begin::App Main-->
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">DATA MAHASISWA</h3>
                            <div class="card-tools">
                                <a href="mahasiswa/create" class="btn btn-primary">Tambah</a>
                            </div>
                        </div>
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>tanggal_lahir</th>
                                        <th>Telepon</th>
                                        <th>email</th>
                                        <th>prodi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mahasiswa as $m)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $m->nim }}</td>
                                            <td>{{ $m->nama }}</td>
                                            <td>{{ $m->tanggal_lahir }}</td>
                                            <td>{{ $m->telp }}</td>
                                            <td>{{ $m->email }}</td>
                                            <td>{{ $m->prodi->nama }}</td>
                                            <td><img src="{{ asset('storage/' . $m->foto) }}" width="100px" height="100px" /></td>
                                            <td><a href="{{ url("mahasiswa/{$m->nim}/edit") }}"
                                                class="btn btn-warning">Edit</a> 
                                                <form action="{{ route('mahasiswa.destroy', $m->nim) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                                </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <!-- /.col -->
            </div>

            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
<!--end::App Main-->
@endsection
