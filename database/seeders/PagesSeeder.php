<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $t = fn(string $en) => json_encode(['en' => $en], JSON_UNESCAPED_UNICODE);
        $now = now();

        DB::table('pages')->delete();

        // ════════════════════════════════════════════════════════════════════
        // All standalone/lone texts used via $p['options_key'] in blade templates.
        // Each row: [ options_key, english_text ]
        // ════════════════════════════════════════════════════════════════════
        $pages = [

            // ─── HOME PAGE ───────────────────────────────────────────────
            ['home_founded_eyebrow',      'Energy. Investment. Growth.'],
            ['our_story',                 'Discover Our Story'],
            ['our_legal_entities',        'Our Legal Entities'],

            // Parallax image break #1
            ['img_energy_infra',          'Energy Infrastructure'],
            ['img_energy_infra_sub',      "Central Asia's energy backbone — pipelines, terminals and transport corridors connecting producers to markets."],

            // Growth section
            ['growth_eyebrow',            'Volume Growth'],
            ['growth_title',              "Scaling <em>With</em> Precision"],
            ['growth_subtitle',           'Year-over-year shipment growth driven by expanding network coverage and deepening producer relationships.'],

            // Markets section
            ['geographic_presence',       'Geographic Presence'],
            ['our_core_markets',          "Our Core <em>Markets</em>"],
            ['markets_desc',              'Connecting Central Asian energy resources with European and global demand through trusted, established trading corridors.'],
            ['markets_countries_num',     '11'],
            ['markets_countries_label',   'Countries'],
            ['markets_regions_num',       '4'],
            ['markets_regions_label',     'Regions'],

            // Parallax image break #2
            ['img_maritime',              'Maritime Logistics'],
            ['img_maritime_sub',          "Caspian Sea and Black Sea routes — the vital waterways linking landlocked energy producers with global shipping lanes."],

            // Commodities section
            ['what_we_trade',             'What We Trade'],
            ['trading_expertise',         'Trading Expertise'],

            // Why Panasia section
            ['our_competitive_edge',      'Our Competitive Edge'],
            ['why_panasia_group',         'Why Panasia Group'],
            ['why_panasia_subtitle',      'Decades of immersive regional experience combined with global market reach and end-to-end supply chain capability.'],

            // Contact section
            ['contact_title_line1',       "Let's Build"],
            ['contact_title_line2',       'Something'],
            ['contact_title_line3',       'Together'],
            ['contact_desc',              'Reach out for partnership inquiries, commodity trading proposals, or investment discussions. Our team responds within 24 hours.'],
            ['contact_email_label',       'Email'],
            ['contact_email_value',       'info@panasia-energy.com'],
            ['contact_phone_label',       'Phone'],
            ['contact_phone_value',       '+971 4 000 0000'],
            ['contact_hq_label',          'Headquarters'],
            ['contact_hq_value',          'Abu Dhabi, UAE'],

            // Contact form labels
            ['form_your_name',            'Your Name'],
            ['form_email_address',        'Email Address'],
            ['form_company_optional',     'Company (optional)'],
            ['form_how_can_we_help',      'How can we help?'],
            ['send_message',              'Send Message'],

            // ─── ABOUT PAGE ──────────────────────────────────────────────
            ['about_eyebrow',             'About Panasia Group'],
            ['about_hero_line2',          'Connecting Energy'],
            ['about_hero_line3',          'Markets'],
            ['about_hero_desc',           'A private commodity trading company with a leading position in Central Asia and the Caspian Region, connecting resource-rich producers with global demand centers.'],

            // Mission stats
            ['our_mission',               'Our Mission'],
            ['mt_shipped_2023',           'MT Shipped, 2023'],
            ['mt_shipped_2024',           'MT Shipped, 2024'],
            ['mt_projected_2025',         'MT Projected, 2025'],

            // Entities section (about page)
            ['legal_structure',           'Legal Structure'],
            ['our_three_entities',        'Our Three Entities'],
            ['entities_subtitle',         'UAE-registered legal entities spanning petroleum trading, gas trading and strategic investment across Central Asia and global markets.'],

            // Operations section
            ['where_we_operate',          'Where We Operate'],
            ['active_countries',          "Active in <em>7+</em> Countries"],
            ['ops_desc',                  'From Kazakhstan to Romania, our operational footprint spans the full Central Asia — Caspian — European energy corridor.'],
            ['explore_partnerships',      'Explore Partnerships'],

            // History section
            ['our_journey',               'Our Journey'],
            ['history_title',             "Built Over<br>Decades"],

            // Values section
            ['what_drives_us',            'What Drives Us'],
            ['our_core_values',           'Our Core Values'],

            // ─── CONTACTS PAGE ───────────────────────────────────────────
            ['contacts_eyebrow',          'Get In Touch'],
            ['contacts_title_line1',      'Connect With'],
            ['contacts_title_line2',      'Our Team'],
            ['contacts_hero_desc',        'Whether you are exploring partnership opportunities, sourcing commodities, or looking to discuss investment — our team is ready to engage.'],
            ['contacts_partnership_title','Partnership & Business Enquiries'],
            ['contacts_partnership_desc', 'For trade partnerships, investment proposals, and long-term supply agreements, please reach out directly to our business development team.'],

            // ─── SERVICES PAGE ───────────────────────────────────────────
            ['services_eyebrow',          'Our Services'],
            ['services_title_line1',      'Full-Service Energy'],
            ['services_title_line2',      'Trading & Logistics'],
            ['services_hero_desc',        'From procurement and sourcing through to logistics, compliance and final delivery — we manage the entire commodity supply chain.'],
            ['services_edge_tag',         'Our Edge'],
            ['services_edge_title',       'Why Choose Panasia?'],
            ['services_edge_desc',        'Decades of regional expertise, an established partner network across 7 countries, and end-to-end capability make us the preferred trading partner in the region.'],
            ['services_how_tag',          'Our Process'],
            ['services_how_title',        'How We Work'],

            // ─── SERVICES PAGE — CTA section ─────────────────────────────
            ['services_cta_tag',          'Start Trading'],
            ['services_cta_title_line1',  'Trade With'],
            ['services_cta_title_line2',  'Confidence.'],
            ['services_cta_desc',         "Whether you're looking to buy, sell, or structure a long-term offtake agreement — Panasia Group has the relationships, expertise, and infrastructure to deliver."],
            ['services_cta_btn',          'Contact Our Trading Desk'],
            ['services_about_btn',        'About Panasia Group'],

            // ─── CONTACTS PAGE — form extras ─────────────────────────────
            ['form_phone_optional',       'Phone (optional)'],
            ['form_subject',              'Subject / Commodity Interest'],

            // ─── PROJECTS PAGE ───────────────────────────────────────────
            ['ops_page_eyebrow',          'Investment Projects'],
            ['ops_page_title_line1',      'Strategic Energy'],
            ['ops_page_title_line2',      'Investments'],

            // Projects – ops list header
            ['ops_list_title',            'Active Operations'],
            ['ops_list_subtitle',         'Ongoing commodity trading operations across our core markets and strategic corridors.'],

            // Projects – regions section
            ['ops_regions_title',         'Three Core<br>Operating Regions'],
            ['ops_regions_desc',          "Panasia Group's operations span the most commodity-rich and strategically significant corridors connecting East and West."],

            // Projects – routes section
            ['ops_routes_tag',            'Infrastructure'],
            ['ops_routes_title',          'Key Trade Corridors'],

            // Projects – CTA
            ['ops_cta_tag',               'Partner With Us'],
            ['ops_cta_title',             'Interested in a<br>Trading Partnership?'],
            ['ops_cta_desc',              "We're always open to strategic conversations with producers, buyers, and institutional partners operating in our core markets."],

            // ─── INVESTMENT STRATEGY PAGE ────────────────────────────────
            ['inv_hero_eyebrow',          'Investment Strategy'],
            ['inv_hero_title1',           'Strategic'],
            ['inv_hero_title2',           'Investment.'],
            ['inv_hero_desc',             'Building a diversified portfolio of energy assets with a target capitalization of up to USD 1 billion — combining upstream production, infrastructure development and trading expertise.'],
            ['inv_intro_quote',           "In response to rapid changes in the global energy market, Panasia Group's strategy in Central Asia focuses on <span>integrating the region's resource base</span> with stable demand in European and international markets."],
            ['inv_intro_body',            "Our investment approach combines upstream resource development, downstream infrastructure expansion, sustainable energy transition, and long-term value creation for partners and investors."],
            ['inv_target_label',          'Target Portfolio Capitalization'],
            ['inv_target_currency',       'USD'],
            ['inv_target_num',            '1B'],
            ['inv_target_sub',            'Diversified energy assets combining upstream production, infrastructure and trading into a single integrated platform.'],
            ['inv_pillars_tag',           'Our Approach'],
            ['inv_pillars_title',         'Four Strategic Pillars'],
            ['inv_cta_tag',               'Partner With Us'],
            ['inv_cta_title',             'Invest in<br>Energy.'],
            ['inv_cta_desc',              'We welcome co-investment partnerships with institutional investors, sovereign funds and strategic industry partners.'],

            // ─── LOGISTICS PAGE ──────────────────────────────────────────
            ['log_hero_eyebrow',          'Infrastructure & Logistics'],
            ['log_hero_title1',           'Storage, Terminals'],
            ['log_hero_title2',           'Transshipment.'],
            ['log_hero_desc',             'Strategic access to transshipment and storage capacities across key energy corridors connecting Central Asia, the Caspian region and Europe.'],
            ['log_intro_quote',           'The group has secured access to strategic transshipment and storage capacities across <span>key energy corridors connecting Central Asia, the Caspian region and Europe.</span>'],
            ['log_intro_body',            'These facilities support efficient logistics, reliable product handling and flexible distribution across international markets. Reserved transshipment capacities are located in major regional hubs across Turkmenistan, Azerbaijan, Georgia and Europe.'],
            ['log_hubs_tag',              'Storage & Terminal Network'],
            ['log_hubs_title',            'Key Infrastructure Hubs'],
            ['log_corridors_tag',         'Supply Routes'],
            ['log_corridors_title',       'Key Transportation<br>Corridors'],
            ['log_cta_tag',               'Work With Us'],
            ['log_cta_title',             'Connect Your<br>Supply Chain.'],
            ['log_cta_desc',              'We offer reliable logistics solutions across the Caspian-Black Sea corridor for energy producers and traders.'],

            // ─── REFINERY PAGE ───────────────────────────────────────────
            ['ref_hero_eyebrow',          'Processing Infrastructure'],
            ['ref_hero_title1',           'Refinery'],
            ['ref_hero_title2',           'Storage.'],
            ['ref_hero_desc',             'Operating a small-scale refinery in Uzbekistan producing gasoline, diesel and base oils — supported by 20,000-tonne fuel storage capacity.'],
            ['ref_intro_quote',           'The company operates a small-scale refinery in <span>Chinaz, Tashkent region, Republic of Uzbekistan</span>, producing key petroleum products.'],
            ['ref_intro_body',            'The facility enables flexible processing of hydrocarbons and supports the supply of refined products to regional markets. In addition to refining capabilities, the company operates fuel storage facilities with a capacity of approximately 20,000 tonnes, designed for gasoline, diesel and kerosene. This infrastructure supports efficient logistics, product blending and reliable supply to trading operations.'],
            ['ref_loc_label',             'Facility Location'],
            ['ref_loc_name',              'Chinaz Refinery'],
            ['ref_loc_city',              'Chinaz, Tashkent Region, Uzbekistan'],
            ['ref_loc_cap_label',         'Storage Capacity'],
            ['ref_loc_cap_val',           '~20,000 t'],
            ['ref_loc_prod_label',        'Products'],
            ['ref_loc_prod_val',          'Gasoline · Diesel · Kerosene'],
            ['ref_loc_status_label',      'Status'],
            ['ref_loc_status_val',        'Operational'],
            ['ref_prod_tag',              'Output'],
            ['ref_prod_title',            'Refined Products'],
            ['ref_exp_tag',               'Growth Plans'],
            ['ref_exp_title',             'Expanding Refining<br>& Storage Capacity'],
            ['ref_exp_desc',              'The group plans to further expand refining and storage capacities, strengthening its downstream infrastructure and supporting the growth of regional energy supply chains. This expansion will integrate with the planned fuel retail network of up to 200 stations across Central Asia.'],
            ['ref_exp_stat1_num',         '20K'],
            ['ref_exp_stat1_lbl',         'Tonnes storage capacity'],
            ['ref_exp_stat2_num',         '3+'],
            ['ref_exp_stat2_lbl',         'Product types produced'],
            ['ref_exp_stat3_num',         'UZB'],
            ['ref_exp_stat3_lbl',         'Uzbekistan — operational base'],
            ['ref_exp_stat4_num',         '200+'],
            ['ref_exp_stat4_lbl',         'Planned fuel stations'],
            ['ref_cta_tag',               'Downstream Assets'],
            ['ref_cta_title',             'Fuel Retail<br>Network.'],
            ['ref_cta_desc',              'See how our refinery integrates with our growing fuel retail network across Central Asia.'],

            // ─── SERVICES PAGE — Commodities section ─────────────────────
            ['svc_comm_tag',              'Our Commodities'],
            ['svc_comm_title',            'Six Core<br>Trading Areas'],
            ['svc_comm_desc',             'Each category represents years of developed relationships, logistics infrastructure, and market intelligence.'],

            // ─── UPSTREAM PAGE ───────────────────────────────────────────
            ['ups_hero_eyebrow',          'Energy Assets'],
            ['ups_hero_title1',           'Upstream'],
            ['ups_hero_title2',           'Downstream'],
            ['ups_hero_title3',           'Assets.'],
            ['ups_hero_desc',             'Strategic investments in oil and gas production assets in Kazakhstan and Turkmenistan, integrated with downstream infrastructure across Central Asia.'],
            ['ups_intro_quote',           'The company focuses on strategic investments in <span>upstream oil and gas projects in Central Asia</span>, with particular emphasis on Kazakhstan and Turkmenistan.'],
            ['ups_intro_body',            "These investments are aimed at developing new resource bases and integrating production into the group's existing international trading flows. In addition to upstream activities, the company is actively investing in downstream infrastructure, including storage, processing and distribution assets, in order to strengthen supply chain reliability and expand market access across regional and global energy markets."],
            ['ups_seg_tag',               'Our Focus Areas'],
            ['ups_seg_title',             'Two Integrated<br>Business Segments'],
            ['ups_cta_tag',               'Learn More'],
            ['ups_cta_title',             'Explore Our<br>Projects.'],
            ['ups_cta_desc',              'Discover our refining, storage and fuel retail operations across Central Asia.'],

            // ─── FUEL RETAIL PAGE ────────────────────────────────────────
            ['fr_hero_eyebrow',           'Downstream Retail'],
            ['fr_hero_title1',            'Fuel Retail'],
            ['fr_hero_title2',            'Network.'],
            ['fr_hero_desc',              'Operating fuel retail stations across Central Asia with plans to expand to a network of up to 200 stations — supplying gasoline, diesel and petroleum products to local markets.'],
            ['fr_intro_quote',            'Panasia Group owns and operates several fuel retail stations across Central Asia, <span>supplying gasoline, diesel and other petroleum products</span> to local markets.'],
            ['fr_intro_body',             "As part of its downstream expansion strategy, the company plans to significantly grow its retail presence by developing a network of up to 200 fuel stations across the region over the coming years. This expansion will strengthen the group's distribution capabilities, enhance market access and support the integration of its refining, storage and trading operations."],
            ['fr_stat1_num',              '200+'],
            ['fr_stat1_lbl',              'Planned stations across Central Asia'],
            ['fr_stat2_lbl',              'Primary expansion market — Uzbekistan and neighbouring countries'],
            ['fr_plan_tag',               'Growth Strategy'],
            ['fr_plan_title',             'Expansion Roadmap'],
            ['fr_cta_tag',                'Investment Opportunity'],
            ['fr_cta_title',              'Join Our<br>Expansion.'],
            ['fr_cta_desc',               'We welcome partnerships for co-development of fuel retail infrastructure across Central Asia.'],

            // ─── PARTNERS PAGE ───────────────────────────────────────────
            ['ptr_hero_eyebrow',          'Strategic Partnerships'],
            ['ptr_hero_title1',           'Our'],
            ['ptr_hero_title2',           'Partners'],
            ['ptr_hero_desc',             'Panasia Group operates through a network of trusted global partners — state energy majors, leading trading houses, and infrastructure operators across Central Asia, the Caspian, and international markets.'],
            ['ptr_section_tag',           'Trusted Counterparties'],
            ['ptr_section_title',         'Strategic Partnership Network'],
            ['ptr_cta_tag',               'Join Our Network'],
            ['ptr_cta_title',             'Become a<br>Partner.'],
            ['ptr_cta_desc',              'We are always open to new partnerships with energy producers, trading houses, logistics operators, and financial institutions.'],
            ['ptr_cta_btn_about',         'About Panasia Group'],

            // ─── TEAM PAGE ───────────────────────────────────────────────
            ['team_hero_eyebrow',         'People & Leadership'],
            ['team_hero_title1',          'Our'],
            ['team_hero_title2',          'Team.'],
            ['team_hero_desc',            "The leadership and professionals behind Panasia Group — experienced energy industry executives connecting Central Asian resources with global markets."],
            ['team_section_tag',          'Leadership'],
            ['team_section_title',        'Meet the Team'],
            ['team_notice_title',         'Team Profiles Coming Soon'],
            ['team_notice_desc',          "Detailed profiles, biographies and photographs of Panasia Group's leadership team will be published shortly."],
            ['team_placeholder_photo',    'Photo coming soon'],
            ['team_placeholder_role',     'Leadership'],
            ['team_placeholder_name',     '— To be announced —'],

            // ─── GEOGRAPHY PAGE ──────────────────────────────────────────
            ['geo_hero_eyebrow',          'Global Footprint'],
            ['geo_hero_title1',           'Our'],
            ['geo_hero_title2',           'Geography.'],
            ['geo_hero_desc',             'Our footprint spans from European countries such as Romania and Greece to the Caucasus and Central Asia — including Georgia, Azerbaijan, Turkmenistan, Uzbekistan, Kyrgyzstan, and Kazakhstan.'],
            ['geo_grid_tag',              'Our Presence'],
            ['geo_grid_title',            '11 Countries'],
            ['geo_fp_tag',                'Geographic Coverage'],
            ['geo_fp_title',              'Spanning Europe,<br>Caucasus &<br>Central Asia'],
            ['geo_fp_body',               'Our footprint spans from European countries such as Romania and Greece to the Caucasus and Central Asia regions, including Georgia, Azerbaijan, Turkmenistan, Uzbekistan, Kyrgyzstan, and Kazakhstan — connecting energy production regions with global demand centres.'],
            ['geo_fp_stat1_num',          '11'],
            ['geo_fp_stat1_lbl',          'Countries in our operational network'],
            ['geo_fp_stat2_num',          '4'],
            ['geo_fp_stat2_lbl',          'Geographic regions covered'],
            ['geo_fp_stat3_num',          '3+'],
            ['geo_fp_stat3_lbl',          'Key logistics corridors'],
            ['geo_map_loading',           'Loading map…'],

            // ─── SHARED BUTTON TEXTS ─────────────────────────────────────
            ['btn_contact_our_team',      'Contact Our Team'],
            ['btn_get_in_touch',          'Get in Touch'],
            ['btn_fuel_retail_network',   'Fuel Retail Network'],
            ['btn_ups_downstream',        'Upstream & Downstream'],
            ['btn_refinery_storage',      'Refinery & Storage'],

            // ─── PROJECTS PAGE — region prefix ───────────────────────────
            ['ops_region_prefix',         'Region'],

            // ─── FUEL RETAIL — stat 2 value ──────────────────────────────
            ['fr_stat2_val',              'Central Asia'],

            // ─── ABOUT PAGE — org chart ──────────────────────────────────
            ['about_ownership_label',     '100% Ownership'],
            ['about_org_parent_label',    'Parent Holding'],
            ['about_org_parent_name',     'PANASIA HOLDING LIMITED'],
            ['about_org_parent_sub',      'Abu Dhabi, UAE'],
            ['about_entity1_name',        'PANASIA ENERGY DMCC'],
            ['about_entity1_loc',         'Dubai, UAE'],
            ['about_entity1_desc',        'International trading of refined petroleum products, fertilizers and petrochemicals, as well as oil and gas equipment supply.'],
            ['about_entity2_name',        'PANASIA GAS TRADING LLC'],
            ['about_entity2_loc',         'Dubai, UAE'],
            ['about_entity2_desc',        'Trading of natural gas, LNG and LPG, base oils and refined petroleum products across regional and international markets.'],
            ['about_entity3_name',        'PANASIA INVESTMENT LLC'],
            ['about_entity3_loc',         'Abu Dhabi, UAE'],
            ['about_entity3_desc',        'Investment arm focused on oil & gas logistics, storage, processing and distribution. Joint venture partner with Traxys North America.'],
        ];

        foreach ($pages as $i => [$key, $text]) {
            DB::table('pages')->insert([
                'title'      => $t($text),
                'options'    => $key,
                'status'     => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
