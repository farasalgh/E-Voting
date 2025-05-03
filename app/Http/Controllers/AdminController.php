<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Votes;
use App\Models\Candidates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalVotes' => Votes::count(),
            'latestVote' => Votes::with('candidate')->latest()->first(),
            'recentVotes' => Votes::with(['candidate', 'user'])
                ->latest()
                ->take(10)
                ->get(),
            'candidates' => Candidates::withCount('votes')
                ->latest()
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function candidates()
    {
        $candidates = Candidates::withCount('votes')->latest()->get();
        return view('admin.candidates', compact('candidates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'slogan' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        Candidates::create($validated);
        return redirect()->route('admin.candidates')->with('success', 'Candidate added successfully');
    }

    public function show(Candidates $candidate)
    {
        return response()->json($candidate);
    }

    public function update(Request $request, Candidates $candidate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'slogan' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }
            $validated['photo'] = $request->file('photo')->store('candidates', 'public');
        }

        $candidate->update($validated);
        return redirect()->route('admin.candidates')->with('success', 'Candidate updated successfully');
    }

    public function destroy(Candidates $candidate)
    {
        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }
        $candidate->delete();
        return response()->json(['message' => 'Candidate deleted successfully']);
    }
}