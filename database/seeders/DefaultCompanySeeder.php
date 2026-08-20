<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@apexcorporate.com'],
            [
                'name' => 'Apex Admin',
                'password' => Hash::make('Admin@Secure2026!'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Settings (Grouped & typed)
        $settings = [
            // General / Branding
            ['key' => 'site_name', 'value' => 'Apex Corporate Solutions', 'group' => 'branding', 'type' => 'string', 'is_public' => true],
            ['key' => 'company_tagline', 'value' => 'Enterprise Growth Architecture & Scalable Advisory', 'group' => 'branding', 'type' => 'string', 'is_public' => true],
            ['key' => 'company_logo', 'value' => '/images/branding/logo.svg', 'group' => 'branding', 'type' => 'image', 'is_public' => true],
            ['key' => 'company_favicon', 'value' => '/favicon.ico', 'group' => 'branding', 'type' => 'image', 'is_public' => true],
            ['key' => 'primary_color', 'value' => '#0F172A', 'group' => 'branding', 'type' => 'string', 'is_public' => true],
            ['key' => 'accent_color', 'value' => '#2563EB', 'group' => 'branding', 'type' => 'string', 'is_public' => true],

            // Contact & WhatsApp
            ['key' => 'contact_email', 'value' => 'contact@apexcorporate.com', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+1 (555) 019-2834', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            ['key' => 'contact_address', 'value' => '100 Montgomery Street, Suite 2400, San Francisco, CA 94104', 'group' => 'contact', 'type' => 'text', 'is_public' => true],
            ['key' => 'whatsapp_number', 'value' => '+15550192834', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            ['key' => 'whatsapp_default_message', 'value' => 'Hello Apex Corporate Solutions, I would like to schedule an executive strategy session regarding our corporate initiatives.', 'group' => 'contact', 'type' => 'text', 'is_public' => true],

            // Hero Section
            ['key' => 'hero_badge', 'value' => 'Enterprise Strategic Advisory', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            ['key' => 'hero_title', 'value' => 'Accelerate Enterprise Scale with Predictable Precision', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            ['key' => 'hero_subtitle', 'value' => 'Apex Corporate Solutions partners with institutional leaders to modernize legacy operations, implement high-yield automation, and safeguard governance at scale.', 'group' => 'hero', 'type' => 'text', 'is_public' => true],
            ['key' => 'hero_cta_text', 'value' => 'Consult via WhatsApp', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            ['key' => 'hero_cta_whatsapp_message', 'value' => 'Hi Apex team, I am interested in accelerating our enterprise scaling strategy.', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            ['key' => 'hero_rating_score', 'value' => '4.9/5.0', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            ['key' => 'hero_rating_count', 'value' => '250+ Fortune 1000 & High-Growth Clients', 'group' => 'hero', 'type' => 'string', 'is_public' => true],

            // About Section
            ['key' => 'about_title', 'value' => 'Decades of Institutional Rigor in Modern Markets', 'group' => 'about', 'type' => 'string', 'is_public' => true],
            ['key' => 'about_description', 'value' => 'Founded by veteran operational architects and compliance directors, Apex bridges the gap between ambitious corporate milestones and bulletproof day-to-day execution.', 'group' => 'about', 'type' => 'text', 'is_public' => true],
            ['key' => 'about_bullet_1', 'value' => 'Direct partner-level engagement on every major strategic advisory engagement.', 'group' => 'about', 'type' => 'string', 'is_public' => true],
            ['key' => 'about_bullet_2', 'value' => 'Proprietary digital workflow frameworks generating verified ROI within 90 days.', 'group' => 'about', 'type' => 'string', 'is_public' => true],
            ['key' => 'about_bullet_3', 'value' => 'Uncompromising compliance protocols adhering to SOC2, ISO 27001, and GDPR.', 'group' => 'about', 'type' => 'string', 'is_public' => true],

            // SEO & Social
            ['key' => 'seo_meta_title', 'value' => 'Apex Corporate Solutions | Strategic Enterprise Advisory & Growth', 'group' => 'seo', 'type' => 'string', 'is_public' => true],
            ['key' => 'seo_meta_description', 'value' => 'Leading corporate advisory, digital operations transformation, and strategic scaling for mid-market and enterprise organizations.', 'group' => 'seo', 'type' => 'text', 'is_public' => true],
            ['key' => 'seo_meta_keywords', 'value' => 'corporate advisory, enterprise transformation, business consulting, digital workflow optimization, fintech compliance', 'group' => 'seo', 'type' => 'string', 'is_public' => true],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/apex-corporate-solutions', 'group' => 'social', 'type' => 'string', 'is_public' => true],
            ['key' => 'social_twitter', 'value' => 'https://x.com/apex_corporate', 'group' => 'social', 'type' => 'string', 'is_public' => true],

            // Footer
            ['key' => 'footer_about', 'value' => 'Apex Corporate Solutions delivers high-impact management consulting, digital transformation, and operational resilience to modern enterprises globally.', 'group' => 'footer', 'type' => 'text', 'is_public' => true],
            ['key' => 'footer_copyright', 'value' => '© ' . date('Y') . ' Apex Corporate Solutions LLC. All rights reserved.', 'group' => 'footer', 'type' => 'string', 'is_public' => true],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clear settings cache
        app(SettingService::class)->clearCache();

        // 3. Services (5 services with features, icons, WhatsApp triggers)
        $services = [
            [
                'title' => 'Enterprise Digital Modernization',
                'slug' => 'enterprise-digital-modernization',
                'short_description' => 'Re-architect legacy workflows into secure, high-throughput cloud operations.',
                'description' => 'We audit, re-engineer, and deploy mission-critical infrastructure that reduces operational drag by up to 45%. From ERP modernization to zero-trust pipeline integrations, our team delivers institutional-grade outcomes without business disruption.',
                'icon' => 'server-stack',
                'image' => '/images/services/digital-modernization.jpg',
                'features' => [
                    'Cloud Infrastructure Architecture & Migration',
                    'Legacy ERP & Database Modernization',
                    'Real-Time Systems Telemetry & Observability',
                    'Automated Compliance & Security Safeguards',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Strategic M&A and Operational Due Diligence',
                'slug' => 'strategic-ma-operational-due-diligence',
                'short_description' => 'Deep technical and organizational due diligence for high-stakes capital allocations.',
                'description' => 'Navigate complex acquisitions and strategic mergers with confidence. We provide thorough technology asset audits, operational synergy modeling, and risk assessments for private equity and corporate development leaders.',
                'icon' => 'chart-bar-square',
                'image' => '/images/services/due-diligence.jpg',
                'features' => [
                    'Technology Stack & Codebase Quality Audit',
                    'Operational Run-Rate & Cost Synergies Analysis',
                    'Regulatory & IP Asset Vulnerability Screening',
                    'Post-Acquisition Integration Roadmaps',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Regulatory Compliance & Risk Governance',
                'slug' => 'regulatory-compliance-risk-governance',
                'short_description' => 'End-to-end framework alignment with SOC 2 Type II, ISO 27001, and global financial standards.',
                'description' => 'Transform regulatory compliance from a friction point into a commercial competitive advantage. We architect automated compliance audit pipelines, data governance policies, and board-level risk reporting.',
                'icon' => 'shield-check',
                'image' => '/images/services/compliance.jpg',
                'features' => [
                    'Continuous SOC 2 & ISO Audit Readiness',
                    'Cross-Border Data Sovereignty & GDPR Protocols',
                    'Executive Risk & Incident Response Playbooks',
                    'Vendor Ecosystem Vulnerability Assessments',
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Executive Workflow Automation',
                'slug' => 'executive-workflow-automation',
                'short_description' => 'Custom AI and RPA pipelines engineered to eliminate cross-departmental bottlenecks.',
                'description' => 'Eliminate manual data handoffs between revenue, finance, and legal teams. We design reliable, audited automation pipelines that compress deal approval cycles from days to minutes.',
                'icon' => 'cpu-chip',
                'image' => '/images/services/automation.jpg',
                'features' => [
                    'Automated Billing & Revenue Recognition Pipelines',
                    'Contract Review & Lifecycle Management Automation',
                    'Custom Internal AI Co-Pilots with Strict RBAC',
                    'CRM-to-ERP High-Frequency Synchronization',
                ],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Fractional Corporate Leadership & Advisory',
                'slug' => 'fractional-corporate-leadership-advisory',
                'short_description' => 'Seasoned C-suite operating partners to guide critical inflection points and scale.',
                'description' => 'Deploy seasoned fractional CTOs, COOs, and Chief Compliance Officers to bridge leadership gaps, prepare for major funding rounds, or guide high-stakes corporate turnarounds.',
                'icon' => 'user-group',
                'image' => '/images/services/leadership.jpg',
                'features' => [
                    'Interim CTO & COO Leadership Services',
                    'Board Advisory & Investor Presentation Structuring',
                    'Engineering & Product Organization Restructuring',
                    'Global Expansion & Subsidiary Entity Setup',
                ],
                'order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::updateOrCreate(['slug' => $serviceData['slug']], $serviceData);
        }

        // 4. Pricing Plans (3 tiers: Advisory, Growth, Enterprise)
        $pricingPlans = [
            [
                'name' => 'Strategic Advisory',
                'slug' => 'strategic-advisory',
                'price' => 3500.00,
                'billing_period' => 'month',
                'currency' => 'USD',
                'description' => 'Focused monthly advisory and governance for growing companies requiring strategic oversight.',
                'features' => [
                    'Bi-weekly partner strategic consultation calls',
                    'Architecture & security review sessions',
                    'Quarterly governance & compliance health check',
                    'Priority WhatsApp communication channel',
                    'Advisory response within 24 business hours',
                ],
                'is_featured' => false,
                'whatsapp_message' => 'Hello Apex team, I would like to engage on the Strategic Advisory monthly retainer plan ($3,500/mo).',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Operational Growth',
                'slug' => 'operational-growth',
                'price' => 7500.00,
                'billing_period' => 'month',
                'currency' => 'USD',
                'description' => 'Comprehensive hands-on operational transformation, workflow automation, and infrastructure engineering.',
                'features' => [
                    'Dedicated operational lead & solution architect',
                    'Full workflow automation & system integrations',
                    'Active SOC2 / ISO 27001 readiness engineering',
                    'Weekly sprint syncs & executive progress decks',
                    'Direct WhatsApp channel with 4-hour SLA',
                    'Quarterly partner on-site strategy workshop',
                ],
                'is_featured' => true,
                'whatsapp_message' => 'Hello Apex team, I want to initiate the Operational Growth transformation plan ($7,500/mo).',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise Architecture',
                'slug' => 'enterprise-architecture',
                'price' => 15000.00,
                'billing_period' => 'month',
                'currency' => 'USD',
                'description' => 'Full-spectrum embedded fractional executive team and dedicated engineering squad for multinational scale.',
                'features' => [
                    'Embedded Fractional C-Suite (CTO / COO / CCO)',
                    'Multi-region high-availability cloud architecture',
                    'Continuous M&A due diligence & vendor screening',
                    '24/7 Priority escalation desk & instant WhatsApp hotline',
                    'Tailored board reporting & regulatory liaison',
                    'Custom SLA with guaranteed dedicated capacity',
                ],
                'is_featured' => false,
                'whatsapp_message' => 'Hello Apex team, I would like to schedule an Enterprise Architecture executive consultation ($15,000/mo).',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($pricingPlans as $plan) {
            PricingPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }

        // 5. Portfolio Categories & Case Studies
        $catModernization = PortfolioCategory::updateOrCreate(
            ['slug' => 'digital-modernization'],
            ['name' => 'Digital Modernization', 'order' => 1, 'is_active' => true]
        );

        $catRisk = PortfolioCategory::updateOrCreate(
            ['slug' => 'risk-compliance'],
            ['name' => 'Risk & Compliance', 'order' => 2, 'is_active' => true]
        );

        $catAutomation = PortfolioCategory::updateOrCreate(
            ['slug' => 'operational-automation'],
            ['name' => 'Operational Automation', 'order' => 3, 'is_active' => true]
        );

        $portfolioItems = [
            [
                'category_id' => $catModernization->id,
                'title' => 'Fintech Core Migration for Vantage Capital',
                'slug' => 'fintech-core-migration-vantage-capital',
                'client' => 'Vantage Capital Markets',
                'summary' => 'Zero-downtime migration of a $1.2B transaction ledger to modern microservices.',
                'content' => 'Vantage Capital operated a monolithic ledger system plagued by peak-hour latency spikes and high infrastructure costs. Apex designed and executed an event-driven ledger architecture with automated dual-write reconciliation, migrating 40M+ historical records with zero transaction loss, achieving -78% latency reduction and $420K/yr savings.',
                'technologies' => ['PHP 8.3', 'PostgreSQL', 'Redis Cluster', 'Kafka', 'Docker', 'Kubernetes'],
                'image' => '/images/portfolio/vantage-case-study.jpg',
                'website_url' => 'https://vantagecapital.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category_id' => $catRisk->id,
                'title' => 'SOC 2 Type II Accreditation in 90 Days',
                'slug' => 'soc-2-type-ii-accreditation-healthsync',
                'client' => 'HealthSync Diagnostics',
                'summary' => 'Comprehensive HIPAA and SOC 2 Type II audit readiness for enterprise healthcare rollout.',
                'content' => 'HealthSync needed to unlock enterprise hospital contracts requiring audited SOC 2 Type II compliance within one quarter. Apex implemented an automated compliance evidence collection suite, overhauled employee access control matrices, and attained clean certification in 84 days unlocking a $14.2M pipeline.',
                'technologies' => ['Terraform', 'AWS GuardDuty', 'HashiCorp Vault', 'Vanta Integration'],
                'image' => '/images/portfolio/healthsync-case-study.jpg',
                'website_url' => 'https://healthsync.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category_id' => $catAutomation->id,
                'title' => 'Global Billing & Contract Lifecycle Automation',
                'slug' => 'global-billing-contract-automation-nexus',
                'client' => 'Nexus Global Logistics',
                'summary' => 'Automating cross-border customs billing across 14 European and North American hubs.',
                'content' => 'Manual customs reconciliation across 14 international fulfillment nodes led to an average 18-day delay. We engineered a centralized event-driven billing hub connecting local ERP nodes to a unified reconciliation ledger, compressing invoicing to 4 minutes and recovering $1.8M in working capital.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Stripe Invoicing', 'SAP Connector'],
                'image' => '/images/portfolio/nexus-case-study.jpg',
                'website_url' => 'https://nexuslogistics.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'category_id' => $catModernization->id,
                'title' => 'Enterprise Procurement Portal Modernization',
                'slug' => 'procurement-portal-modernization-altair',
                'client' => 'Altair Manufacturing Group',
                'summary' => 'Modernizing supply-chain RFQ and vendor bidding workflows for 300+ suppliers.',
                'content' => 'Legacy paper and spreadsheet RFQ processes caused procurement friction and duplicate orders across 8 assembly plants. Apex architected a high-security supplier portal featuring real-time quote comparison and automated ERP sync, shortening cycles by 65% across $85M in spend.',
                'technologies' => ['PHP 8.3', 'Livewire', 'PostgreSQL', 'Tailwind CSS', 'Amazon S3'],
                'image' => '/images/portfolio/altair-case-study.jpg',
                'website_url' => 'https://altairmanufacturing.example.com',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
        ];

        foreach ($portfolioItems as $item) {
            Portfolio::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // 6. Testimonials (4 executive testimonials with ratings)
        $testimonials = [
            [
                'client_name' => 'Eleanor Vance',
                'company' => 'Vantage Capital Markets',
                'client_role' => 'Chief Technology Officer',
                'avatar' => '/images/testimonials/eleanor-vance.jpg',
                'content' => 'Apex did what two global consultancies claimed was impossible: migrated our core transactional ledger without a single second of client-facing downtime. Their technical rigor is truly unmatched in the advisory landscape.',
                'rating' => 5,
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'Marcus Sterling',
                'company' => 'HealthSync Diagnostics',
                'client_role' => 'Chief Executive Officer',
                'avatar' => '/images/testimonials/marcus-sterling.jpg',
                'content' => 'When enterprise hospital networks demanded SOC 2 Type II accreditation on an aggressive 90-day timeline, Apex took total operational ownership. We achieved certification with zero auditor findings ahead of schedule.',
                'rating' => 5,
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'Dr. Aris Thorne',
                'company' => 'Nexus Global Logistics',
                'client_role' => 'Head of Global Operations',
                'avatar' => '/images/testimonials/aris-thorne.jpg',
                'content' => 'The automated reconciliation platform built by Apex unlocked nearly $2M in working capital that had been trapped in billing delays. They think like business owners, not billable-hour contractors.',
                'rating' => 5,
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'client_name' => 'Claire Chen-Rousseau',
                'company' => 'Altair Manufacturing Group',
                'client_role' => 'VP of Supply Chain & Procurement',
                'avatar' => '/images/testimonials/claire-chen.jpg',
                'content' => 'Deploying Apex across our eight manufacturing plants transformed supplier collaboration. Our RFQ cycle times dropped by more than half within the first sixty days of deployment.',
                'rating' => 5,
                'is_featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['client_name' => $t['client_name'], 'company' => $t['company']],
                $t
            );
        }

        // 7. Team Members (4 senior leaders)
        $teamMembers = [
            [
                'name' => 'David Sterling',
                'role' => 'Managing Partner & Head of Strategy',
                'bio' => 'Former McKinsey partner and principal architect with over 18 years leading enterprise restructuring and digital modernization programs across North America and Europe.',
                'photo' => '/images/team/david-sterling.jpg',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/david-sterling-apex',
                    'twitter' => 'https://x.com/davidsterling_strat',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Elena Rostova',
                'role' => 'Partner, Cloud & Technical Architecture',
                'bio' => 'Specializes in high-availability distributed systems, fintech transaction ledgers, and zero-trust security postures for tier-1 financial institutions.',
                'photo' => '/images/team/elena-rostova.jpg',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/elena-rostova-apex',
                    'github' => 'https://github.com/erostova-apex',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Julian K. Vance',
                'role' => 'Director of Compliance & Risk Governance',
                'bio' => 'Certified CISA and former regulatory compliance director who has steered over 50 enterprise certifications spanning SOC 2, HIPAA, ISO 27001, and GDPR.',
                'photo' => '/images/team/julian-vance.jpg',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/julian-vance-apex',
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Sophia Morales',
                'role' => 'Head of Automation & Workflow Engineering',
                'bio' => 'Pioneers intelligent RPA and automated revenue operations that compress friction across corporate billing, customer onboarding, and contract analysis.',
                'photo' => '/images/team/sophia-morales.jpg',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/sophia-morales-apex',
                    'twitter' => 'https://x.com/smorales_automation',
                ],
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::updateOrCreate(['name' => $member['name']], $member);
        }

        // 8. Stats Counters (4 counters)
        $stats = [
            [
                'label' => 'Capital Assets Advised',
                'value' => '$1.8B+',
                'suffix' => '',
                'icon' => 'currency-dollar',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Enterprise Implementations',
                'value' => '250+',
                'suffix' => '',
                'icon' => 'building-office-2',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'Average Operational Cost Savings',
                'value' => '42%',
                'suffix' => '',
                'icon' => 'arrow-trending-up',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'label' => 'Client Retention Rate',
                'value' => '98.6%',
                'suffix' => '',
                'icon' => 'shield-check',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            StatsCounter::updateOrCreate(['label' => $stat['label']], $stat);
        }

        // 9. FAQs (6 categorized FAQs)
        $faqs = [
            [
                'category' => 'Engagement & Strategy',
                'question' => 'How does Apex initiate an advisory or transformation engagement?',
                'answer' => 'Every engagement begins with a 2-week structured diagnostic sprint where we audit your existing workflows, codebases, compliance posture, and cost centers. We then deliver a clear roadmap with fixed milestones and measurable ROI metrics.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Engagement & Strategy',
                'question' => 'Do you work directly with internal engineering and operations teams?',
                'answer' => 'Yes. We operate as an embedded force-multiplier alongside your internal leads rather than an external silod agency. Knowledge transfer and comprehensive documentation are core deliverables in every sprint.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Compliance & Security',
                'question' => 'What compliance standards do your advisory frameworks support?',
                'answer' => 'Our frameworks cover SOC 2 Type I and Type II, ISO 27001, HIPAA, GDPR, PCI-DSS, and custom regulatory guidelines specific to institutional capital markets.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Compliance & Security',
                'question' => 'How do you safeguard client data during architecture reviews and audits?',
                'answer' => 'We execute enterprise NDAs, conduct audits exclusively via ephemeral sandboxed access, and never store or transmit sensitive client production credentials outside of dedicated hardware security modules.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Pricing & Communication',
                'question' => 'Why does Apex prioritize direct WhatsApp executive communication?',
                'answer' => 'Enterprise initiatives require high-speed alignment without the bureaucratic delay of ticketing queues. Our WhatsApp channels connect leadership directly with managing partners for urgent consultations and real-time sprint updates.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Pricing & Communication',
                'question' => 'Are your monthly retainer plans flexible as company requirements evolve?',
                'answer' => 'All plans operate on standard 30-day billing cycles with transparent scope adjustments. You can scale between Strategic Advisory, Operational Growth, or Enterprise Architecture as your roadmap demands.',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
