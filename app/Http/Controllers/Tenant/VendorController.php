<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(15);
        return view('tenant.vendors.index', compact('vendors'));
    }

    public function create()
    {
        return view('tenant.vendors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Vendor::create($validated);
        return redirect()->route('tenant.vendors.index')->with('success', 'Подрядчик создан');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load('budgetItems');
        return view('tenant.vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('tenant.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $vendor->update($validated);
        return redirect()->route('tenant.vendors.index')->with('success', 'Подрядчик обновлён');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('tenant.vendors.index')->with('success', 'Подрядчик удалён');
    }
}
