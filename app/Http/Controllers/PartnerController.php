<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->paginate(10);

        return view(
            'pos.partners.index',
            compact('partners')
        );
    } 

    public function create()
    {
        return view('pos.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required',
            'owner_name' => 'required',
            'address' => 'nullable',
            'phone' => 'nullable',
        ]);

        Partner::create([
            'shop_name' => $request->shop_name,
            'owner_name' => $request->owner_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => true,
            'joined_at' => now(),
        ]);

        return redirect()
            ->route('partners')
            ->with('success','Mitra berhasil ditambahkan.');
    }

    public function edit(Partner $partner)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        return view(
            'pos.partners.edit',
            compact('partner')
        );
    }

    public function update(Request $request, Partner $partner)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'shop_name'  => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'address'    => 'nullable|string',
            'phone'      => 'nullable|string|max:20',
        ]);

        $partner->update([
            'shop_name'  => $request->shop_name,
            'owner_name' => $request->owner_name,
            'address'    => $request->address,
            'phone'      => $request->phone,
        ]);

        return redirect()
            ->route('partners')
            ->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function destroy(Partner $partner)
    {
        if (auth()->user()->role != 'admin') {
            abort(403);
        }

        $partner->delete();

        return redirect()
            ->route('partners')
            ->with('success', 'Mitra berhasil dihapus.');
    }
}
