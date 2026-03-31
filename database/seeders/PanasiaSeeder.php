<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PanasiaSeeder extends Seeder
{
    public function run(): void
    {
        // ── helpers ──────────────────────────────────────────────────────────
        $t = fn(string $en, string $ar) => json_encode(['en' => $en, 'ar' => $ar], JSON_UNESCAPED_UNICODE);
        $now = now();

        // ── clear existing data for these groups ──────────────────────────────
        $groups = ['stats','about_c','markets','commodities','why_cards',
                   'entities','growth','history','values','operations',
                   'mission','org_parent','partners',
                   'services_caps','services_process','contacts_info','offices',
                   'socials',
                   'home_stats','about_stats','home_entities','about_entities','home_growth',
                   'inv_pillars','svc_commodities',
                   'ops_table','ops_regions','ops_routes',
                   'ref_products','ups_segments','fr_steps','geo_countries',
                   'log_hubs','log_corridors'];
        DB::table('main')->whereIn('group', $groups)->delete();

        // ════════════════════════════════════════════════════════════════════
        // GROUP: home_stats  (identity strip on home page — 4 items)
        // options = numeric value (string); title = label
        // ════════════════════════════════════════════════════════════════════
        $homeStatsData = [
            ['324,782', 'MT Shipped (2023)'],
            ['784,963', 'MT Shipped (2024)'],
            ['11',      'Countries of Operation'],
            ['3',       'Legal Entities in UAE'],
        ];
        foreach ($homeStatsData as $i => [$opts, $en]) {
            DB::table('main')->insert([
                'group'      => 'home_stats',
                'title'      => $t($en, $en),
                'options'    => $opts,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: about_stats  (mission sidebar on about page — 3 items)
        // options = display value (string, e.g. "324K"); title = label
        // ════════════════════════════════════════════════════════════════════
        $aboutStatsData = [
            ['324K',  'MT Shipped (2023)'],
            ['784K',  'MT Shipped (2024)'],
            ['1.7M',  'MT Target (2025)'],
        ];
        foreach ($aboutStatsData as $i => [$opts, $en]) {
            DB::table('main')->insert([
                'group'      => 'about_stats',
                'title'      => $t($en, $en),
                'options'    => $opts,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: about_c  (identity statement on home page)
        // title = big statement (shown as headline); short_content = body paragraph
        // ════════════════════════════════════════════════════════════════════
        DB::table('main')->insert([
            'group'         => 'about_c',
            'title'         => $t(
                "Independent.\nFast-Growing.\nReliable.",
                "Independent.\nFast-Growing.\nReliable."
            ),
            'short_content' => $t(
                "Panasia Group is a private commodity trading company holding a leading position in Central Asia and the Caspian Region, with a robust presence in European markets. We export petroleum products, coal, and natural gas — connecting the world's most resource-rich territories with global demand.",
                "Panasia Group is a private commodity trading company holding a leading position in Central Asia and the Caspian Region, with a robust presence in European markets. We export petroleum products, coal, and natural gas — connecting the world's most resource-rich territories with global demand."
            ),
            'status'     => true,
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ════════════════════════════════════════════════════════════════════
        // GROUP: home_entities  (entity list on home page identity section)
        // GROUP: about_entities (entity cards on about page org chart)
        // title = entity name; short_content = description; options = badge label
        // ════════════════════════════════════════════════════════════════════
        $entitiesData = [
            [
                'Panasia Energy DMCC',
                'بناسيا إنرجي DMCC',
                'Manages the export of petroleum products and crude oil across Central Asian and Caspian routes, from origination through to final delivery.',
                'يدير تصدير المنتجات النفطية والنفط الخام عبر مسارات آسيا الوسطى وبحر قزوين، من المصدر حتى التسليم النهائي.',
                'Oil & Petroleum',
            ],
            [
                'Panasia Gas Trading LLC',
                'بناسيا غاز تريدنج LLC',
                'Handles natural gas and LNG procurement, trading, and supply chain logistics — connecting Central Asian gas producers to European buyers.',
                'يتولى شراء الغاز الطبيعي والغاز الطبيعي المسال وتداوله ولوجستيات سلسلة الإمداد، رابطاً منتجي الغاز في آسيا الوسطى بالمشترين الأوروبيين.',
                'Natural Gas & LNG',
            ],
            [
                'Panasia Investment LLC',
                'بناسيا إنفستمنت LLC',
                'A joint venture with Traxys North America LLC, focused on structured commodity investments and strategic market access across the region.',
                'مشروع مشترك مع شركة Traxys North America LLC، يركز على الاستثمارات السلعية المنظمة والوصول الاستراتيجي للأسواق في المنطقة.',
                'JV · Traxys North America',
            ],
        ];
        foreach (['home_entities', 'about_entities'] as $entGroup) {
            foreach ($entitiesData as $i => [$titleEn, $titleAr, $descEn, $descAr, $badge]) {
                DB::table('main')->insert([
                    'group'         => $entGroup,
                    'title'         => $t($titleEn, $titleAr),
                    'short_content' => $t($descEn, $descAr),
                    'options'       => $badge,
                    'status'        => true,
                    'sort_order'    => $i + 1,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ]);
            }
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: home_growth  (shipment volume data — home page only)
        // title = year label; options = volume string; short_content = badge (×growth)
        // ════════════════════════════════════════════════════════════════════
        $growthData = [
            ['2023', '2023', '324,782', 'Base Year',    'السنة الأساسية'],
            ['2024', '2024', '784,963', '↑ 2.4×',       '↑ 2.4×'],
            ['2025 (est.)', '2025 (تقدير)', '1,705,600', '↑ 2.2×', '↑ 2.2×'],
        ];
        foreach ($growthData as $i => [$yearEn, $yearAr, $volume, $badgeEn, $badgeAr]) {
            DB::table('main')->insert([
                'group'         => 'home_growth',
                'title'         => $t($yearEn, $yearAr),
                'options'       => $volume,
                'short_content' => $t($badgeEn, $badgeAr),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: markets  (3 regional markets — home page)
        // title = region name; short_content = description; options2 = CSV country list
        // ════════════════════════════════════════════════════════════════════
        $marketsData = [
            [
                'Central Asia',
                'آسيا الوسطى',
                'Our home market. We hold a leading trading position across the Central Asian corridor, leveraging deep-rooted partnerships, local expertise, and decades of operational experience.',
                'سوقنا الرئيسي. نحتل مكانة تجارية رائدة عبر الممر الآسيوي الأوسط، مستفيدين من شراكات راسخة وخبرات محلية وعقود من التجربة التشغيلية.',
                'Kazakhstan,Uzbekistan,Turkmenistan,Kyrgyzstan',
            ],
            [
                'Caspian Region',
                'منطقة بحر قزوين',
                'One of the world\'s most critical energy hubs. Panasia Group operates at the heart of this region, managing complex cross-border trade flows in oil, gas, and petrochemicals.',
                'واحدة من أهم مراكز الطاقة في العالم. تعمل مجموعة باناسيا في قلب هذه المنطقة، وتدير تدفقات تجارية معقدة عابرة للحدود في النفط والغاز والبتروكيماويات.',
                'Azerbaijan,Turkmenistan,Georgia,Romania',
            ],
            [
                'European Markets',
                'الأسواق الأوروبية',
                'Our robust European presence enables Panasia Group to channel commodity flows from the East into one of the world\'s largest and most demanding consumer markets.',
                'يمكّن حضورنا الأوروبي القوي مجموعة باناسيا من توجيه تدفقات السلع من الشرق إلى أحد أكبر أسواق المستهلكين في العالم وأكثرها طلباً.',
                'Germany,Netherlands,Poland,Turkey',
            ],
        ];
        foreach ($marketsData as $i => [$titleEn, $titleAr, $descEn, $descAr, $countries]) {
            DB::table('main')->insert([
                'group'         => 'markets',
                'title'         => $t($titleEn, $titleAr),
                'short_content' => $t($descEn, $descAr),
                'options2'      => $countries,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: commodities  (traded commodity types — home page)
        // title = commodity name; short_content = description
        // ════════════════════════════════════════════════════════════════════
        $commoditiesData = [
            [
                'Crude Oil',
                'النفط الخام',
                'Physical crude oil trading across Caspian and Central Asian export routes including pipeline and seaborne logistics.',
                'تداول النفط الخام المادي عبر مسارات التصدير القزوينية وآسيا الوسطى بما فيها خطوط الأنابيب والشحن البحري.',
            ],
            [
                'Natural Gas & LNG',
                'الغاز الطبيعي والغاز الطبيعي المسال',
                'Procurement, trading, and supply chain solutions connecting Central Asian producers to European buyers.',
                'حلول الشراء والتداول وسلسلة التوريد التي تربط منتجي آسيا الوسطى بالمشترين الأوروبيين.',
            ],
            [
                'Petroleum Products',
                'المنتجات النفطية',
                'Refined products including diesel, gasoline, jet fuel, and lubricants with a focus on cross-border delivery reliability.',
                'المنتجات المكررة بما فيها الديزل والبنزين ووقود الطيران والزيوت، مع التركيز على موثوقية التسليم عبر الحدود.',
            ],
            [
                'Coal',
                'الفحم',
                'Thermal and coking coal export operations from Kazakhstan and Central Asian producers to global markets.',
                'عمليات تصدير الفحم الحراري وفحم الكوك من كازاخستان ومنتجي آسيا الوسطى إلى الأسواق العالمية.',
            ],
            [
                'Metals & Minerals',
                'المعادن والمواد المعدنية',
                'Ferrous and non-ferrous metals, rare earth elements, and industrial minerals mined across the region.',
                'المعادن الحديدية وغير الحديدية وعناصر الأرض النادرة والمعادن الصناعية المستخرجة عبر المنطقة.',
            ],
            [
                'Petrochemicals',
                'البتروكيماويات',
                'Chemical feedstocks, polymers, and specialty petrochemicals sourced directly from Caspian basin refineries.',
                'المواد الأولية الكيميائية والبوليمرات والبتروكيماويات المتخصصة المصادَرة مباشرة من مصافي حوض قزوين.',
            ],
        ];
        foreach ($commoditiesData as $i => [$titleEn, $titleAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'commodities',
                'title'         => $t($titleEn, $titleAr),
                'short_content' => $t($descEn, $descAr),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: why_cards  (why Panasia — home page)
        // title = card heading; short_content = description
        // ════════════════════════════════════════════════════════════════════
        $whyData = [
            [
                'Unmatched Regional Expertise',
                'خبرة إقليمية لا مثيل لها',
                'Decades of immersive operations across Central Asia and the Caspian Region provide local knowledge, regulatory fluency, and network depth that no newcomer can replicate.',
                'تمنحنا عقود من العمليات المكثفة في آسيا الوسطى ومنطقة بحر قزوين معرفة محلية وإلمامًا تنظيميًا وعمقًا في الشبكات لا يستطيع أي وافد جديد تكراره.',
            ],
            [
                'End-to-End Trade Management',
                'إدارة التجارة من الألف إلى الياء',
                'From sourcing and contract negotiation to logistics, customs clearance, and final delivery — we manage the entire supply chain, eliminating friction at every stage.',
                'من التوريد والتفاوض على العقود إلى اللوجستيات والتخليص الجمركي والتسليم النهائي — ندير سلسلة التوريد بأكملها، مزيلين الاحتكاك في كل مرحلة.',
            ],
            [
                'European Market Access',
                'الوصول إلى الأسواق الأوروبية',
                'Our robust European presence serves as the critical bridge between resource-rich Central Asia and the world\'s most demanding commodity consumers, ensuring competitive pricing.',
                'يُشكّل حضورنا الأوروبي القوي الجسر الحيوي بين آسيا الوسطى الغنية بالموارد وأكثر مستهلكي السلع الأساسية مطالبةً في العالم، مما يضمن أسعارًا تنافسية.',
            ],
            [
                'Trusted Partner Network',
                'شبكة شركاء موثوقين',
                'Built over 15+ years, our network of state enterprises, private producers, refineries, and distributors across 5 regions ensures priority access competitors cannot match.',
                'شبكتنا المبنية على مدى 15+ عامًا من الشركات الحكومية والمنتجين الخاصين والمصافي والموزعين في 5 مناطق تضمن وصولًا أولويًا لا يستطيع المنافسون مجاراته.',
            ],
        ];
        foreach ($whyData as $i => [$titleEn, $titleAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'why_cards',
                'title'         => $t($titleEn, $titleAr),
                'short_content' => $t($descEn, $descAr),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: history  (about page timeline)
        // title = event name; content = description; options = year
        // ════════════════════════════════════════════════════════════════════
        $historyData = [
            [
                '2010', 'Founded in Dubai', 'التأسيس في دبي',
                'Panasia Group established in the UAE with a focused mandate: build the most reliable commodity trading network across Central Asia.',
                'تأسست مجموعة باناسيا في الإمارات بهدف محدد: بناء أموثق شبكة لتجارة السلع في آسيا الوسطى.',
            ],
            [
                '2013', 'Caspian Expansion', 'التوسع في بحر قزوين',
                'Established key partnerships with state producers and private refineries across Azerbaijan and Turkmenistan, entering the Caspian energy market.',
                'أقامت شراكات رئيسية مع منتجين حكوميين ومصافٍ خاصة في أذربيجان وتركمانستان، لتدخل سوق الطاقة في بحر قزوين.',
            ],
            [
                '2017', 'European Operations', 'العمليات الأوروبية',
                'Launch of European market desk, bridging Central Asian commodity supply with European industrial and energy demand through Romania and Germany.',
                'إطلاق مكتب الأسواق الأوروبية، واصلًا إمدادات سلع آسيا الوسطى بالطلب الأوروبي الصناعي والطاقوي عبر رومانيا وألمانيا.',
            ],
            [
                '2021', 'Traxys JV Formed', 'تأسيس المشروع المشترك مع Traxys',
                'Panasia Investment LLC formed as a joint venture with Traxys North America LLC, expanding structured commodity investment capabilities.',
                'تأسست شركة Panasia Investment LLC كمشروع مشترك مع Traxys North America LLC، موسّعةً قدرات الاستثمار السلعي المنظّم.',
            ],
            [
                '2024', '2.4× Volume Growth', 'نمو الحجم 2.4×',
                'Panasia Group ships 784,963 metric tons — a 2.4× increase over 2023, cementing market leadership across all core trading corridors.',
                'شحنت مجموعة باناسيا 784,963 طن متري — بزيادة 2.4× عن 2023، مرسّخةً ريادتها في السوق عبر جميع ممرات التجارة الأساسية.',
            ],
        ];
        foreach ($historyData as $i => [$year, $titleEn, $titleAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'      => 'history',
                'title'      => $t($titleEn, $titleAr),
                'content'    => $t($descEn, $descAr),
                'options'    => $year,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: values  (about page core values)
        // title = value name; short_content = description; options = category label
        // ════════════════════════════════════════════════════════════════════
        $valuesData = [
            [
                'Contractual Reliability', 'الموثوقية التعاقدية', 'Integrity', 'النزاهة',
                'Every commitment we make is kept. Our 15+ year track record of 100% contract fulfilment is the foundation of every relationship we build.',
                'كل التزام نقطعه نفي به. سجلنا الحافل لأكثر من 15 عامًا بنسبة تنفيذ عقود 100% هو أساس كل علاقة نبنيها.',
            ],
            [
                'Deep Regional Knowledge', 'المعرفة الإقليمية العميقة', 'Expertise', 'الخبرة',
                'Decades of immersive operations give us unparalleled insight into Central Asian market dynamics, regulatory environments, and cultural business practices.',
                'تمنحنا عقود من العمليات المكثفة فهمًا لا مثيل له لديناميكيات سوق آسيا الوسطى والبيئات التنظيمية وممارسات الأعمال الثقافية.',
            ],
            [
                'End-to-End Capability', 'القدرة الشاملة', 'Scale', 'الحجم',
                'From procurement and contract negotiation through logistics, customs, and final delivery — we manage the entire supply chain at scale.',
                'من المشتريات والتفاوض على العقود عبر اللوجستيات والجمارك والتسليم النهائي — ندير سلسلة التوريد بأكملها على نطاق واسع.',
            ],
            [
                'Global Network', 'الشبكة العالمية', 'Reach', 'الانتشار',
                'Our network spans 7 countries and connects the resource-rich East with the demand-driven West with efficiency and speed.',
                'تمتد شبكتنا عبر 7 دول وتصل الشرق الغني بالموارد بالغرب المدفوع بالطلب بكفاءة وسرعة.',
            ],
        ];
        foreach ($valuesData as $i => [$titleEn, $titleAr, $optEn, $optAr, $descEn, $descAr]) {
            DB::table('main')->insert([
                'group'         => 'values',
                'title'         => $t($titleEn, $titleAr),
                'short_content' => $t($descEn, $descAr),
                'options'       => $optEn,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: operations  (country "floating text" on about page)
        // title = country name
        // ════════════════════════════════════════════════════════════════════
        $opsData = [
            ['Kazakhstan',    'كازاخستان'],
            ['Uzbekistan',    'أوزبكستان'],
            ['Azerbaijan',    'أذربيجان'],
            ['Kyrgyzstan',    'قيرغيزستان'],
            ['Turkmenistan',  'تركمانستان'],
            ['Georgia',       'جورجيا'],
            ['Romania',       'رومانيا'],
            ['Greece',        'اليونان'],
            ['Turkey',        'تركيا'],
        ];
        foreach ($opsData as $i => [$en, $ar]) {
            DB::table('main')->insert([
                'group'      => 'operations',
                'title'      => $t($en, $ar),
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: mission  (about page — single mission statement record)
        // title = short heading; content = full mission body
        // ════════════════════════════════════════════════════════════════════
        DB::table('main')->insert([
            'group'      => 'mission',
            'title'      => $t(
                'Integrating Central Asian energy resources with European and global markets.',
                'Integrating Central Asian energy resources with European and global markets.'
            ),
            'content'    => $t(
                'Our mission is to integrate Central Asian energy resources with European and global markets by developing reliable trading flows, investing in upstream and downstream assets, and building long-term infrastructure partnerships. We aim to create sustainable, transparent and efficient energy supply chains connecting producers with global demand centers.',
                'Our mission is to integrate Central Asian energy resources with European and global markets by developing reliable trading flows, investing in upstream and downstream assets, and building long-term infrastructure partnerships. We aim to create sustainable, transparent and efficient energy supply chains connecting producers with global demand centers.'
            ),
            'status'     => true,
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ════════════════════════════════════════════════════════════════════
        // GROUP: org_parent  (about page — parent holding card)
        // title = holding name; options = label; options2 = location
        // ════════════════════════════════════════════════════════════════════
        DB::table('main')->insert([
            'group'      => 'org_parent',
            'title'      => $t('PANASIA HOLDING LIMITED', 'PANASIA HOLDING LIMITED'),
            'options'    => 'Parent Holding',
            'options2'   => 'Abu Dhabi, UAE',
            'status'     => true,
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ════════════════════════════════════════════════════════════════════
        // GROUP: partners  (partners page)
        // title = company name; short_content = description; options = country
        // ════════════════════════════════════════════════════════════════════
        $partnersData = [
            ['SOCAR',  'State Oil Company of Azerbaijan',    'Azerbaijan',      'State oil company of Azerbaijan, one of the major energy producers in the Caspian region.'],
            ['ADNOC',  'Abu Dhabi National Oil Company',     'UAE',             'National oil company of Abu Dhabi, a key strategic partner in the Gulf region.'],
            ['Traxys', 'Traxys North America LLC',           'USA',             'Joint venture partner — global commodity trader and structured finance specialist.'],
            ['CNPC',   'China National Petroleum Corp.',     'China',           'China\'s leading integrated energy company and global upstream operator.'],
            ['MRC',    'Mercuria Energy Group',              'Geneva, CH',      'Leading global energy and commodity trading group with expertise in oil and gas.'],
        ];
        foreach ($partnersData as $i => [$abbr, $name, $country, $desc]) {
            DB::table('main')->insert([
                'group'         => 'partners',
                'title'         => $t($name, $name),
                'short_content' => $t($desc, $desc),
                'options'       => $country,
                'alias'         => strtolower(str_replace([' ', '.', ','], ['-', '', ''], $name)),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: services_caps  (services page — capability cards)
        // title = capability name; short_content = description; options = feather icon
        // ════════════════════════════════════════════════════════════════════
        $capsData = [
            ['Commodity Sourcing',     'commodity-sourcing',     'search',      'Direct access to upstream producers across Central Asia — petroleum, gas, coal, and petrochemicals sourced at origin.'],
            ['Contract Negotiation',   'contract-negotiation',   'file-text',   'Experienced trading teams structure favourable offtake agreements with clearly defined terms, pricing benchmarks, and volume commitments.'],
            ['Logistics & Transport',  'logistics-transport',    'truck',       'End-to-end logistics management across pipeline, rail, road, and sea — including vessel chartering and cross-border customs clearance.'],
            ['Quality Control',        'quality-control',        'check-circle','Independent inspection, laboratory analysis, and certification at loading and discharge points ensure product integrity.'],
            ['Trade Finance',          'trade-finance',          'credit-card', 'Structured financing solutions, letters of credit, and payment term management to support smooth, risk-managed transactions.'],
            ['Regulatory Compliance',  'regulatory-compliance',  'shield',      'Full regulatory support across 7+ jurisdictions — sanctions screening, export licensing, and customs documentation handled in-house.'],
        ];
        foreach ($capsData as $i => [$title, $alias, $icon, $desc]) {
            DB::table('main')->insert([
                'group'         => 'services_caps',
                'title'         => $t($title, $title),
                'short_content' => $t($desc, $desc),
                'options'       => $icon,
                'alias'         => $alias,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: services_process  (services page — how we work steps)
        // title = step name; short_content = description; options = step label
        // ════════════════════════════════════════════════════════════════════
        $processData = [
            ['Step 01', 'Deal Origination',       'deal-origination',      'We identify supply and demand opportunities across our network — connecting producers with buyers before opportunities reach the open market.'],
            ['Step 02', 'Due Diligence',           'due-diligence',         'Full counterparty assessment, quality verification, and price benchmarking ensure every deal is structurally sound before commitment.'],
            ['Step 03', 'Contract Execution',      'contract-execution',    'Legal and commercial teams formalize the agreement with clear terms covering pricing, volume, quality specifications, and delivery obligations.'],
            ['Step 04', 'Logistics Coordination',  'logistics-coordination','Our operations team manages the full logistics chain — pipeline nominations, vessel charters, rail allocations, and cross-border customs clearance.'],
            ['Step 05', 'Delivery & Settlement',   'delivery-settlement',   'Final delivery confirmation, quality certificates, and financial settlement executed with precision — every time, on schedule.'],
            ['Step 06', 'Partnership Review',      'partnership-review',    'Post-delivery performance review and continuous relationship management build the trust that turns one-time trades into long-term partnerships.'],
        ];
        foreach ($processData as $i => [$step, $title, $alias, $desc]) {
            DB::table('main')->insert([
                'group'         => 'services_process',
                'title'         => $t($title, $title),
                'short_content' => $t($desc, $desc),
                'options'       => $step,
                'alias'         => $alias,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: contacts_info  (contacts page — info cards)
        // title = value (email/phone); short_content = label; options = href; options2 = icon type
        // ════════════════════════════════════════════════════════════════════
        $contactsInfoData = [
            ['info@panasia-energy.com', 'General Enquiries',   'mailto:info@panasia-energy.com', 'email'],
            ['+971 4 000 0000',         'Phone',               'tel:+97140000000',               'phone'],
            ['Abu Dhabi, UAE',          'Headquarters',        '',                               'location'],
            ['Mon – Fri, 09:00–18:00',  'Business Hours',      '',                               'clock'],
        ];
        foreach ($contactsInfoData as $i => [$val, $label, $href, $iconType]) {
            DB::table('main')->insert([
                'group'         => 'contacts_info',
                'title'         => $t($val, $val),
                'short_content' => $t($label, $label),
                'options'       => $href,
                'options2'      => $iconType,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: offices  (contacts page — office cards)
        // title = office name; short_content = address; options = tag label
        // ════════════════════════════════════════════════════════════════════
        $officesData = [
            ['Headquarters', 'Panasia Group — Abu Dhabi', "Abu Dhabi Global Market (ADGM)\nAl Maryah Island, Abu Dhabi, UAE"],
            ['Trading Desk', 'Panasia Energy DMCC',       "Jumeirah Lakes Towers\nDubai, UAE"],
            ['European Office', 'Panasia Europe',         "Bucharest Business Park\nBucharest, Romania"],
        ];
        foreach ($officesData as $i => [$tag, $name, $addr]) {
            DB::table('main')->insert([
                'group'         => 'offices',
                'title'         => $t($name, $name),
                'short_content' => $t($addr, $addr),
                'options'       => $tag,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: socials  (social media links — header & footer)
        // title = label; options = URL; options2 = icon identifier
        // ════════════════════════════════════════════════════════════════════
        DB::table('main')->insert([
            'group'      => 'socials',
            'title'      => $t('LinkedIn', 'LinkedIn'),
            'options'    => 'https://www.linkedin.com/company/panasia-group',
            'options2'   => 'linkedin',
            'alias'      => 'linkedin',
            'status'     => true,
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ════════════════════════════════════════════════════════════════════
        // GROUP: inv_pillars  (Investment Strategy page — 4 strategic pillars)
        // title = pillar title; short_content = tag (Pillar I…); content = description
        // ════════════════════════════════════════════════════════════════════
        $invPillars = [
            [
                'Upstream Resource Development',
                'Pillar I',
                'The company is forming an international consortium to invest in upstream oil and gas projects, focusing on the development of new resource bases and the integration of production assets into existing trading flows.',
            ],
            [
                'Infrastructure & Downstream Expansion',
                'Pillar II',
                'The strategy includes the development of key logistics and downstream infrastructure to support growing energy flows. This includes a network of up to 200 fuel retail stations, petroleum storage and terminal facilities.',
            ],
            [
                'Sustainable Energy & Responsible Development',
                'Pillar III',
                'Alongside traditional energy investments, the group is committed to expanding into sustainable and low-carbon energy solutions, supporting the global transition toward cleaner energy systems.',
            ],
            [
                'Long-Term Investment Vision',
                'Pillar IV',
                'Our objective is to build a diversified portfolio of energy assets with a target capitalization of up to USD 1 billion, combining upstream production, infrastructure development and trading expertise.',
            ],
        ];
        foreach ($invPillars as $i => [$en_title, $tag, $en_desc]) {
            DB::table('main')->insert([
                'group'         => 'inv_pillars',
                'title'         => $t($en_title, $en_title),
                'short_content' => $t($tag, $tag),
                'content'       => $t($en_desc, $en_desc),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: svc_commodities  (Services page — 6 commodity categories)
        // title = name; short_content = category; content = description
        // ════════════════════════════════════════════════════════════════════
        $svcCommodities = [
            ['Crude Oil', 'Energy', 'Physical crude oil trading across Caspian and Central Asian export routes. We manage the full supply chain including pipeline logistics, tanker operations, and delivery to European refineries.'],
            ['Natural Gas & LNG', 'Energy', 'Natural gas procurement, trading, and supply chain solutions connecting Central Asian and Caspian producers to European and Asian buyers.'],
            ['Petroleum Products', 'Energy', 'Refined products including diesel, gasoline, jet fuel, and lubricants with a focus on cross-border delivery reliability across Central Asia and Europe.'],
            ['Metals & Minerals', 'Metals', 'Ferrous and non-ferrous metals, rare earth elements, and industrial minerals mined and processed across the region, traded into European and Asian industrial markets.'],
            ['Agricultural Products', 'Agricultural', 'Grain, cotton, and soft commodities from Central Asia\'s fertile agricultural basin exported to global markets including MENA, Europe, and South Asia.'],
            ['Petrochemicals', 'Chemicals', 'Chemical feedstocks, polymers, and specialty petrochemicals sourced from refineries and chemical plants across the Caspian basin for industrial manufacturing buyers.'],
        ];
        foreach ($svcCommodities as $i => [$en_title, $cat, $en_desc]) {
            DB::table('main')->insert([
                'group'         => 'svc_commodities',
                'title'         => $t($en_title, $en_title),
                'short_content' => $t($cat, $cat),
                'content'       => $t($en_desc, $en_desc),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: ops_table  (Projects/Operations page — trading operations)
        // title = name; short_content = region; options = commodity; options2 = status
        // ════════════════════════════════════════════════════════════════════
        $opsTable = [
            ['Kazakhstan Energy Export',          'Central Asia → Europe',          'Crude Oil',          'active'],
            ['Caspian Gas Corridor',               'Caspian Region → Turkey',        'Natural Gas',        'active'],
            ['Central Asia Metals Trade',          'Kazakhstan → EU Markets',        'Metals & Minerals',  'active'],
            ['Uzbekistan Grain Export',            'Central Asia → MENA',            'Agricultural',       'active'],
            ['Turkmenistan Petrochemical Supply',  'Caspian → Eastern Europe',       'Petrochemicals',     'active'],
            ['European Petroleum Distribution',   'Netherlands → Germany / Poland', 'Petroleum Products', 'expanding'],
            ['Azerbaijan LNG Trading',             'Caspian Region → Asia',          'LNG',                'expanding'],
        ];
        foreach ($opsTable as $i => [$en_title, $region, $commodity, $status]) {
            DB::table('main')->insert([
                'group'         => 'ops_table',
                'title'         => $t($en_title, $en_title),
                'short_content' => $t($region, $region),
                'options'       => $commodity,
                'options2'      => $status,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: ops_regions  (Projects/Operations page — 3 operating regions)
        // title = name; content = description; short_content = comma-separated countries
        // ════════════════════════════════════════════════════════════════════
        $opsRegions = [
            [
                'Central Asia',
                'Our core market. Deep-rooted partnerships with state producers and private enterprises across Kazakhstan, Uzbekistan, Turkmenistan, Kyrgyzstan, and Tajikistan.',
                'Kazakhstan, Uzbekistan, Turkmenistan, Kyrgyzstan, Tajikistan',
            ],
            [
                'Caspian Region',
                'One of the world\'s most critical energy hubs. We manage complex cross-border trade flows in oil, gas, and petrochemicals across the Caspian Sea basin.',
                'Azerbaijan, Turkmenistan, Kazakhstan, Russia, Iran',
            ],
            [
                'European Markets',
                'A robust European presence channels commodity flows from the East into one of the world\'s largest consumer markets, completing our global trade network.',
                'Germany, Netherlands, Poland, Turkey, + More',
            ],
        ];
        foreach ($opsRegions as $i => [$en_title, $en_desc, $countries]) {
            DB::table('main')->insert([
                'group'         => 'ops_regions',
                'title'         => $t($en_title, $en_title),
                'content'       => $t($en_desc, $en_desc),
                'short_content' => $t($countries, $countries),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: ops_routes  (Projects/Operations page — 4 trade corridors)
        // title = route title; content = description; options = from; options2 = to
        // ════════════════════════════════════════════════════════════════════
        $opsRoutes = [
            ['Trans-Caspian Energy Corridor',       'Central Asia', 'Europe',     'The primary pipeline and rail route connecting Central Asian energy producers with European refineries and distribution hubs via the Caspian Sea crossing.'],
            ['Kazakhstan Metals Export Route',      'Kazakhstan',   'EU Markets', 'A dedicated supply chain for ferrous and non-ferrous metals from Kazakhstan\'s mining regions to European industrial buyers, utilizing rail and multimodal logistics.'],
            ['Caspian–Turkey Gas Transit',          'Caspian',      'Turkey',     'Structured natural gas offtake and transit arrangements connecting Caspian basin producers with Turkey\'s growing energy market and onward to Southern Europe.'],
            ['Central Asian Agricultural Export',  'Uzbekistan',   'MENA',       'A comprehensive agricultural supply chain moving grain, cotton, and soft commodities from Central Asia\'s fertile agricultural basin to the Middle East and North Africa.'],
        ];
        foreach ($opsRoutes as $i => [$en_title, $from, $to, $en_desc]) {
            DB::table('main')->insert([
                'group'      => 'ops_routes',
                'title'      => $t($en_title, $en_title),
                'content'    => $t($en_desc, $en_desc),
                'options'    => $from,
                'options2'   => $to,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: ref_products  (Refinery page — 6 refined products)
        // title = product name; content = description
        // ════════════════════════════════════════════════════════════════════
        $refProducts = [
            ['Gasoline',          'Motor gasoline for automotive use, supplied to regional fuel distribution networks.'],
            ['Diesel Fuel',       'Diesel for commercial vehicles and industrial equipment across Central Asian markets.'],
            ['Base Oils',         'Lubricant base oils for industrial applications and export to international markets.'],
            ['Kerosene',          'Kerosene for heating applications and industrial use in regional markets.'],
            ['Blended Products',  'Custom product blending capabilities to meet specific buyer specifications and market requirements.'],
            ['Regional Supply',   'Direct supply to Uzbekistan and neighbouring markets, supporting short lead times and reliable delivery.'],
        ];
        foreach ($refProducts as $i => [$en_title, $en_desc]) {
            DB::table('main')->insert([
                'group'      => 'ref_products',
                'title'      => $t($en_title, $en_title),
                'content'    => $t($en_desc, $en_desc),
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: ups_segments  (Upstream page — 2 business segments)
        // title = segment title; short_content = tag; content = desc; options = regions
        // ════════════════════════════════════════════════════════════════════
        $upsSegments = [
            [
                'Oil & Gas Resource Development',
                'Upstream',
                'The company is forming an international consortium to invest in upstream oil and gas projects, focusing on the development of new resource bases and integrating production assets into existing trading flows.',
                'Kazakhstan, Turkmenistan, Central Asia',
            ],
            [
                'Infrastructure, Storage & Distribution',
                'Downstream',
                'The company is actively investing in downstream infrastructure including storage, processing and distribution assets to strengthen supply chain reliability and expand market access.',
                'Uzbekistan, Azerbaijan, Georgia, Europe',
            ],
        ];
        foreach ($upsSegments as $i => [$en_title, $tag, $en_desc, $regions]) {
            DB::table('main')->insert([
                'group'         => 'ups_segments',
                'title'         => $t($en_title, $en_title),
                'short_content' => $t($tag, $tag),
                'content'       => $t($en_desc, $en_desc),
                'options'       => $regions,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: fr_steps  (Fuel Retail page — 3 expansion roadmap steps)
        // title = step title; short_content = tag; content = description
        // ════════════════════════════════════════════════════════════════════
        $frSteps = [
            ['Existing Station Network',           'Current Operations', 'Currently operating fuel retail stations across Central Asia, supplying gasoline, diesel and other petroleum products to local markets under the Panasia brand.'],
            ['Refinery & Supply Chain Integration','Integration',        'Directly connecting retail stations to the Chinaz refinery and regional storage facilities for efficient product supply, minimising logistics costs and ensuring reliable delivery.'],
            ['200-Station Network',                'Target',             'Planned expansion to up to 200 fuel retail stations across the Central Asian region, strengthening distribution capabilities and establishing Panasia as a leading regional fuel retailer.'],
        ];
        foreach ($frSteps as $i => [$en_title, $tag, $en_desc]) {
            DB::table('main')->insert([
                'group'         => 'fr_steps',
                'title'         => $t($en_title, $en_title),
                'short_content' => $t($tag, $tag),
                'content'       => $t($en_desc, $en_desc),
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: geo_countries  (Geography page — 11 countries)
        // title = country name; short_content = region; options = city/hub string
        // ════════════════════════════════════════════════════════════════════
        $geoCountries = [
            ['UAE',          'Middle East',  'Abu Dhabi · Dubai'],
            ['Switzerland',  'Europe',       'Geneva'],
            ['Romania',      'Europe',       'Bucharest · Constanța'],
            ['Greece',       'Europe',       'Athens · Thessaloniki'],
            ['Turkey',       'Eurasia',      'Istanbul'],
            ['Georgia',      'Caucasus',     'Tbilisi · Batumi · Poti'],
            ['Azerbaijan',   'Caucasus',     'Baku · Dubendi'],
            ['Turkmenistan', 'Central Asia', 'Ashgabat · Turkmenbashi'],
            ['Uzbekistan',   'Central Asia', 'Tashkent · Chinaz'],
            ['Kyrgyzstan',   'Central Asia', 'Bishkek'],
            ['Kazakhstan',   'Central Asia', 'Almaty · Astana'],
        ];
        foreach ($geoCountries as $i => [$country, $region, $city]) {
            DB::table('main')->insert([
                'group'         => 'geo_countries',
                'title'         => $t($country, $country),
                'short_content' => $t($region, $region),
                'options'       => $city,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: log_hubs  (Logistics page — 6 infrastructure hub cards)
        // title = country; short_content = description; options = region label; options2 = comma-separated ports
        // ════════════════════════════════════════════════════════════════════
        $logHubs = [
            ['Turkmenistan',          'Caspian Sea terminal for transshipment of petroleum products from Turkmenistan to Azerbaijan.',                              'Central Asia', 'Turkmenbashi'],
            ['Azerbaijan',            'Major Caspian hub with storage and terminal handling capacity, bridging Central Asia and the Caucasus.',                     'Caucasus',     'Baku, Dubendi Terminal'],
            ['Georgia',               'Black Sea export hub with multiple port terminals for onward shipping to European markets.',                                  'Caucasus',     'Kulevi, Batumi, Poti'],
            ['Romania',               'European gateway for receiving and redistributing Central Asian energy commodities.',                                         'Europe',       'Black Sea Ports'],
            ['Greece',                'Mediterranean access point supporting supply to Southern European markets.',                                                  'Europe',       'Mediterranean Ports'],
            ['Uzbekistan & Kazakhstan','Inland storage and distribution facilities supporting regional supply operations.',                                          'Central Asia', 'Chinaz, Regional Storage'],
        ];
        foreach ($logHubs as $i => [$country, $desc, $region, $ports]) {
            DB::table('main')->insert([
                'group'         => 'log_hubs',
                'title'         => $t($country, $country),
                'short_content' => $t($desc, $desc),
                'options'       => $region,
                'options2'      => $ports,
                'status'        => true,
                'sort_order'    => $i + 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ]);
        }

        // ════════════════════════════════════════════════════════════════════
        // GROUP: log_corridors  (Logistics page — 3 trade corridor items)
        // title = corridor name; options = corridor label (Corridor I/II/III);
        // options2 = pipe-separated nodes (items in parentheses are transport mode notes)
        // ════════════════════════════════════════════════════════════════════
        $logCorridors = [
            ['Central Asia — Caucasus — Europe', 'Corridor I',   'Turkmenistan|(Caspian Sea)|Azerbaijan|(Railway)|Georgia|(Black Sea)|Europe'],
            ['Kazakhstan — Caspian Corridor',    'Corridor II',  'Kazakhstan|(Caspian Sea)|Azerbaijan|(Railway)|Georgia|(Black Sea)|Europe'],
            ['Europe — Central Asia Supply',     'Corridor III', 'Greece / Romania|(Maritime)|Georgia|(Railway)|Uzbekistan & Central Asia'],
        ];
        foreach ($logCorridors as $i => [$name, $label, $nodes]) {
            DB::table('main')->insert([
                'group'      => 'log_corridors',
                'title'      => $t($name, $name),
                'options'    => $label,
                'options2'   => $nodes,
                'status'     => true,
                'sort_order' => $i + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
