@extends('layouts.app')

@section('title', 'Товары')
@section('page-title', 'Товары')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-box mr-2"></i>Список товаров</h3>
                <div class="card-tools">
                    <a href="{{ route('tenant.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus mr-1"></i>Новый товар
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover table-head-fixed">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }} ₽</td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge badge-success">Активен</span>
                                    @else
                                        <span class="badge badge-secondary">Неактивен</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('tenant.products.edit', $product) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('tenant.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Удалить товар?')">
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
                                <td colspan="4" class="text-center text-muted py-4">Товары не найдены</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
