@extends('layouts.admin')

@section('title', 'Управление тенантами')
@section('page-title', 'Тенанты')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-building mr-2"></i>Список тенантов</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новый тенант
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Email</th>
                            <th>Домены</th>
                            <th>Создан</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tenants as $tenant)
                            <tr>
                                <td>{{ $tenant->id }}</td>
                                <td>{{ $tenant->name }}</td>
                                <td>{{ $tenant->email }}</td>
                                <td>
                                    @foreach($tenant->domains as $domain)
                                        <span class="badge badge-info">{{ $domain->domain }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $tenant->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить тенанта?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Тенанты не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $tenants->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
