<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        $t   = fn(string $en) => json_encode(['en' => $en], JSON_UNESCAPED_UNICODE);
        $now = now();

        // ════════════════════════════════════════════════════════════════════
        // PAGES — updateOrInsert so other pages' admin-edited data is untouched
        // ════════════════════════════════════════════════════════════════════
        $pages = [

            // ─── Identity section ────────────────────────────────────────
            ['home_founded_eyebrow',    'Energy. Investment. Growth.'],
            ['our_story',               'Discover Our Story'],
            ['our_legal_entities',      'Our Legal Entities'],

            // ─── Parallax image break #1 ─────────────────────────────────
            ['img_energy_infra',        'Energy Infrastructure'],
            ['img_energy_infra_sub',    "Central Asia's energy backbone — pipelines, terminals and transport corridors connecting producers to markets."],

            // ─── Growth section ──────────────────────────────────────────
            ['growth_eyebrow',          'Volume Growth'],
            ['growth_title',            'Scaling <em>With</em> Precision'],
            ['growth_subtitle',         'Year-over-year shipment growth driven by expanding network coverage and deepening producer relationships.'],

            // ─── Markets section ─────────────────────────────────────────
            ['geographic_presence',     'Geographic Presence'],
            ['our_core_markets',        'Our Core <em>Markets</em>'],
            ['markets_desc',            'Connecting Central Asian energy resources with European and global demand through trusted, established trading corridors.'],
            ['markets_countries_num',   '11'],
            ['markets_countries_label', 'Countries'],
            ['markets_regions_num',     '4'],
            ['markets_regions_label',   'Regions'],

            // ─── Parallax image break #2 ─────────────────────────────────
            ['img_maritime',            'Maritime Logistics'],
            ['img_maritime_sub',        "Caspian Sea and Black Sea routes — the vital waterways linking landlocked energy producers with global shipping lanes."],

            // ─── Commodities section ─────────────────────────────────────
            ['what_we_trade',           'What We Trade'],
            ['trading_expertise',       'Trading Expertise'],

            // ─── Why Panasia section ─────────────────────────────────────
            ['our_competitive_edge',    'Our Competitive Edge'],
            ['why_panasia_group',       'Why Panasia Group'],
            ['why_panasia_subtitle',    'Decades of immersive regional experience combined with global market reach and end-to-end supply chain capability.'],

            // ─── Contact section ─────────────────────────────────────────
            ['contact_title_line1',     "Let's Build"],
            ['contact_title_line2',     'Something'],
            ['contact_title_line3',     'Together'],
            ['contact_desc',            'Reach out for partnership inquiries, commodity trading proposals, or investment discussions. Our team responds within 24 hours.'],
            ['contact_email_label',     'Email'],
            ['contact_email_value',     'info@panasia-energy.com'],
            ['contact_phone_label',     'Phone'],
            ['contact_phone_value',     '+971 4 000 0000'],
            ['contact_hq_label',        'Headquarters'],
            ['contact_hq_value',        'Abu Dhabi, UAE'],

            // ─── Contact form labels ─────────────────────────────────────
            ['form_your_name',          'Your Name'],
            ['form_email_address',      'Email Address'],
            ['form_company_optional',   'Company (optional)'],
            ['form_how_can_we_help',    'How can we help?'],
            ['send_message',            'Send Message'],
        ];

        foreach ($pages as [$key, $en]) {
            DB::table('pages')->updateOrInsert(
                ['options' => $key],
                ['title' => $t($en), 'status' => true, 'updated_at' => $now]
            );
        }

        // ════════════════════════════════════════════════════════════════════
        // MAIN GROUPS — clear only home-specific groups, then reinsert
        // ════════════════════════════════════════════════════════════════════
        $homeGroups = ['home_stats', 'about_c', 'home_entities', 'home_growth', 'markets', 'commodities', 'why_cards'];
        DB::table('main')->whereIn('group', $homeGroups)->delete();

        // ─── home_stats (identity strip — 4 stat boxes) ──────────────────
        $statsData = [
            ['324,782',   'MT Shipped (2023)',          '324,782',   'MT Shipped (2023)'],
            ['784,963',   'MT Shipped (2024)',          '784,963',   'MT Shipped (2024)'],
            ['11',        'Countries of Operation',     '11',        'Countries of Operation'],
            ['3',         'Legal Entities in UAE',      '3',         'Legal Entities in UAE'],
        ];
        foreach ($statsData as $i => [$num, $labelEn, $numAr, $labelAr]) {
            DB::table('main')->insert([
                'group'      => 'home_stats',
                'title'      => json_encode(['en' => $labelEn, 'ar' => $labelAr]),
                'options'    => $num,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ─── about_c (identity statement — 1 row) ────────────────────────
        DB::table('main')->insert([
            'group'         => 'about_c',
            'title'         => json_encode([
                'en' => "Independent.\nFast-Growing.\nReliable.",
                'ar' => "مستقل.\nسريع النمو.\nموثوق.",
            ]),
            'short_content' => json_encode([
                'en' => "Panasia Group is a private commodity trading company holding a leading position in Central Asia and the Caspian Region, with a robust presence in European markets. We export petroleum products, coal, and natural gas — connecting the world's most resource-rich territories with global demand.",
                'ar' => "مجموعة بانآسيا شركة تجارة سلع خاصة تحتل مكانة رائدة في آسيا الوسطى ومنطقة بحر قزوين، مع حضور قوي في الأسواق الأوروبية.",
            ]),
            'status'     => true,
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ─── home_entities (sidebar entity list — 3 rows) ────────────────
        $entitiesData = [
            ['Panasia Energy DMCC',    'بانآسيا للطاقة',        'Oil & Petroleum',          'نفط وبترول'],
            ['Panasia Gas Trading LLC', 'بانآسيا لتجارة الغاز', 'Natural Gas & LNG',         'غاز طبيعي ومسال'],
            ['Panasia Investment LLC',  'بانآسيا للاستثمار',    "JV · Traxys North America", 'مشروع مشترك · تراكسيس'],
        ];
        foreach ($entitiesData as $i => [$nameEn, $nameAr, $subEn, $subAr]) {
            DB::table('main')->insert([
                'group'         => 'home_entities',
                'title'         => json_encode(['en' => $nameEn, 'ar' => $nameAr]),
                'short_content' => json_encode(['en' => $subEn,  'ar' => $subAr]),
                'options'       => $subEn,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ─── home_growth (shipment volume rows — 3 rows) ──────────────────
        $growthData = [
            ['2023',        '2023',         '324,782',  'Foundation Year',  'سنة التأسيس'],
            ['2024',        '2024',         '784,963',  '+142% Growth',     'نمو +142٪'],
            ['2025 (est.)', '2025 (تقدير)', '1,705,600','Target +117%',     'هدف +117٪'],
        ];
        foreach ($growthData as $i => [$yearEn, $yearAr, $volume, $badgeEn, $badgeAr]) {
            DB::table('main')->insert([
                'group'         => 'home_growth',
                'title'         => json_encode(['en' => $yearEn,  'ar' => $yearAr]),
                'options'       => $volume,
                'short_content' => json_encode(['en' => $badgeEn, 'ar' => $badgeAr]),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ─── markets (3 regional markets) ────────────────────────────────
        $marketsData = [
            [
                'Central Asia', 'آسيا الوسطى',
                'CIS',
                'Uzbekistan, Kazakhstan, Kyrgyzstan, Turkmenistan',
                "Panasia's primary operational base, covering petroleum product supply, upstream resource development, and retail fuel distribution across Central Asian republics.",
                "قاعدة العمليات الأساسية لبانآسيا، تشمل توريد المنتجات البترولية وتطوير الموارد الأولية وتوزيع الوقود بالتجزئة عبر جمهوريات آسيا الوسطى.",
            ],
            [
                'Caspian Region', 'منطقة بحر قزوين',
                'Caucasus',
                'Azerbaijan, Georgia',
                'A critical transit corridor linking Central Asian energy production to Black Sea ports and onward to European markets, with key hub infrastructure in Baku and Batumi.',
                'ممر عبور حيوي يربط إنتاج الطاقة في آسيا الوسطى بموانئ البحر الأسود وصولاً إلى الأسواق الأوروبية.',
            ],
            [
                'European Markets', 'الأسواق الأوروبية',
                'Europe',
                'Romania, Greece, Switzerland',
                'A robust European presence enables Panasia Group to channel commodity flows from the East into one of the world\'s largest and most demanding consumer markets.',
                'الحضور الأوروبي القوي يمكّن مجموعة بانآسيا من توجيه تدفقات السلع من الشرق إلى أحد أكبر أسواق المستهلكين في العالم.',
            ],
        ];
        foreach ($marketsData as $i => [$titleEn, $titleAr, $region, $countries, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'markets',
                'title'         => json_encode(['en' => $titleEn, 'ar' => $titleAr]),
                'options'       => $region,
                'options2'      => $countries,
                'short_content' => json_encode(['en' => $descEn,  'ar' => $descAr]),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ─── commodities (6 traded commodity cards) ───────────────────────
        $commoditiesData = [
            ['Crude Oil',           'النفط الخام',        'Crude oil sourced from Caspian basin producers, traded into European refineries and global spot markets.',                         'نفط خام من منتجي حوض قزوين يُتداول في مصافي أوروبية وأسواق فورية عالمية.'],
            ['Natural Gas & LNG',   'الغاز الطبيعي',      'Natural gas and LNG from Central Asian fields, with established supply routes to European import terminals.',                       'غاز طبيعي ومسال من حقول آسيا الوسطى، مع مسارات توريد راسخة إلى محطات الاستيراد الأوروبية.'],
            ['Petroleum Products',  'المنتجات البترولية', 'Gasoline, diesel, jet fuel, and fuel oil from Uzbekistan\'s Chinaz refinery and third-party regional sources.',                    'بنزين وديزل ووقود طائرات وزيت وقود من مصفاة شيناز في أوزبكستان ومصادر إقليمية أخرى.'],
            ['Coal',                'الفحم',              'Thermal and coking coal export operations from Kazakhstan and Central Asian producers to global markets.',                          'عمليات تصدير الفحم الحراري والكوك من كازاخستان ومنتجي آسيا الوسطى إلى الأسواق العالمية.'],
            ['Metals & Minerals',   'المعادن والمواد',    'Ferrous and non-ferrous metals, rare earth elements, and industrial minerals traded into European and Asian industrial markets.',   'معادن حديدية وغير حديدية وعناصر أرضية نادرة ومعادن صناعية تُتداول في أسواق صناعية أوروبية وآسيوية.'],
            ['Petrochemicals',      'البتروكيماويات',      'Petrochemical intermediates and finished products routed through established trading networks to end-use industrial buyers.',       'مواد بتروكيماوية وسيطة ومنتجات نهائية تُوجَّه عبر شبكات تجارية راسخة إلى المشترين الصناعيين.'],
        ];
        foreach ($commoditiesData as $i => [$nameEn, $nameAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'commodities',
                'title'         => json_encode(['en' => $nameEn, 'ar' => $nameAr]),
                'short_content' => json_encode(['en' => $descEn, 'ar' => $descAr]),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ─── why_cards (4 "Why Panasia" alternating items) ───────────────
        $whyData = [
            [
                'Unmatched Regional Expertise', 'خبرة إقليمية لا مثيل لها',
                'Over a decade of on-the-ground experience across Central Asia and the Caspian Region, with established relationships at every level of the energy supply chain — from upstream producers to end consumers.',
                'أكثر من عقد من الخبرة الميدانية في آسيا الوسطى ومنطقة قزوين، مع علاقات راسخة على كل مستوى من مستويات سلسلة إمدادات الطاقة.',
            ],
            [
                'End-to-End Trade Management', 'إدارة التجارة من البداية إلى النهاية',
                'Full-service commodity trading from origination and logistics to finance and delivery — eliminating fragmentation, reducing costs, and ensuring on-time performance at every stage.',
                'تجارة سلع متكاملة من التوريد والخدمات اللوجستية إلى التمويل والتسليم، مما يقضي على التفتت ويخفض التكاليف ويضمن الأداء في الوقت المحدد.',
            ],
            [
                'European Market Access', 'الوصول إلى الأسواق الأوروبية',
                'Established trading relationships and logistics infrastructure connecting Central Asian energy supply directly with European demand — including Romania, Greece, and Switzerland as key gateway markets.',
                'علاقات تجارية راسخة وبنية تحتية لوجستية تربط إمدادات الطاقة في آسيا الوسطى مباشرةً بالطلب الأوروبي.',
            ],
            [
                'Trusted Partner Network', 'شبكة شركاء موثوقة',
                'A carefully built network of producers, traders, logistics providers, and financial institutions across 11 countries — enabling rapid deal execution and scalable commodity flows.',
                'شبكة من المنتجين والتجار ومزودي الخدمات اللوجستية والمؤسسات المالية في 11 دولة، تتيح تنفيذ الصفقات بسرعة وتدفقات سلع قابلة للتوسع.',
            ],
        ];
        foreach ($whyData as $i => [$titleEn, $titleAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'why_cards',
                'title'         => json_encode(['en' => $titleEn, 'ar' => $titleAr]),
                'short_content' => json_encode(['en' => $descEn,  'ar' => $descAr]),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }
    }
}
