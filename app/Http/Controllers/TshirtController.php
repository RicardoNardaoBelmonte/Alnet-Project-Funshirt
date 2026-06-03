<?php

namespace App\Http\Controllers;

use App\Models\Tshirt;
use Illuminate\View\View;

class TshirtController extends Controller
{
    public function show(Tshirt $tshirt): View
    {
        if ($tshirt->customer_id !== null) {
            abort(404);
        }

        return view('tshirts.show', [
            'tshirt' => $tshirt->load(['colors']),
            'sizes' => config('tshirt.sizes'),
        ]);
    }
}
