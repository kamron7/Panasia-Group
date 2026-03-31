<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menu')->truncate();

        $now = now();
        $t   = fn(string $en) => json_encode(['en' => $en], JSON_UNESCAPED_UNICODE);

        // ── TOP-LEVEL ITEMS (cat_id = 0) ──────────────────────────────────────
        DB::table('menu')->insert([
            'cat_id' => 0, 'title' => $t('Home'), 'inner_link' => '/',
            'alias' => 'home', 'status' => true, 'sort_order' => 1,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $aboutId = DB::table('menu')->insertGetId([
            'cat_id' => 0, 'title' => $t('About'), 'inner_link' => '/about',
            'alias' => 'about-the-company', 'status' => true, 'sort_order' => 2,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $investId = DB::table('menu')->insertGetId([
            'cat_id' => 0, 'title' => $t('Investment'), 'inner_link' => '/investment-strategy',
            'alias' => 'investment', 'status' => true, 'sort_order' => 3,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $operationsId = DB::table('menu')->insertGetId([
            'cat_id' => 0, 'title' => $t('Operations'), 'inner_link' => '/upstream',
            'alias' => 'operations', 'status' => true, 'sort_order' => 4,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $tradingId = DB::table('menu')->insertGetId([
            'cat_id' => 0, 'title' => $t('Trading'), 'inner_link' => '/services',
            'alias' => 'services', 'status' => true, 'sort_order' => 5,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('menu')->insert([
            'cat_id' => 0, 'title' => $t('Partners'), 'inner_link' => '/partners',
            'alias' => 'partners', 'status' => true, 'sort_order' => 6,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('menu')->insert([
            'cat_id' => 0, 'title' => $t('Contacts'), 'inner_link' => '/contacts',
            'alias' => 'contacts', 'status' => true, 'sort_order' => 7,
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // ── ABOUT sub-items ────────────────────────────────────────────────────
        foreach ([
            [1, 'Company Overview',  '/about',        'about-sub-1'],
            [2, 'Mission & Vision',  '/about#mission','about-sub-2'],
            [3, 'Group Structure',   '/about#structure','about-sub-3'],
            [4, 'Our Team',          '/team',         'team'],
            [5, 'Geography',         '/geography',    'geography'],
        ] as [$sort, $title, $link, $alias]) {
            DB::table('menu')->insert([
                'cat_id' => $aboutId, 'title' => $t($title), 'inner_link' => $link,
                'alias' => $alias, 'status' => true, 'sort_order' => $sort,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ── INVESTMENT sub-items ───────────────────────────────────────────────
        foreach ([
            [1, 'Investment Strategy',    '/investment-strategy', 'investment-strategy'],
            [2, 'Upstream & Downstream',  '/upstream',            'upstream'],
        ] as [$sort, $title, $link, $alias]) {
            DB::table('menu')->insert([
                'cat_id' => $investId, 'title' => $t($title), 'inner_link' => $link,
                'alias' => $alias, 'status' => true, 'sort_order' => $sort,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ── OPERATIONS sub-items ───────────────────────────────────────────────
        foreach ([
            [1, 'Upstream & Downstream',   '/upstream',        'ops-sub-1'],
            [2, 'Refinery & Storage',       '/refinery',        'refinery'],
            [3, 'Fuel Retail Network',      '/fuel-retail',     'fuel-retail'],
            [4, 'Logistics & Terminals',    '/logistics',       'logistics'],
        ] as [$sort, $title, $link, $alias]) {
            DB::table('menu')->insert([
                'cat_id' => $operationsId, 'title' => $t($title), 'inner_link' => $link,
                'alias' => $alias, 'status' => true, 'sort_order' => $sort,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        // ── TRADING sub-items ──────────────────────────────────────────────────
        foreach ([
            [1, 'Energy Trading',          '/services',             'trading-sub-1'],
            [2, 'Risk Management',         '/services#compliance',  'trading-sub-2'],
        ] as [$sort, $title, $link, $alias]) {
            DB::table('menu')->insert([
                'cat_id' => $tradingId, 'title' => $t($title), 'inner_link' => $link,
                'alias' => $alias, 'status' => true, 'sort_order' => $sort,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }
}
