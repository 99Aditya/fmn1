<?php

namespace App\Http\Controllers;

use App\Models\UserEducation;
use App\Models\UserExperience;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load(['profile', 'skills', 'educations', 'experiences', 'certificates.test', 'testAttempts']);
        $user->getOrCreateProfile();
        $user->refresh();
        return view('frontend.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user()->load(['profile', 'skills', 'educations', 'experiences']);
        $user->getOrCreateProfile();
        $user->refresh();
        return view('frontend.profile.edit', compact('user'));
    }

    public function updateBasic(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|alpha_dash|min:3|max:40|unique:user_profiles,username,' . auth()->user()->profile->id,
            'headline' => 'nullable|string|max:120',
            'bio'      => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:100',
            'website'  => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url'   => 'nullable|url|max:255',
            'twitter_url'  => 'nullable|url|max:255',
            'phone'        => 'nullable|string|max:20',
            'is_public'    => 'nullable|boolean',
        ]);

        auth()->user()->update(['name' => $request->name]);

        auth()->user()->profile->update([
            'username'     => $request->username,
            'headline'     => $request->headline,
            'bio'          => $request->bio,
            'location'     => $request->location,
            'website'      => $request->website,
            'linkedin_url' => $request->linkedin_url,
            'github_url'   => $request->github_url,
            'twitter_url'  => $request->twitter_url,
            'phone'        => $request->phone,
            'is_public'    => $request->boolean('is_public', true),
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);

        $path = $request->file('avatar')->store('avatars', 'public');
        auth()->user()->profile->update(['avatar' => $path]);

        return back()->with('success', 'Profile photo updated.');
    }

    /* ── Skills ── */
    public function storeSkill(Request $request)
    {
        $request->validate([
            'skill_name'  => 'required|string|max:60',
            'proficiency' => 'required|in:beginner,intermediate,advanced,expert',
        ]);
        auth()->user()->skills()->create([
            'skill_name'  => $request->skill_name,
            'proficiency' => $request->proficiency,
            'sort_order'  => auth()->user()->skills()->max('sort_order') + 1,
        ]);
        return back()->with('success', 'Skill added.');
    }

    public function destroySkill(UserSkill $skill)
    {
        abort_if($skill->user_id !== auth()->id(), 403);
        $skill->delete();
        return back()->with('success', 'Skill removed.');
    }

    /* ── Education ── */
    public function storeEducation(Request $request)
    {
        $request->validate([
            'institution'   => 'required|string|max:150',
            'degree'        => 'nullable|string|max:100',
            'field_of_study'=> 'nullable|string|max:100',
            'start_year'    => 'required|digits:4|integer',
            'end_year'      => 'nullable|digits:4|integer|gte:start_year',
            'is_current'    => 'nullable|boolean',
            'description'   => 'nullable|string|max:500',
        ]);
        auth()->user()->educations()->create($request->only([
            'institution', 'degree', 'field_of_study', 'start_year', 'end_year', 'description',
        ]) + ['is_current' => $request->boolean('is_current')]);
        return back()->with('success', 'Education added.');
    }

    public function destroyEducation(UserEducation $education)
    {
        abort_if($education->user_id !== auth()->id(), 403);
        $education->delete();
        return back()->with('success', 'Education removed.');
    }

    /* ── Experience ── */
    public function storeExperience(Request $request)
    {
        $request->validate([
            'company'         => 'required|string|max:150',
            'position'        => 'required|string|max:100',
            'employment_type' => 'nullable|string|max:50',
            'location'        => 'nullable|string|max:100',
            'start_date'      => 'required|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'is_current'      => 'nullable|boolean',
            'description'     => 'nullable|string|max:800',
        ]);
        auth()->user()->experiences()->create($request->only([
            'company', 'position', 'employment_type', 'location', 'start_date', 'end_date', 'description',
        ]) + ['is_current' => $request->boolean('is_current')]);
        return back()->with('success', 'Experience added.');
    }

    public function destroyExperience(UserExperience $experience)
    {
        abort_if($experience->user_id !== auth()->id(), 403);
        $experience->delete();
        return back()->with('success', 'Experience removed.');
    }
}
