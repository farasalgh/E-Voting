<?php

namespace App\Http\Controllers;


use App\Models\Candidates;
use App\Models\Vote;
use App\Models\Votes;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        try {
            if (auth()->user()->has_voted) {
                return view('vote.thankyou');
            }

            $candidates = Candidates::all();
            return view('vote.index', compact('candidates'));
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat memuat data.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'candidate_id' => 'required|exists:candidates,id'
            ], [
                'candidate_id.required' => 'Pilihan kandidat wajib diisi.',
                'candidate_id.exists' => 'Kandidat yang dipilih tidak valid.'
            ]);

            $user = auth()->user();
            
            if ($user->has_voted) {
                return redirect()->route('vote.index')
                    ->with('error', 'Anda sudah menggunakan hak pilih.');
            }

            Votes::create([
                'user_id' => $user->id,
                'candidate_id' => $request->candidate_id,
            ]);

            $user->update(['has_voted' => true]);

            return redirect()->route('vote.thankyou')
                ->with('success', 'Terima kasih telah berpartisipasi dalam pemilihan!');

        } catch (\Exception $e) {
            return redirect()->route('vote.index')
                ->with('error', 'Terjadi kesalahan saat memproses suara Anda.');
        }
    }
}