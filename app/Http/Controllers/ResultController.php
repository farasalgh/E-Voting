<?php

namespace App\Http\Controllers;


use App\Models\Candidates;
use App\Models\User;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $totalVoters = User::where('is_admin', false)->count();
        return view('results.index', compact('totalVoters'));
    }

    public function getResults()
    {
        try {
            $results = Candidates::withCount('votes')
                ->orderByDesc('votes_count')
                ->get();

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat memuat data.'], 500);
        }
    }
}