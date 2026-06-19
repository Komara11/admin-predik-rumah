<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Prediction;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    private string $flaskApi = 'http://127.0.0.1:5000';

    public function index()
    {
        $totalProperties = Property::count();
        $totalPredictions = Prediction::count();
        $latestPredictions = Prediction::latest()->take(10)->get();

        // Get model info from Flask
        $modelInfo = null;
        try {
            $response = Http::timeout(5)->get($this->flaskApi . '/model-info');
            if ($response->ok()) {
                $modelInfo = $response->json();
            }
        } catch (\Exception $e) {
            // Flask not available, use fallback
        }

        // Avg price
        $avgPrice = Property::avg('harga');

        // Location distribution
        $locationCounts = Property::selectRaw('lokasi, count(*) as total')
            ->groupBy('lokasi')
            ->orderByDesc('total')
            ->get();

        return view('admin.dashboard', compact(
            'totalProperties',
            'totalPredictions',
            'latestPredictions',
            'modelInfo',
            'avgPrice',
            'locationCounts'
        ));
    }

    public function guide()
    {
        return view('admin.guide');
    }
}
