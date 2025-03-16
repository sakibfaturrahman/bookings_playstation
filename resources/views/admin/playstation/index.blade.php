@extends('admin.layouts.app')
@section('title')
    Collection Playstation
@endsection

@section('content')
    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Playstation</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPs">
                    Tambah Playstation
                </button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama PS</th>
                        <th>Harga Sewa</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($playstation as $ps)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $ps->name }}
                            </td>
                            <td>
                                {{ $ps->harga_sewa }}
                            </td>
                            <td>
                                {{ $ps->deskripsi }}
                            </td>
                            <td>
                                <img src="{{ asset('storage/images/' . $ps->gambar) }}" alt="gambar">
                            </td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#editPs{{ $ps->id }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#hapusPs{{ $ps->id }}">
                                    Hapus
                                </button>
                            </td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal tambah ps -->
    <div class="modal fade" id="tambahPs" tabindex="-1" aria-labelledby="tambahPsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahPsLabel">Tambah Playstation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.playstation.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama PS</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_sewa" class="form-label">Harga Sewa</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar">Gambar PS</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($playstation as $item)
        <div class="modal fade" id="editPs{{ $item->id }}" tabindex="-1" aria-labelledby="editPsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editPsLabel">Tambah Playstation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.playstation.update', $item->id) }}') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama PS</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $item->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_sewa" class="form-label">Harga Sewa</label>
                                <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                                    value="{{ $item->harga_sewa }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" required>{{ $item->deskripsi }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="gambar">Gambar PS</label>
                                <input type="file" class="form-control" id="gambar" name="gambar" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($playstation as $item)
        <div class="modal fade" id="hapusPs{{ $item->id }}" tabindex="-1" aria-labelledby="hapusPsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="hapusPsLabel">Hapus Playstation</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.playstation.destroy', $item->id) }}" method="POST">
                            @csrf
                            <p>Hapus {{ $item->name }} dari daftar?</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="errorModalLabel">Tambah Playstation</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errorList"></ul>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        @if ($errors->any())
            <script>
                $(document).ready(function() {
                    $('#errorList').empty();
                    @foreach ($errors->all() as $error)
                        $('#errorList').append('<li>{{ $error }}</li>');
                    @endforeach
                    $('#errorModal').modal('show');
                });
            </script>
        @endif
    @endpush
@endsection
