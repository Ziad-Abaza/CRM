<?php

namespace Database\Seeders;

use App\Models\WhatsAppLeadClick;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CrmLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appName = config('app.name', 'Aegis');
        if ($appName === 'Laravel' || empty($appName)) {
            $appName = 'Aegis';
        }

        $leadsData = [
            // Today's Leads
            [
                'source_page' => '/en',
                'button_location' => 'hero_cta',
                'prefilled_message' => "Hello {$appName} team, I would like to schedule an executive strategy session regarding our enterprise initiatives.",
                'ip_address' => '198.51.100.42',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'floating_widget',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                'ip_address' => '156.204.11.89',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'AE',
                'created_at' => Carbon::now()->subHours(4),
            ],
            [
                'source_page' => '/en/services/enterprise-digital-modernization',
                'button_location' => 'service_detail_sidebar',
                'prefilled_message' => "Hi {$appName} team, I am reviewing Enterprise Digital Modernization and want to schedule a brief consultation.",
                'ip_address' => '203.0.113.19',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'GB',
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'source_page' => '/ar/services/strategic-ma-operational-due-diligence',
                'button_location' => 'service_detail_hero',
                'prefilled_message' => "مرحباً بفريق {$appName}، نود الحصول على استشارة تفصيلية حول الفحص النافي للجهالة التقني لصفقة استحواذ قادمة.",
                'ip_address' => '94.200.34.12',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
                'referrer' => 'https://www.google.com/',
                'country' => 'SA',
                'created_at' => Carbon::now()->subHours(8),
            ],
            [
                'source_page' => '/en#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "Hello {$appName} team, I want to initiate the Operational Growth transformation plan ($7,500/mo).",
                'ip_address' => '192.0.2.77',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subHours(10),
            ],

            // Yesterday's Leads
            [
                'source_page' => '/en/portfolio/fintech-core-migration-vantage-capital',
                'button_location' => 'portfolio_sidebar',
                'prefilled_message' => "Hello, I would like to speak with the architect behind the Fintech Core Migration case study.",
                'ip_address' => '198.51.100.88',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'referrer' => 'https://news.ycombinator.com/',
                'country' => 'US',
                'created_at' => Carbon::yesterday()->setHour(14)->setMinute(30),
            ],
            [
                'source_page' => '/ar#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود مناقشة باقة الاستشارة الاستراتيجية وملاءمتها لاحتياجات مؤسستنا.",
                'ip_address' => '82.102.24.5',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com.sa/',
                'country' => 'SA',
                'created_at' => Carbon::yesterday()->setHour(11)->setMinute(15),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'team_member_card',
                'prefilled_message' => 'Hello, I would like to schedule a strategy discussion with David Sterling (Managing Partner & Head of Strategy).',
                'ip_address' => '198.51.100.104',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/122.0.6261.89 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'CA',
                'created_at' => Carbon::yesterday()->setHour(16)->setMinute(45),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'floating_widget',
                'prefilled_message' => "Hello {$appName}, I would like to schedule an executive strategy session regarding our corporate initiatives.",
                'ip_address' => '203.0.113.88',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36 Edg/122.0.0.0',
                'referrer' => 'https://www.google.com/',
                'country' => 'DE',
                'created_at' => Carbon::yesterday()->setHour(9)->setMinute(20),
            ],

            // 2 Days Ago
            [
                'source_page' => '/en#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "Hello {$appName} team, I would like to schedule an Enterprise Architecture executive consultation ($15,000/mo).",
                'ip_address' => '198.51.100.155',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(2)->setHour(13)->setMinute(10),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'hero_cta',
                'prefilled_message' => "مرحباً بفريق {$appName}، نود حجز موعد استشاري لمراجعة الحوكمة والامتثال التنظيمي للأنظمة المصرفية لدينا.",
                'ip_address' => '156.204.18.33',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'EG',
                'created_at' => Carbon::now()->subDays(2)->setHour(15)->setMinute(50),
            ],
            [
                'source_page' => '/en/portfolio/soc-2-type-ii-accreditation-healthsync',
                'button_location' => 'portfolio_detail_hero',
                'prefilled_message' => "Hi {$appName} team, I am interested in building a solution similar to your case study with HealthSync Diagnostics.",
                'ip_address' => '203.0.113.210',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:123.0) Gecko/20100101 Firefox/123.0',
                'referrer' => 'https://www.google.com/',
                'country' => 'GB',
                'created_at' => Carbon::now()->subDays(2)->setHour(18)->setMinute(25),
            ],

            // 3 Days Ago
            [
                'source_page' => '/en',
                'button_location' => 'services_card',
                'prefilled_message' => "Hello {$appName} Team, I would like to inquire about Enterprise Digital Modernization.",
                'ip_address' => '192.0.2.140',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.bing.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(5),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'team_member_card',
                'prefilled_message' => 'مرحباً، أود حجز جلسة نقاش استراتيجية مع إيلينا روستوفا (شريكة، البنية السحابية والحلول التقنية).',
                'ip_address' => '94.200.45.67',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.google.com.ae/',
                'country' => 'AE',
                'created_at' => Carbon::now()->subDays(3)->setHour(14)->setMinute(40),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'floating_widget',
                'prefilled_message' => "Hello {$appName}, I would like to schedule an executive strategy session regarding our corporate initiatives.",
                'ip_address' => '198.51.100.99',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Safari/605.1.15',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(3)->setHour(17)->setMinute(12),
            ],

            // 4 Days Ago
            [
                'source_page' => '/en/services/regulatory-compliance-risk-governance',
                'button_location' => 'service_detail_hero',
                'prefilled_message' => "Hello {$appName} team, I would like to request a detailed scope and quotation for Regulatory Compliance & Risk Governance.",
                'ip_address' => '203.0.113.73',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'GB',
                'created_at' => Carbon::now()->subDays(4)->setHour(11)->setMinute(30),
            ],
            [
                'source_page' => '/ar/portfolio/global-billing-contract-automation-nexus',
                'button_location' => 'portfolio_sidebar',
                'prefilled_message' => 'مرحباً، أود التواصل مع مهندس الحلول المسؤول عن مشروع أتمتة الفوترة اللوجستية لشركة نكسس.',
                'ip_address' => '82.102.30.14',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com.sa/',
                'country' => 'SA',
                'created_at' => Carbon::now()->subDays(4)->setHour(16)->setMinute(15),
            ],

            // 5 Days Ago
            [
                'source_page' => '/en',
                'button_location' => 'cta_banner',
                'prefilled_message' => "Hello {$appName} team, I would like to schedule an executive strategy session regarding our corporate initiatives.",
                'ip_address' => '198.51.100.61',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(5)->setHour(12)->setMinute(45),
            ],
            [
                'source_page' => '/ar#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود بدء العمل على خطة النمو التشغيلي والتوسع ($7,500/شهرياً).",
                'ip_address' => '156.204.99.12',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.google.com/',
                'country' => 'QA',
                'created_at' => Carbon::now()->subDays(5)->setHour(15)->setMinute(20),
            ],

            // 6 Days Ago
            [
                'source_page' => '/en/services/executive-workflow-automation',
                'button_location' => 'service_detail_sidebar',
                'prefilled_message' => "Hi {$appName} team, I am reviewing Executive Workflow Automation and want to schedule a brief consultation.",
                'ip_address' => '203.0.113.144',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'DE',
                'created_at' => Carbon::now()->subDays(6)->setHour(9)->setMinute(50),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'hero_cta',
                'prefilled_message' => "Hello {$appName} team, I would like to schedule an executive strategy session regarding our enterprise initiatives.",
                'ip_address' => '198.51.100.201',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(6)->setHour(14)->setMinute(10),
            ],

            // 7 Days Ago
            [
                'source_page' => '/en',
                'button_location' => 'floating_widget',
                'prefilled_message' => "Hello {$appName}, I would like to schedule an executive strategy session regarding our corporate initiatives.",
                'ip_address' => '192.0.2.188',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123.0',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(7)->setHour(11)->setMinute(15),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'services_card',
                'prefilled_message' => "مرحباً بفريق {$appName}، نود الاستفسار حول خدمات القيادة التنفيذية المؤقتة والاستشارات الاستراتيجية.",
                'ip_address' => '94.200.55.81',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3 Safari/605.1.15',
                'referrer' => 'https://www.google.com.ae/',
                'country' => 'AE',
                'created_at' => Carbon::now()->subDays(7)->setHour(16)->setMinute(30),
            ],

            // 8-14 Days Ago (Prior Week Trend)
            [
                'source_page' => '/en/portfolio/procurement-portal-modernization-altair',
                'button_location' => 'portfolio_card',
                'prefilled_message' => "Hello {$appName} Team, I am inquiring about your case study: Enterprise Procurement Portal Modernization.",
                'ip_address' => '198.51.100.77',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(8)->setHour(13)->setMinute(20),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'hero_cta',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                'ip_address' => '82.102.15.90',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'SA',
                'created_at' => Carbon::now()->subDays(9)->setHour(10)->setMinute(40),
            ],
            [
                'source_page' => '/en#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "Hello {$appName} team, I would like to engage on the Strategic Advisory monthly retainer plan ($3,500/mo).",
                'ip_address' => '203.0.113.91',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'GB',
                'created_at' => Carbon::now()->subDays(10)->setHour(15)->setMinute(10),
            ],
            [
                'source_page' => '/en/services/enterprise-data-intelligence-analytics',
                'button_location' => 'service_detail_sidebar',
                'prefilled_message' => "Hi {$appName} team, I am reviewing Enterprise Data Intelligence & Predictive Analytics and want to schedule a brief consultation.",
                'ip_address' => '198.51.100.12',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(11)->setHour(14)->setMinute(55),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'floating_widget',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                'ip_address' => '156.204.77.20',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com.eg/',
                'country' => 'EG',
                'created_at' => Carbon::now()->subDays(12)->setHour(12)->setMinute(5),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'hero_cta',
                'prefilled_message' => "Hello {$appName} team, I would like to schedule an executive strategy session regarding our enterprise initiatives.",
                'ip_address' => '192.0.2.95',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(13)->setHour(11)->setMinute(30),
            ],
            [
                'source_page' => '/en',
                'button_location' => 'team_member_card',
                'prefilled_message' => 'Hello, I would like to schedule a strategy discussion with Sophia Morales (Head of Automation & Workflow Engineering).',
                'ip_address' => '203.0.113.160',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'SG',
                'created_at' => Carbon::now()->subDays(14)->setHour(9)->setMinute(40),
            ],

            // 15-30 Days Ago (Historical Context)
            [
                'source_page' => '/en/portfolio/cross-border-regulatory-data-hub-zenith',
                'button_location' => 'portfolio_sidebar',
                'prefilled_message' => 'Hello, I would like to speak with the architect behind the Cross-Border Regulatory Data Governance Hub case study.',
                'ip_address' => '198.51.100.180',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(18)->setHour(16)->setMinute(10),
            ],
            [
                'source_page' => '/ar/services/enterprise-digital-modernization',
                'button_location' => 'service_detail_hero',
                'prefilled_message' => "مرحباً بفريق {$appName}، نود طلب دراسة جدوى وتحديد نطاق العمل لمشروع التحول الرقمي وتحديث الأنظمة.",
                'ip_address' => '82.102.40.88',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.google.com.sa/',
                'country' => 'SA',
                'created_at' => Carbon::now()->subDays(22)->setHour(14)->setMinute(25),
            ],
            [
                'source_page' => '/en#pricing',
                'button_location' => 'pricing_card',
                'prefilled_message' => "Hello {$appName} team, I want to initiate the Operational Growth transformation plan ($7,500/mo).",
                'ip_address' => '192.0.2.220',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'referrer' => 'https://www.linkedin.com/',
                'country' => 'US',
                'created_at' => Carbon::now()->subDays(25)->setHour(10)->setMinute(15),
            ],
            [
                'source_page' => '/ar',
                'button_location' => 'hero_cta',
                'prefilled_message' => "مرحباً بفريق {$appName}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                'ip_address' => '94.200.80.19',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
                'referrer' => 'https://www.google.com/',
                'country' => 'KW',
                'created_at' => Carbon::now()->subDays(28)->setHour(13)->setMinute(45),
            ],
        ];

        // Seed or Update
        foreach ($leadsData as $data) {
            $createdAt = $data['created_at'];
            unset($data['created_at']);

            $lead = WhatsAppLeadClick::updateOrCreate(
                [
                    'source_page' => $data['source_page'],
                    'button_location' => $data['button_location'],
                    'prefilled_message' => $data['prefilled_message'],
                    'ip_address' => $data['ip_address'],
                ],
                $data
            );

            // Set specific historical timestamp
            $lead->created_at = $createdAt;
            $lead->updated_at = $createdAt;
            $lead->saveQuietly();
        }

        // Output Leads Telemetry Summary
        if ($this->command) {
            $totalSeeded = count($leadsData);
            $totalInDb = WhatsAppLeadClick::count();
            $this->command->newLine();
            $this->command->info('====================================================');
            $this->command->info('           CRM LEADS TELEMETRY SEEDED               ');
            $this->command->info('====================================================');
            $this->command->table(
                ['Metric', 'Count'],
                [
                    ['Leads Seeded / Synced', $totalSeeded],
                    ['Total Leads in Database', $totalInDb],
                    ['Today\'s Inquiries', WhatsAppLeadClick::whereDate('created_at', Carbon::today())->count()],
                    ['Last 7 Days Inquiries', WhatsAppLeadClick::where('created_at', '>=', Carbon::now()->subDays(7))->count()],
                    ['Countries Represented', WhatsAppLeadClick::distinct('country')->count('country')],
                ]
            );
            $this->command->newLine();
        }
    }
}
