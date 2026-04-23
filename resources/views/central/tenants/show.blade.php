@extends('layouts.admin')

@section('title', 'Tenant: ' . $tenant->name)
@section('page-title', 'Tenant: ' . $tenant->name)

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Информация</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ID</dt>
                    <dd class="col-sm-8">{{ $tenant->id }}</dd>

                    <dt class="col-sm-4">Название</dt>
                    <dd class="col-sm-8">{{ $tenant->name }}</dd>

                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $tenant->email }}</dd>

                    <dt class="col-sm-4">Создан</dt>
                    <dd class="col-sm-8">{{ $tenant->created_at->format('d.m.Y H:i') }}</dd>

                    <dt class="col-sm-4">Домены</dt>
                    <dd class="col-sm-8">
                        @foreach($tenant->domains as $domain)
                            <span class="badge badge-info">{{ $domain->domain }}</span>
                        @endforeach
                    </dd>

                    <dt class="col-sm-4">CRM</dt>
                    <dd class="col-sm-8">
                        <a href="{{ global_asset('tenant/' . $tenant->id) }}" target="_blank">
                            {{ global_asset('tenant/' . $tenant->id) }}
                        </a>
                    </dd>

                    <dt class="col-sm-4">Лендинг ведущего</dt>
                    <dd class="col-sm-8">
                        <a href="{{ route('hosts.show', $tenant) }}" target="_blank">
                            {{ route('hosts.show', $tenant) }}
                        </a>
                    </dd>

                    <dt class="col-sm-4">Текущий дизайн</dt>
                    <dd class="col-sm-8">{{ $tenant->landingTemplateName() }}</dd>
                </dl>

                <form action="{{ route('admin.tenants.landing.update', $tenant) }}" method="POST" class="border-top pt-3">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="landing_template">Выбрать шаблон лендинга</label>
                        <select name="landing_template" id="landing_template" class="form-control">
                            @foreach($landingTemplates as $value => $label)
                                <option value="{{ $value }}" @selected(old('landing_template', $tenant->landingTemplate()) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-palette mr-1"></i> Сохранить дизайн
                    </button>
                    <a href="{{ route('hosts.show', $tenant) }}" target="_blank" class="btn btn-outline-success">
                        <i class="fas fa-external-link-alt mr-1"></i> Открыть лендинг
                    </a>
                </form>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Назад
                </a>
                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" onsubmit="return confirm('Удалить tenant?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
