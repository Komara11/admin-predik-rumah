<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SettingsController extends Controller
{
    private string $flaskApi = 'http://127.0.0.1:5000';

    public function index()
    {
        $modelInfo = null;
        try {
            $response = Http::timeout(5)->get($this->flaskApi . '/model-info');
            if ($response->ok()) {
                $modelInfo = $response->json();
            }
        } catch (\Exception $e) {}

        return view('admin.settings', compact('modelInfo'));
    }

    /**
     * Trigger model retraining via Flask API.
     */
    public function retrain(Request $request)
    {
        $payload = [
            'n_estimators' => (int) $request->input('n_estimators', 100),
            'max_depth'    => $request->input('max_depth', 50),
            'test_size'    => (int) $request->input('test_size', 20),
        ];

        try {
            $response = Http::timeout(120)->post($this->flaskApi . '/retrain', $payload);

            if ($response->ok()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Flask API error'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
