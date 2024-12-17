<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function fetchQuote()
    {
        try {
            $response = Http::withOptions(['verify' => false]) // Temporarily disable SSL verification
                ->get('https://api.quotable.io/random');

            if ($response->successful()) {
                $quote = $response->json();
                return response()->json([
                    'content' => $quote['content'],
                    'author' => $quote['author']
                ]);
            }

            return response()->json(['error' => 'Failed to fetch quote'], 500);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
