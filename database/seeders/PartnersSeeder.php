<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnersSeeder extends Seeder
{
    public function run(): void
    {
        $t   = fn(string $en, string $ar) => json_encode(['en' => $en, 'ar' => $ar], JSON_UNESCAPED_UNICODE);
        $now = now();

        // Remove only partners — all other data stays untouched
        DB::table('main')->where('group', 'partners')->delete();

        // ════════════════════════════════════════════════════════════════════
        // GROUP: partners
        // title        = full company name  (shown on card)
        // short_content= description
        // options      = country / region
        // options2     = abbreviation shown in logo placeholder
        // alias        = url-friendly slug
        // ════════════════════════════════════════════════════════════════════
        $partners = [
            // [abbr,        full name,                                  country,        description]
            ['SOCAR',     'State Oil Company of Azerbaijan',          'Azerbaijan',   'State oil company of Azerbaijan — one of the major energy producers in the Caspian region.'],
            ['ADNOC',     'Abu Dhabi National Oil Company',           'UAE',          'National oil company of Abu Dhabi; a key strategic partner across the Gulf region.'],
            ['KMG',       'KazMunaiGas',                              'Kazakhstan',   'Kazakhstan\'s national oil and gas company and principal upstream operator in the Caspian basin.'],
            ['UNG',       'Uzbekneftegaz',                            'Uzbekistan',   'National oil and gas company of Uzbekistan, overseeing exploration, production, and refining.'],
            ['Traxys',    'Traxys North America LLC',                 'USA',          'Global commodity trader and structured finance specialist — joint venture partner of Panasia.'],
            ['CNPC',      'China National Petroleum Corp.',           'China',        'China\'s leading integrated energy company and one of the world\'s largest upstream operators.'],
            ['Mercuria',  'Mercuria Energy Group',                    'Geneva, CH',   'One of the world\'s largest independent energy and commodity trading groups.'],
            ['Vitol',     'Vitol Group',                              'Rotterdam, NL','World\'s largest independent energy trader, active across oil, gas, power, and renewables.'],
            ['Trafigura', 'Trafigura Group',                          'Singapore',    'Global commodity trading and logistics company with operations across 48 countries.'],
            ['Glencore',  'Glencore PLC',                             'Baar, CH',     'One of the world\'s largest diversified natural resource companies and commodity traders.'],
            ['Lukoil',    'PJSC Lukoil',                              'Russia',       'Major integrated energy company with upstream, refining, and trading operations worldwide.'],
            ['BOTAŞ',     'BOTAŞ Pipeline Corp.',                     'Turkey',       'Turkish national pipeline and natural gas transmission company — key transit corridor partner.'],
        ];

        foreach ($partners as $i => [$abbr, $name, $country, $desc]) {
            DB::table('main')->insert([
                'group'         => 'partners',
                'title'         => $t($name, $name),
                'short_content' => $t($desc, $desc),
                'options'       => $country,
                'options2'      => $abbr,
                'alias'         => strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }
}
