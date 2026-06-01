<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(['slug' => 'free'], [
            'name'             => 'Free',
            'description'      => 'Get started with MCQ practice tests and a basic ATS resume check.',
            'price'            => 0,
            'billing_interval' => 'lifetime',
            'features'         => ['mcq', 'basic_ats'],
            'is_free'          => true,
            'is_active'        => true,
            'sort_order'       => 1,
        ]);

        Plan::updateOrCreate(['slug' => 'pro-monthly'], [
            'name'             => 'Pro',
            'description'      => 'Unlock adaptive tests, the full ATS report, unlimited practice and every future Pro feature.',
            'price'            => 99,
            'billing_interval' => 'month',
            'features'         => ['mcq', 'basic_ats', 'advanced_ats', 'adaptive', 'unlimited_mcq'],
            'is_free'          => false,
            'is_active'        => true,
            'sort_order'       => 2,
        ]);
    }
}
