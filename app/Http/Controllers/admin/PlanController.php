<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    /** All capabilities a plan can grant (key => label). */
    public const FEATURES = [
        'mcq'           => 'MCQ practice tests',
        'basic_ats'     => 'Basic ATS score',
        'advanced_ats'  => 'Advanced ATS report',
        'adaptive'      => 'Adaptive tests',
        'unlimited_mcq' => 'Unlimited MCQ attempts',
    ];

    public function index()
    {
        $plans = Plan::withCount(['subscriptions' => fn($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create', ['features' => self::FEATURES]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        Plan::create($data);

        return redirect()->route('admin.plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', ['plan' => $plan, 'features' => self::FEATURES]);
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($this->validateData($request));

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated.');
    }

    public function destroy(Plan $plan)
    {
        if ($plan->subscriptions()->active()->exists()) {
            return back()->with('error', 'Cannot delete a plan with active subscribers. Deactivate it instead.');
        }
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted.');
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:120',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'billing_interval' => 'required|in:month,year,lifetime',
            'features'         => 'nullable|array',
            'features.*'       => 'string|in:' . implode(',', array_keys(self::FEATURES)),
            'sort_order'       => 'nullable|integer|min:0',
        ]);

        return [
            'name'             => $validated['name'],
            'description'      => $validated['description'] ?? null,
            'price'            => $validated['price'],
            'billing_interval' => $validated['billing_interval'],
            'features'         => $validated['features'] ?? [],
            'is_free'          => $request->boolean('is_free'),
            'is_active'        => $request->boolean('is_active'),
            'sort_order'       => $validated['sort_order'] ?? 0,
        ];
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;
        while (Plan::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
