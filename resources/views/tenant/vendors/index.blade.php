@extends('layouts.app')

@section('title', 'Подрядчики')
@section('page-title', 'Подрядчики')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-briefcase mr-2"></i>Подрядчики</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.vendors.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>Новый подрядчик</a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead><tr><th>Название</th><th>Тип</th><th>Телефон</th><th>Email</th><th>Статус</th><th>Действия</th></tr></thead>
                    <tbody>
                        @forelse($vendors as $vendor)
                            <tr>
                                <td><a href="{{ route('tenant.vendors.show', $vendor) }}">{{ $vendor->name }}</a></td>
                                <td>{{ $vendor->type ?? '—' }}</td>
                                <td>{{ $vendor->phone ?? '—' }}</td>
                                <td>{{ $vendor->email ?? '—' }}</td>
                                <td>@if($vendor->is_active)<span class="badge badge-success">Активен</span>@else<span class="badge badge-secondary">Неактивен</span>@endif</td>
                                <td>
                                    <a href="{{ route('tenant.vendors.show', $vendor) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('tenant.vendors.edit', $vendor) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('tenant.vendors.destroy', $vendor) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">Подрядчики не найдены</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">{{ $vendors->links() }}</div>
        </div>
    </div>
</div>
@endsection
