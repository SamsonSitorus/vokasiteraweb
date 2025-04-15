@extends('layouts.main')
@section('title', 'Tugas')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Tugas</h1>
    </div>

    <div class="card border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tambah Tugas Baru</h5>
            <a href="{{ route('tugas.create') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus-square"></i> Add Task
            </a>
        </div>
        <div class="card-body">
            @forelse ($tugas as $item)
                <div class="border p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>{{ $item->judul }}</strong>
                        <div>
                            <a href="{{ route('tugas.edit', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Task
                            </a>
                            <a href="{{ route('tugas.show', $item->id) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form action="{{ route('tugas.delete', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                    <i class="fas fa-trash-alt"></i> Delete Task
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada tugas yang tersedia.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
