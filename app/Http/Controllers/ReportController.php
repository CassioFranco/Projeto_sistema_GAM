<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $min = $request->query('min_value', 0);
        $avg = Asset::avg('valor_contabil');
        $count = Asset::where('valor_contabil','>', $min)->count();

        return response()->json([
            'avg_valor_contabil' => round($avg,2),
            'count_above_min' => $count,
        ]);
    }
}
