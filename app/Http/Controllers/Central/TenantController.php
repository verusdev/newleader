<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Stancl\Tenancy\Database\Models\Domain;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('domains')->latest()->paginate(15);
        return view('central.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('central.tenants.create', [
            'landingTemplates' => Tenant::LANDING_TEMPLATES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'domain' => 'required|string|max:255|unique:domains,domain',
            'landing_template' => 'required|in:' . implode(',', array_keys(Tenant::LANDING_TEMPLATES)),
        ]);

        $tenant = Tenant::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'landing_template' => $validated['landing_template'],
        ]);

        $tenant->domains()->create([
            'domain' => $validated['domain'],
        ]);

        return redirect(global_asset('admin/tenants'))->with('success', 'Тенант успешно создан');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load('domains');
        return view('central.tenants.show', [
            'tenant' => $tenant,
            'landingTemplates' => Tenant::LANDING_TEMPLATES,
        ]);
    }

    public function updateLanding(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'landing_template' => 'required|in:' . implode(',', array_keys(Tenant::LANDING_TEMPLATES)),
        ]);

        $tenant->landing_template = $validated['landing_template'];
        $tenant->save();

        return redirect()->route('admin.tenants.show', $tenant)
            ->with('success', 'Дизайн лендинга обновлён');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('admin.tenants.index')
            ->with('success', 'Тенант успешно удалён');
    }
}
