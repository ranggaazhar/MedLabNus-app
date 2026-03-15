<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $logs = Activity::with(['causer', 'subject'])
            ->when($search, function ($query, $search) {
                return $query->where('description', 'like', "%{$search}%")
                    ->orWhere('properties', 'like', "%{$search}%")
                    ->orWhereHas('causer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString(); // Menjaga keyword search tetap ada saat pindah halaman pagination

        return view('admin.log.index', compact('logs', 'search'));
    }

    public function show($id)
    {
        $log = Activity::findOrFail($id);
        return view('admin.log.show', compact('log'));
    }
}
