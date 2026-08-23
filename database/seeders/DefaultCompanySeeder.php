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
        $appName = config('app.name', 'Aegis');
        if ($appName === 'Laravel' || empty($appName)) {
            $appName = 'Aegis';
        }
        $appNameEn = $appName;
        $appNameAr = $appName;

        // 1. Admin User
        $adminPasswordPlain = 'Admin@Secure2026!';
        $adminEmail = 'admin@' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $appName)) . '.com';
        $adminUser = User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => $appName . ' Admin',
                'password' => Hash::make($adminPasswordPlain),
                'email_verified_at' => now(),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Settings (Grouped & typed with bilingual support)
        $settings = [
            // General / Branding & Theme System
            [
                'key' => 'site_name',
                'value' => [
                    'en' => $appNameEn,
                    'ar' => $appNameAr,
                ],
                'group' => 'branding',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'company_tagline',
                'value' => [
                    'en' => 'Enterprise Growth Architecture & Scalable Advisory',
                    'ar' => 'معمارية النمو المؤسسي والاستشارات الاستراتيجية المتقدمة',
                ],
                'group' => 'branding',
                'type' => 'json',
                'is_public' => true,
            ],
            ['key' => 'company_logo', 'value' => '/images/branding/logo.svg', 'group' => 'branding', 'type' => 'image', 'is_public' => true],
            ['key' => 'company_favicon', 'value' => '/favicon.ico', 'group' => 'branding', 'type' => 'image', 'is_public' => true],
            ['key' => 'theme_mode', 'value' => 'toggle_allowed', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'active_theme_default', 'value' => 'dark', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'typography_font', 'value' => 'Plus Jakarta Sans', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'typography_font_heading', 'value' => 'Plus Jakarta Sans', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'radius_card', 'value' => '1rem', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'radius_button', 'value' => '0.75rem', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'radius_input', 'value' => '0.75rem', 'group' => 'theme', 'type' => 'string', 'is_public' => true],

            // Dark Theme Palette
            ['key' => 'dark_bg_body', 'value' => '#030712', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_bg_surface', 'value' => '#0f172a', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_bg_card', 'value' => '#0f172a', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_bg_input', 'value' => '#020617', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_text_primary', 'value' => '#f8fafc', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_text_muted', 'value' => '#94a3b8', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_border_subtle', 'value' => '#1e293b', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_border_highlight', 'value' => '#334155', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_primary_color', 'value' => '#2563eb', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_secondary_color', 'value' => '#4f46e5', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'dark_accent_color', 'value' => '#10b981', 'group' => 'theme', 'type' => 'string', 'is_public' => true],

            // Light Theme Palette
            ['key' => 'light_bg_body', 'value' => '#f8fafc', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_bg_surface', 'value' => '#f1f5f9', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_bg_card', 'value' => '#ffffff', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_bg_input', 'value' => '#ffffff', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_text_primary', 'value' => '#0f172a', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_text_muted', 'value' => '#64748b', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_border_subtle', 'value' => '#e2e8f0', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_border_highlight', 'value' => '#cbd5e1', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_primary_color', 'value' => '#1d4ed8', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_secondary_color', 'value' => '#4338ca', 'group' => 'theme', 'type' => 'string', 'is_public' => true],
            ['key' => 'light_accent_color', 'value' => '#059669', 'group' => 'theme', 'type' => 'string', 'is_public' => true],

            // Backward-compatibility aliases
            ['key' => 'primary_color', 'value' => '#0F172A', 'group' => 'branding', 'type' => 'string', 'is_public' => true],
            ['key' => 'accent_color', 'value' => '#2563EB', 'group' => 'branding', 'type' => 'string', 'is_public' => true],

            // Contact & WhatsApp
            ['key' => 'contact_email', 'value' => 'contact@' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $appName)) . '.com', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            ['key' => 'contact_phone', 'value' => '+1 (555) 019-2834', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            [
                'key' => 'contact_address',
                'value' => [
                    'en' => '100 Montgomery Street, Suite 2400, San Francisco, CA 94104',
                    'ar' => '١٠٠ شارع مونتغمري، جناح ٢٤٠٠، سان فرانسيسكو، كاليفورنيا ٩٤١٠٤',
                ],
                'group' => 'contact',
                'type' => 'json',
                'is_public' => true,
            ],
            ['key' => 'whatsapp_number', 'value' => '+15550192834', 'group' => 'contact', 'type' => 'string', 'is_public' => true],
            [
                'key' => 'whatsapp_default_message',
                'value' => [
                    'en' => "Hello {$appNameEn}, I would like to schedule an executive strategy session regarding our corporate initiatives.",
                    'ar' => "مرحباً بفريق {$appNameAr}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                ],
                'group' => 'contact',
                'type' => 'json',
                'is_public' => true,
            ],

            // Hero Section
            [
                'key' => 'hero_badge',
                'value' => [
                    'en' => 'Enterprise Strategic Advisory',
                    'ar' => 'الاستشارات الاستراتيجية للمؤسسات',
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'hero_title',
                'value' => [
                    'en' => 'Accelerate Enterprise Scale with Predictable Precision',
                    'ar' => 'تسريع التوسع المؤسسي بدقة وكفاءة قابلة للتنبؤ',
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'hero_subtitle',
                'value' => [
                    'en' => "{$appNameEn} partners with institutional leaders to modernize legacy operations, implement high-yield automation, and safeguard governance at scale.",
                    'ar' => "تتعاون {$appNameAr} مع القادة التنفيذيين لتحديث الأنظمة الموروثة، وتطبيق حلول الأتمتة عالية العائد، وترسيخ الحوكمة على نطاق واسع.",
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'hero_cta_text',
                'value' => [
                    'en' => 'Consult via WhatsApp',
                    'ar' => 'استشر خبرائنا عبر واتساب',
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'hero_cta_whatsapp_message',
                'value' => [
                    'en' => "Hello {$appNameEn} team, I would like to schedule an executive strategy session regarding our enterprise initiatives.",
                    'ar' => "مرحباً بفريق {$appNameAr}، أود حجز جلسة استراتيجية تنفيذية لمناقشة مبادراتنا المؤسسية.",
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],
            ['key' => 'hero_rating_score', 'value' => '4.9/5.0', 'group' => 'hero', 'type' => 'string', 'is_public' => true],
            [
                'key' => 'hero_rating_count',
                'value' => [
                    'en' => '250+ Fortune 1000 & High-Growth Clients',
                    'ar' => 'أكثر من 250 عميلاً من كبرى الشركات العالمية والمؤسسات سريعة النمو',
                ],
                'group' => 'hero',
                'type' => 'json',
                'is_public' => true,
            ],

            // About Section
            [
                'key' => 'about_title',
                'value' => [
                    'en' => 'Decades of Institutional Rigor in Modern Markets',
                    'ar' => 'عقود من الصرامة والخبرة المؤسسية في الأسواق الحديثة',
                ],
                'group' => 'about',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'about_description',
                'value' => [
                    'en' => "Founded by veteran operational architects and compliance directors, {$appNameEn} bridges the gap between ambitious corporate milestones and bulletproof day-to-day execution.",
                    'ar' => "تأسست {$appNameAr} على يد نخبة من مهندسي العمليات ومديري الامتثال المخضرمين، لسد الفجوة بين الأهداف المؤسسية الطموحة والتنفيذ اليومي المحكم.",
                ],
                'group' => 'about',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'about_bullet_1',
                'value' => [
                    'en' => 'Direct partner-level engagement on every major strategic advisory engagement.',
                    'ar' => 'مشاركة مباشرة على مستوى الشركاء التنفيذيين في كل مهمة استشارية استراتيجية.',
                ],
                'group' => 'about',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'about_bullet_2',
                'value' => [
                    'en' => 'Proprietary digital workflow frameworks generating verified ROI within 90 days.',
                    'ar' => 'منهجيات سير عمل رقمية مبتكرة تحقق عائداً استثمارياً مؤكداً خلال 90 يوماً.',
                ],
                'group' => 'about',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'about_bullet_3',
                'value' => [
                    'en' => 'Uncompromising compliance protocols adhering to SOC2, ISO 27001, and GDPR.',
                    'ar' => 'بروتوكولات امتثال صارمة ومتوافقة مع معايير SOC2 وISO 27001 واللائحة العامة لحماية البيانات GDPR.',
                ],
                'group' => 'about',
                'type' => 'json',
                'is_public' => true,
            ],

            // SEO & Social
            [
                'key' => 'seo_meta_title',
                'value' => [
                    'en' => "{$appNameEn} | Strategic Enterprise Advisory & Growth",
                    'ar' => "{$appNameAr} | الاستشارات الاستراتيجية ونمو المؤسسات",
                ],
                'group' => 'seo',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'seo_meta_description',
                'value' => [
                    'en' => 'Leading corporate advisory, digital operations transformation, and strategic scaling for mid-market and enterprise organizations.',
                    'ar' => 'الريادة في الاستشارات المؤسسية، وتحول العمليات الرقمية، والتوسع الاستراتيجي للمؤسسات الكبرى والشركات المتوسطة.',
                ],
                'group' => 'seo',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'seo_meta_keywords',
                'value' => [
                    'en' => 'corporate advisory, enterprise transformation, business consulting, digital workflow optimization, fintech compliance',
                    'ar' => 'استشارات مؤسسية، تحول رقمي، استشارات الأعمال، تحسين سير العمل، امتثال التكنولوجيا المالية',
                ],
                'group' => 'seo',
                'type' => 'json',
                'is_public' => true,
            ],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com/company/' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $appName)), 'group' => 'social', 'type' => 'string', 'is_public' => true],
            ['key' => 'social_twitter', 'value' => 'https://x.com/' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '_', $appName)), 'group' => 'social', 'type' => 'string', 'is_public' => true],

            // Footer
            [
                'key' => 'footer_about',
                'value' => [
                    'en' => "{$appNameEn} delivers high-impact management consulting, digital transformation, and operational resilience to modern enterprises globally.",
                    'ar' => "تقدم {$appNameAr} استشارات إدارية عالية التأثير، والتحول الرقمي، والمرونة التشغيلية للمؤسسات الحديثة حول العالم.",
                ],
                'group' => 'footer',
                'type' => 'json',
                'is_public' => true,
            ],
            [
                'key' => 'footer_copyright',
                'value' => [
                    'en' => '© ' . date('Y') . " {$appNameEn}. All rights reserved.",
                    'ar' => '© ' . date('Y') . " شركة {$appNameAr}. جميع الحقوق محفوظة.",
                ],
                'group' => 'footer',
                'type' => 'json',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            if (is_array($setting['value'])) {
                $setting['value'] = json_encode($setting['value'], JSON_UNESCAPED_UNICODE);
                $setting['type'] = 'json';
            }

            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // Clear settings cache
        app(SettingService::class)->clearCache();

        // 3. Services (6 corporate services with features, icons, WhatsApp triggers)
        $services = [
            [
                'title' => [
                    'en' => 'Enterprise Digital Modernization',
                    'ar' => 'التحول الرقمي وتحديث الأنظمة للمؤسسات',
                ],
                'slug' => 'enterprise-digital-modernization',
                'short_description' => [
                    'en' => 'Re-architect legacy workflows into secure, high-throughput cloud operations.',
                    'ar' => 'إعادة هندسة مسارات العمل الموروثة وتحويلها إلى بنية سحابية آمنة وعالية الأداء.',
                ],
                'description' => [
                    'en' => 'We audit, re-engineer, and deploy mission-critical infrastructure that reduces operational drag by up to 45%. From ERP modernization to zero-trust pipeline integrations, our team delivers institutional-grade outcomes without business disruption.',
                    'ar' => 'نقوم بتدقيق وإعادة هندسة ونشر البنية التحتية الحيوية مما يقلل الهدر التشغيلي بنسبة تصل إلى 45%. من تحديث أنظمة تخطيط الموارد (ERP) إلى دمج خطوط العمل وفق نموذج انعدام الثقة (Zero-Trust)، يقدم فريقنا نتائج بمعايير مؤسسية دون تعطيل الأعمال.',
                ],
                'icon' => 'server-stack',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Cloud Infrastructure Architecture & Migration',
                        'Legacy ERP & Database Modernization',
                        'Real-Time Systems Telemetry & Observability',
                        'Automated Compliance & Security Safeguards',
                    ],
                    'ar' => [
                        'هندسة البنية التحتية السحابية والترحيل السلس',
                        'تحديث قواعد البيانات وأنظمة تخطيط الموارد الموروثة',
                        'القياس والمراقبة اللحظية الشاملة للأنظمة',
                        'ضوابط الامتثال والحماية الأمنية المؤتمتة',
                    ],
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Strategic M&A and Operational Due Diligence',
                    'ar' => 'عمليات الاندماج والاستحواذ الاستراتيجي والتدقيق التشغيلي',
                ],
                'slug' => 'strategic-ma-operational-due-diligence',
                'short_description' => [
                    'en' => 'Deep technical and organizational due diligence for high-stakes capital allocations.',
                    'ar' => 'الفحص النافي للجهالة التقني والتنظيمي المعمق لقرارات تخصيص رؤوس الأموال الكبرى.',
                ],
                'description' => [
                    'en' => 'Navigate complex acquisitions and strategic mergers with confidence. We provide thorough technology asset audits, operational synergy modeling, and risk assessments for private equity and corporate development leaders.',
                    'ar' => 'خض غمار صفقات الاستحواذ والاندماج المعقدة بثقة تامة. نوفر تدقيقاً شاملاً للأصول التقنية، ونمذجة التآزر التشغيلي، وتقييم المخاطر لصناديق الملكية الخاصة وقادة التطوير المؤسسي.',
                ],
                'icon' => 'chart-bar-square',
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Technology Stack & Codebase Quality Audit',
                        'Operational Run-Rate & Cost Synergies Analysis',
                        'Regulatory & IP Asset Vulnerability Screening',
                        'Post-Acquisition Integration Roadmaps',
                    ],
                    'ar' => [
                        'تدقيق جودة البنية البرمجية والمكونات التقنية',
                        'تحليل معدل التشغيل وفرص ترشيد التكاليف',
                        'فحص الامتثال التنظيمي وحماية الملكية الفكرية',
                        'خرائط طريق التكامل المؤسسي لما بعد الاستحواذ',
                    ],
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Regulatory Compliance & Risk Governance',
                    'ar' => 'الامتثال التنظيمي وحوكمة وإدارة المخاطر',
                ],
                'slug' => 'regulatory-compliance-risk-governance',
                'short_description' => [
                    'en' => 'End-to-end framework alignment with SOC 2 Type II, ISO 27001, and global financial standards.',
                    'ar' => 'المواءمة الشاملة مع أطر SOC 2 Type II وISO 27001 والمعايير المالية العالمية.',
                ],
                'description' => [
                    'en' => 'Transform regulatory compliance from a friction point into a commercial competitive advantage. We architect automated compliance audit pipelines, data governance policies, and board-level risk reporting.',
                    'ar' => 'حوّل الامتثال التنظيمي من نقطة احتكاك إلى ميزة تنافسية تجارية. نحن نصمم خطوط تدقيق الامتثال المؤتمتة، وسياسات حوكمة البيانات، وتقارير المخاطر الموجهة لمجلس الإدارة.',
                ],
                'icon' => 'shield-check',
                'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Continuous SOC 2 & ISO Audit Readiness',
                        'Cross-Border Data Sovereignty & GDPR Protocols',
                        'Executive Risk & Incident Response Playbooks',
                        'Vendor Ecosystem Vulnerability Assessments',
                    ],
                    'ar' => [
                        'الجاهزية المستمرة لتدقيق شهادات SOC 2 وISO',
                        'سيادة البيانات عبر الحدود وبروتوكولات GDPR',
                        'أدلة إجراءات الاستجابة للطوارئ والمخاطر التنفيذية',
                        'تقييم ثغرات منظومة الموردين والشركاء',
                    ],
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Executive Workflow Automation',
                    'ar' => 'أتمتة مسارات العمل التنفيذية وإجراءات الأعمال',
                ],
                'slug' => 'executive-workflow-automation',
                'short_description' => [
                    'en' => 'Custom AI and RPA pipelines engineered to eliminate cross-departmental bottlenecks.',
                    'ar' => 'حلول مخصصة للذكاء الاصطناعي وأتمتة العمليات الآلية (RPA) لإزالة الاختناقات بين الأقسام.',
                ],
                'description' => [
                    'en' => 'Eliminate manual data handoffs between revenue, finance, and legal teams. We design reliable, audited automation pipelines that compress deal approval cycles from days to minutes.',
                    'ar' => 'تخلص من نقل البيانات اليدوي بين فرق المبيعات والمالية والقانونية. نصمم مسارات أتمتة موثوقة ومدققة تختصر دورات الموافقة على الصفقات من أيام إلى دقائق معدودة.',
                ],
                'icon' => 'cpu-chip',
                'image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Automated Billing & Revenue Recognition Pipelines',
                        'Contract Review & Lifecycle Management Automation',
                        'Custom Internal AI Co-Pilots with Strict RBAC',
                        'CRM-to-ERP High-Frequency Synchronization',
                    ],
                    'ar' => [
                        'أتمتة الفوترة وخطوط الاعتراف بالإيرادات',
                        'أتمتة مراجعة العقود وإدارة دورة حياتها',
                        'مساعدات ذكاء اصطناعي داخلية بصلاحيات صارمة',
                        'مزامنة فائقة السرعة بين أنظمة CRM وERP',
                    ],
                ],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Fractional Corporate Leadership & Advisory',
                    'ar' => 'القيادة التنفيذية المؤقتة والاستشارات الاستراتيجية',
                ],
                'slug' => 'fractional-corporate-leadership-advisory',
                'short_description' => [
                    'en' => 'Seasoned C-suite operating partners to guide critical inflection points and scale.',
                    'ar' => 'شركاء تنفيذيون متمرسون لقيادة المنعطفات الحرجة ومراحل التوسع الكبرى.',
                ],
                'description' => [
                    'en' => 'Deploy seasoned fractional CTOs, COOs, and Chief Compliance Officers to bridge leadership gaps, prepare for major funding rounds, or guide high-stakes corporate turnarounds.',
                    'ar' => 'استعن برؤساء تنفيذيين تقنيين وتشغيليين ومديري امتثال بنظام الإعارة الجزئية لسد فجوات القيادة، والاستعداد لجولات التمويل الكبرى، أو قيادة التحولات الجذرية.',
                ],
                'icon' => 'user-group',
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Interim CTO & COO Leadership Services',
                        'Board Advisory & Investor Presentation Structuring',
                        'Engineering & Product Organization Restructuring',
                        'Global Expansion & Subsidiary Entity Setup',
                    ],
                    'ar' => [
                        'خدمات القيادة المؤقتة لمنصب الرئيس التقني والتشغيلي',
                        'استشارات مجلس الإدارة وإعداد عروض المستثمرين',
                        'إعادة هيكلة فرق الهندسة وإدارة المنتجات',
                        'التوسع الدولي وتأسيس الشركات التابعة',
                    ],
                ],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Enterprise Data Intelligence & Predictive Analytics',
                    'ar' => 'ذكاء البيانات المؤسسية والتحليلات التنبؤية',
                ],
                'slug' => 'enterprise-data-intelligence-analytics',
                'short_description' => [
                    'en' => 'Transform disparate enterprise data repositories into unified, actionable real-time intelligence.',
                    'ar' => 'تحويل مستودعات البيانات المؤسسية المتباينة إلى منظومة استخبارات أعمال موحدة ولحظية.',
                ],
                'description' => [
                    'en' => 'Build high-performance modern data lakes, automated ETL pipelines, and executive BI dashboards. We empower C-suite leaders with predictive decision intelligence and real-time operational telemetry.',
                    'ar' => 'بناء بحيرات بيانات حديثة عالية الأداء، ومسارات استخراج وتحويل مؤتمتة (ETL)، ولوحات ذكاء أعمال تنفيذية. نمكّن القادة التنفيذيين من اتخاذ القرارات التنبؤية بالاعتماد على بيانات تشغيلية فورية.',
                ],
                'icon' => 'chart-pie',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'features' => [
                    'en' => [
                        'Enterprise Lakehouse & Modern Data Warehousing',
                        'Automated Multi-Source ETL/ELT Pipelines',
                        'Executive Decision Support & Real-Time BI Dashboards',
                        'Predictive Customer & Financial Analytics',
                    ],
                    'ar' => [
                        'بناء مستودعات وبحيرات البيانات المؤسسية الحديثة',
                        'مسارات تكامل واستخراج البيانات المؤتمتة متعددة المصادر',
                        'لوحات دعم اتخاذ القرار التنفيذي وذكاء الأعمال اللحظي',
                        'التحليلات التنبؤية لسلوك العملاء والمؤشرات المالية',
                    ],
                ],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::updateOrCreate(['slug' => $serviceData['slug']], $serviceData);
        }

        // 4. Pricing Plans (3 tiers: Advisory, Growth, Enterprise)
        $pricingPlans = [
            [
                'name' => [
                    'en' => 'Strategic Advisory',
                    'ar' => 'الاستشارة الاستراتيجية',
                ],
                'slug' => 'strategic-advisory',
                'price' => 3500.00,
                'billing_period' => [
                    'en' => 'month',
                    'ar' => 'شهرياً',
                ],
                'currency' => 'USD',
                'description' => [
                    'en' => 'Focused monthly advisory and governance for growing companies requiring strategic oversight.',
                    'ar' => 'استشارات وحوكمة شهرية مركزة للشركات النامية التي تتطلب إشرافاً استراتيجياً رفيع المستوى.',
                ],
                'features' => [
                    'en' => [
                        'Bi-weekly partner strategic consultation calls',
                        'Architecture & security review sessions',
                        'Quarterly governance & compliance health check',
                        'Priority WhatsApp communication channel',
                        'Advisory response within 24 business hours',
                    ],
                    'ar' => [
                        'جلسات استشارية استراتيجية نصف شهرية مع الشركاء',
                        'جلسات مراجعة البنية المعمارية والأمان السيبراني',
                        'فحص دوري ربع سنوي للحوكمة والامتثال',
                        'قناة تواصل ذات أولوية عبر واتساب',
                        'استجابة استشارية خلال 24 ساعة عمل',
                    ],
                ],
                'is_featured' => false,
                'whatsapp_message' => "Hello {$appNameEn} team, I would like to engage on the Strategic Advisory monthly retainer plan ($3,500/mo).",
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Operational Growth',
                    'ar' => 'النمو التشغيلي والتوسع',
                ],
                'slug' => 'operational-growth',
                'price' => 7500.00,
                'billing_period' => [
                    'en' => 'month',
                    'ar' => 'شهرياً',
                ],
                'currency' => 'USD',
                'description' => [
                    'en' => 'Comprehensive hands-on operational transformation, workflow automation, and infrastructure engineering.',
                    'ar' => 'تحول تشغيلي شامل وعملي، وأتمتة مسارات العمل، وهندسة البنية التحتية المتطورة.',
                ],
                'features' => [
                    'en' => [
                        'Dedicated operational lead & solution architect',
                        'Full workflow automation & system integrations',
                        'Active SOC2 / ISO 27001 readiness engineering',
                        'Weekly sprint syncs & executive progress decks',
                        'Direct WhatsApp channel with 4-hour SLA',
                        'Quarterly partner on-site strategy workshop',
                    ],
                    'ar' => [
                        'قائد تشغيلي ومهندس حلول مخصصان لمشروعكم',
                        'أتمتة شاملة لمسارات العمل وتكامل الأنظمة',
                        'هندسة الجاهزية لمعايير SOC2 وISO 27001',
                        'مزامنة أسبوعية وتقارير إنجاز تنفيذية دورية',
                        'قناة واتساب مباشرة مع اتفاقية استجابة خلال 4 ساعات',
                        'ورشة عمل استراتيجية حضورية ربع سنوية مع الشركاء',
                    ],
                ],
                'is_featured' => true,
                'whatsapp_message' => "Hello {$appNameEn} team, I want to initiate the Operational Growth transformation plan ($7,500/mo).",
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Enterprise Architecture',
                    'ar' => 'المعمارية المؤسسية الشاملة',
                ],
                'slug' => 'enterprise-architecture',
                'price' => 15000.00,
                'billing_period' => [
                    'en' => 'month',
                    'ar' => 'شهرياً',
                ],
                'currency' => 'USD',
                'description' => [
                    'en' => 'Full-spectrum embedded fractional executive team and dedicated engineering squad for multinational scale.',
                    'ar' => 'فريق قيادي تنفيذي مدمج وفريق هندسي متفرغ للمؤسسات ذات النطاق متعدد الجنسيات.',
                ],
                'features' => [
                    'en' => [
                        'Embedded Fractional C-Suite (CTO / COO / CCO)',
                        'Multi-region high-availability cloud architecture',
                        'Continuous M&A due diligence & vendor screening',
                        '24/7 Priority escalation desk & instant WhatsApp hotline',
                        'Tailored board reporting & regulatory liaison',
                        'Custom SLA with guaranteed dedicated capacity',
                    ],
                    'ar' => [
                        'فريق قيادة تنفيذية مدمج (CTO / COO / CCO)',
                        'بنية سحابية متعددة المناطق وعالية التوافر',
                        'تدقيق مستمر لصفقات الاستحواذ وفحص الموردين',
                        'مكتب تصعيد ذو أولوية على مدار الساعة مع خط واتساب فوري',
                        'تقارير مخصصة لمجلس الإدارة والتنسيق التنظيمي',
                        'اتفاقية مستوى خدمة مخصصة بسعة عمل مضمونة',
                    ],
                ],
                'is_featured' => false,
                'whatsapp_message' => "Hello {$appNameEn} team, I would like to schedule an Enterprise Architecture executive consultation ($15,000/mo).",
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
            [
                'name' => [
                    'en' => 'Digital Modernization',
                    'ar' => 'التحول الرقمي وتحديث النظم',
                ],
                'description' => [
                    'en' => 'Enterprise cloud transformations, legacy code migrations, and architectural revamps.',
                    'ar' => 'التحول السحابي للمؤسسات، وترحيل الأنظمة الموروثة، وتجديد البنية المعمارية.',
                ],
                'order' => 1,
                'is_active' => true,
            ]
        );

        $catRisk = PortfolioCategory::updateOrCreate(
            ['slug' => 'risk-compliance'],
            [
                'name' => [
                    'en' => 'Risk & Compliance',
                    'ar' => 'المخاطر والامتثال التنظيمي',
                ],
                'description' => [
                    'en' => 'SOC 2, ISO 27001, GDPR audits, and institutional governance frameworks.',
                    'ar' => 'تدقيق شهادات SOC 2 وISO 27001 وGDPR، وأطر الحوكمة المؤسسية.',
                ],
                'order' => 2,
                'is_active' => true,
            ]
        );

        $catAutomation = PortfolioCategory::updateOrCreate(
            ['slug' => 'operational-automation'],
            [
                'name' => [
                    'en' => 'Operational Automation',
                    'ar' => 'الأتمتة التشغيلية وهندسة الإجراءات',
                ],
                'description' => [
                    'en' => 'High-throughput RPA pipelines, ERP-CRM syncs, and intelligent workflows.',
                    'ar' => 'مسارات أتمتة العمليات عالية الإنتاجية، والربط بين أنظمة ERP وCRM، ومسارات العمل الذكية.',
                ],
                'order' => 3,
                'is_active' => true,
            ]
        );

        $portfolioItems = [
            [
                'category_id' => $catModernization->id,
                'title' => [
                    'en' => 'Fintech Core Migration for Vantage Capital',
                    'ar' => 'ترحيل البنية المصرفية الأساسية لشركة فانتاج كابيتال',
                ],
                'slug' => 'fintech-core-migration-vantage-capital',
                'client' => [
                    'en' => 'Vantage Capital Markets',
                    'ar' => 'أسواق فانتاج كابيتال المالية',
                ],
                'summary' => [
                    'en' => 'Zero-downtime migration of a $1.2B transaction ledger to modern microservices.',
                    'ar' => 'ترحيل دفتر معاملات بقيمة 1.2 مليار دولار إلى خدمات مصغرة حديثة دون أي توقف عن العمل.',
                ],
                'content' => [
                    'en' => "Vantage Capital operated a monolithic ledger system plagued by peak-hour latency spikes and high infrastructure costs. {$appNameEn} designed and executed an event-driven ledger architecture with automated dual-write reconciliation, migrating 40M+ historical records with zero transaction loss, achieving -78% latency reduction and $420K/yr savings.",
                    'ar' => "كانت فانتاج كابيتال تعاني من نظام دفتر الأستاذ الأحادي القديم مع بطء حاد في ساعات الذروة وتكاليف بنية تحتية مرتفعة. صممت {$appNameAr} ونفذت بنية معمارية تعتمد على الأحداث مع مطابقة آلية للكتابة المزدوجة، وترحيل أكثر من 40 مليون سجل تاريخي دون أي فقدان في المعاملات، محققة انخفاضاً بنسبة 78% في زمن الاستجابة ووفورات بقيمة 420 ألف دولار سنوياً.",
                ],
                'technologies' => ['PHP 8.3', 'PostgreSQL', 'Redis Cluster', 'Kafka', 'Docker', 'Kubernetes'],
                'image' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://vantagecapital.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'category_id' => $catRisk->id,
                'title' => [
                    'en' => 'SOC 2 Type II Accreditation in 90 Days',
                    'ar' => 'اعتماد SOC 2 Type II الشامل خلال 90 يوماً',
                ],
                'slug' => 'soc-2-type-ii-accreditation-healthsync',
                'client' => [
                    'en' => 'HealthSync Diagnostics',
                    'ar' => 'هيلث سينك للتشخيص الطبي',
                ],
                'summary' => [
                    'en' => 'Comprehensive HIPAA and SOC 2 Type II audit readiness for enterprise healthcare rollout.',
                    'ar' => 'الجاهزية الشاملة لتدقيق HIPAA وSOC 2 Type II لتوسيع حلول الرعاية الصحية المؤسسية.',
                ],
                'content' => [
                    'en' => "HealthSync needed to unlock enterprise hospital contracts requiring audited SOC 2 Type II compliance within one quarter. {$appNameEn} implemented an automated compliance evidence collection suite, overhauled employee access control matrices, and attained clean certification in 84 days unlocking a $14.2M pipeline.",
                    'ar' => "احتاجت شركة هيلث سينك لتوقيع عقود مستشفيات كبرى تشترط الامتثال المعتمد لمعيار SOC 2 Type II خلال ربع سنوي واحد. طبقت {$appNameAr} حزمة آلية لجمع أدلة الامتثال، وأعادت هيكلة مصفوفات صلاحيات الموظفين، وحصلت على الشهادة دون ملاحظات خلال 84 يوماً مما فتح صفقات بقيمة 14.2 مليون دولار.",
                ],
                'technologies' => ['Terraform', 'AWS GuardDuty', 'HashiCorp Vault', 'Vanta Integration'],
                'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://healthsync.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'category_id' => $catAutomation->id,
                'title' => [
                    'en' => 'Global Billing & Contract Lifecycle Automation',
                    'ar' => 'أتمتة الفوترة العالمية ودورة حياة العقود',
                ],
                'slug' => 'global-billing-contract-automation-nexus',
                'client' => [
                    'en' => 'Nexus Global Logistics',
                    'ar' => 'نكسس للخدمات اللوجستية العالمية',
                ],
                'summary' => [
                    'en' => 'Automated multinational freight billing, carrier reconciliation, and contract workflows.',
                    'ar' => 'أتمتة الفوترة الدولية للشحن، ومطابقة حسابات الناقلين، ومسارات تدقيق العقود.',
                ],
                'content' => [
                    'en' => "Nexus suffered from recurring invoicing disputes and delayed settlements across 40+ maritime carriers. {$appNameEn} engineered an automated settlement portal integrating OCR rate cards and real-time shipment milestones, compressing dispute resolution times from 21 days down to 4 hours.",
                    'ar' => "عانت نكسس من نزاعات متكررة في الفواتير وتأخر التسويات عبر أكثر من 40 ناقلاً بحرياً. قمنا بهندسة منصة تسوية مؤتمتة تقرأ بطاقات الأسعار آلياً وترتبط ببيانات الشحن الفورية، مما قلص فترات حل النزاعات من 21 يوماً إلى 4 ساعات.",
                ],
                'technologies' => ['Laravel 11', 'PostgreSQL', 'Redis', 'Python OCR', 'AWS Textract'],
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://nexuslogistics.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 3,
            ],
            [
                'category_id' => $catModernization->id,
                'title' => [
                    'en' => 'Enterprise Procurement Portal Modernization',
                    'ar' => 'تحديث بوابة المشتريات والمناقصات المؤسسية',
                ],
                'slug' => 'procurement-portal-modernization-altair',
                'client' => [
                    'en' => 'Altair Manufacturing Group',
                    'ar' => 'مجموعة ألتير للتصنيع',
                ],
                'summary' => [
                    'en' => 'Modernizing supply-chain RFQ and vendor bidding workflows for 300+ suppliers.',
                    'ar' => 'تحديث مسارات طلبات عروض الأسعار ومناقصات الموردين لأكثر من 300 مورد.',
                ],
                'content' => [
                    'en' => "Legacy paper and spreadsheet RFQ processes caused procurement friction and duplicate orders across 8 assembly plants. {$appNameEn} architected a high-security supplier portal featuring real-time quote comparison and automated ERP sync, shortening cycles by 65% across $85M in spend.",
                    'ar' => "تسببت عمليات طلب العروض الورقية وجداول البيانات القديمة في بطء المشتريات وتكرار الطلبات عبر 8 مصانع تجميع. صممت {$appNameAr} بوابة موردين عالية الأمان مع مقارنة فورية للعروض ومزامنة تلقائية مع ERP، مما قلص فترات الدورات بنسبة 65% عبر مشتريات بقيمة 85 مليون دولار.",
                ],
                'technologies' => ['PHP 8.3', 'Livewire', 'PostgreSQL', 'Tailwind CSS', 'Amazon S3'],
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://altairmanufacturing.example.com',
                'is_featured' => false,
                'is_active' => true,
                'order' => 4,
            ],
            [
                'category_id' => $catRisk->id,
                'title' => [
                    'en' => 'Cross-Border Regulatory Data Governance Hub',
                    'ar' => 'منصة حوكمة البيانات والامتثال التنظيمي عبر الحدود',
                ],
                'slug' => 'cross-border-regulatory-data-hub-zenith',
                'client' => [
                    'en' => 'Zenith Financial Trust',
                    'ar' => 'صندوق زينيث المالي الاستئماني',
                ],
                'summary' => [
                    'en' => 'Automated data sovereignty and cross-border GDPR/CCPA risk management engine.',
                    'ar' => 'محرك آلي لإدارة سيادة البيانات ومخاطر الامتثال للائحة GDPR وقانون CCPA عبر الحدود.',
                ],
                'content' => [
                    'en' => "Zenith Financial needed a synchronized governance platform to manage privacy consents and data residency across US, EU, and Middle Eastern jurisdictions. {$appNameEn} implemented real-time automated data lineage tracking and dynamic pseudonymization, reducing compliance audit overhead by 70%.",
                    'ar' => "احتاج صندوق زينيث المالي إلى منصة حوكمة متزامنة لإدارة موافقات الخصوصية وإقامة البيانات عبر الولايات المتحدة والاتحاد الأوروبي والشرق الأوسط. نفذت {$appNameAr} نظام تتبع فوري لمسار البيانات وإخفاء الهوية الديناميكي، مما خفض أعباء تدقيق الامتثال بنسبة 70%.",
                ],
                'technologies' => ['Python', 'FastAPI', 'Snowflake', 'Apache Atlas', 'AWS KMS'],
                'image' => 'https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://zenithfinancial.example.com',
                'is_featured' => false,
                'is_active' => true,
                'order' => 5,
            ],
            [
                'category_id' => $catAutomation->id,
                'title' => [
                    'en' => 'Intelligent Claims Processing & AI Pipeline',
                    'ar' => 'محرك المعالجة الذكية للمطالبات التأمينية بالذكاء الاصطناعي',
                ],
                'slug' => 'intelligent-claims-automation-engine-omnicare',
                'client' => [
                    'en' => 'OmniCare Assurance Group',
                    'ar' => 'مجموعة أومني كير للتأمين',
                ],
                'summary' => [
                    'en' => 'AI-assisted medical claims adjudication cutting resolution time from 14 days to 3 hours.',
                    'ar' => 'معالجة المطالبات الطبية بالذكاء الاصطناعي مقلصة مدة التسوية من 14 يوماً إلى 3 ساعات.',
                ],
                'content' => [
                    'en' => "OmniCare faced heavy backlogs in claims processing with high human error rates during fraud screening. {$appNameEn} deployed an audited NLP extraction model paired with automated decision trees that pre-screened 85% of standard claims, lowering processing operational cost by 54%.",
                    'ar' => "واجهت أومني كير تراكمات كبيرة في معالجة المطالبات مع معدلات خطأ بشري أثناء فحص الاحتيال. نشرت {$appNameAr} نموذج استخراج لغوي مدققاً مقترناً بأشجار قرار مؤتمتة فحصت مسبقاً 85% من المطالبات القياسية، مما خفض التكلفة التشغيلية للمعالجة بنسبة 54%.",
                ],
                'technologies' => ['Python', 'PyTorch', 'Laravel', 'PostgreSQL', 'Docker'],
                'image' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&w=1200&q=80',
                'website_url' => 'https://omnicare.example.com',
                'is_featured' => true,
                'is_active' => true,
                'order' => 6,
            ],
        ];

        foreach ($portfolioItems as $item) {
            Portfolio::updateOrCreate(['slug' => $item['slug']], $item);
        }

        // 6. Testimonials (4 executive testimonials with ratings)
        $testimonials = [
            [
                'client_name' => [
                    'en' => 'Eleanor Vance',
                    'ar' => 'إليانور فانس',
                ],
                'company' => [
                    'en' => 'Vantage Capital Markets',
                    'ar' => 'أسواق فانتاج كابيتال المالية',
                ],
                'client_role' => [
                    'en' => 'Chief Technology Officer',
                    'ar' => 'المدير التنفيذي للتكنولوجيا',
                ],
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&h=400&q=80',
                'content' => [
                    'en' => "{$appNameEn} did what two global consultancies claimed was impossible: migrated our core transactional ledger without a single second of client-facing downtime. Their technical rigor is truly unmatched in the advisory landscape.",
                    'ar' => "حققت {$appNameAr} ما اعتبرته شركتان استشاريتان عالميتان مستحيلاً: ترحيل نظام دفتر الأستاذ الأساسي لدينا دون انقطاع لثانية واحدة عن عملائنا. إن صرامتهم التقنية لا مثيل لها في قطاع الاستشارات.",
                ],
                'rating' => 5,
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'client_name' => [
                    'en' => 'Marcus Sterling',
                    'ar' => 'ماركوس ستيرلينغ',
                ],
                'company' => [
                    'en' => 'HealthSync Diagnostics',
                    'ar' => 'هيلث سينك للتشخيص الطبي',
                ],
                'client_role' => [
                    'en' => 'Chief Executive Officer',
                    'ar' => 'الرئيس التنفيذي',
                ],
                'avatar' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=400&h=400&q=80',
                'content' => [
                    'en' => "When enterprise hospital networks demanded SOC 2 Type II accreditation on an aggressive 90-day timeline, {$appNameEn} took total operational ownership. We achieved certification with zero auditor findings ahead of schedule.",
                    'ar' => "عندما اشترطت شبكات المستشفيات الكبرى اعتماد SOC 2 Type II في جدول زمني صارم خلال 90 يوماً، تولت {$appNameAr} المسؤولية التشغيلية الكاملة وحصلنا على الشهادة دون أي ملاحظات وقبل الموعد المحدد.",
                ],
                'rating' => 5,
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'client_name' => [
                    'en' => 'Dr. Aris Thorne',
                    'ar' => 'د. أريس ثورن',
                ],
                'company' => [
                    'en' => 'Nexus Global Logistics',
                    'ar' => 'نكسس للخدمات اللوجستية العالمية',
                ],
                'client_role' => [
                    'en' => 'Head of Global Operations',
                    'ar' => 'رئيس العمليات الدولية',
                ],
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=400&h=400&q=80',
                'content' => [
                    'en' => "The automated reconciliation platform built by {$appNameEn} unlocked nearly $2M in working capital that had been trapped in billing delays. They think like business owners, not billable-hour contractors.",
                    'ar' => "منصة المطابقة المؤتمتة التي بنتها {$appNameAr} حررت ما يقرب من 2 مليون دولار من رأس المال العامل المحتجز في تأخيرات الفوترة. إنهم يفكرون كشركاء أعمال وليس كمقاولين يحسبون الساعات.",
                ],
                'rating' => 5,
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'client_name' => [
                    'en' => 'Claire Chen-Rousseau',
                    'ar' => 'كلير تشن روسو',
                ],
                'company' => [
                    'en' => 'Altair Manufacturing Group',
                    'ar' => 'مجموعة ألتير للتصنيع',
                ],
                'client_role' => [
                    'en' => 'VP of Supply Chain & Procurement',
                    'ar' => 'نائب الرئيس لسلسلة الإمداد والمشتريات',
                ],
                'avatar' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=400&h=400&q=80',
                'content' => [
                    'en' => "Deploying {$appNameEn} across our eight manufacturing plants transformed supplier collaboration. Our RFQ cycle times dropped by more than half within the first sixty days of deployment.",
                    'ar' => "أحدث التعاون مع {$appNameAr} عبر مصانعنا الثمانية تحولاً جذرياً في التنسيق مع الموردين. انخفضت فترات دورة عروض الأسعار بأكثر من النصف خلال أول ستين يوماً من التطبيق.",
                ],
                'rating' => 5,
                'is_featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['order' => $t['order']],
                $t
            );
        }

        // 7. Team Members (4 senior leaders)
        $teamMembers = [
            [
                'name' => [
                    'en' => 'David Sterling',
                    'ar' => 'ديفيد ستيرلينغ',
                ],
                'role' => [
                    'en' => 'Managing Partner & Head of Strategy',
                    'ar' => 'الشريك الإداري ورئيس قسم الاستراتيجية',
                ],
                'bio' => [
                    'en' => 'Former McKinsey partner and principal architect with over 18 years leading enterprise restructuring and digital modernization programs across North America and Europe.',
                    'ar' => 'شريك سابق في ماكنزي ومهندس رئيسي بخبرة تتجاوز 18 عاماً في قيادة برامج إعادة الهيكلة المؤسسية والتحول الرقمي في أمريكا الشمالية وأوروبا.',
                ],
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&h=600&q=80',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/david-sterling-apex',
                    'twitter' => 'https://x.com/davidsterling_strat',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Elena Rostova',
                    'ar' => 'إيلينا روستوفا',
                ],
                'role' => [
                    'en' => 'Partner, Cloud & Technical Architecture',
                    'ar' => 'شريكة، البنية السحابية والحلول التقنية',
                ],
                'bio' => [
                    'en' => 'Specializes in high-availability distributed systems, fintech transaction ledgers, and zero-trust security postures for tier-1 financial institutions.',
                    'ar' => 'متخصصة في الأنظمة الموزعة عالية التوافر، ودفاتر معاملات التكنولوجيا المالية، ونماذج الأمان بانعدام الثقة للمؤسسات المالية الكبرى.',
                ],
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=600&h=600&q=80',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/elena-rostova-apex',
                    'github' => 'https://github.com/erostova-apex',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Julian K. Vance',
                    'ar' => 'جوليان ك. فانس',
                ],
                'role' => [
                    'en' => 'Director of Compliance & Risk Governance',
                    'ar' => 'مدير الامتثال وحوكمة المخاطر',
                ],
                'bio' => [
                    'en' => 'Certified CISA and former regulatory compliance director who has steered over 50 enterprise certifications spanning SOC 2, HIPAA, ISO 27001, and GDPR.',
                    'ar' => 'مدقق نظم معلومات معتمد (CISA) ومدير امتثال تنظيمي سابق قاد أكثر من 50 اعتماداً مؤسسياً تشمل SOC 2 وHIPAA وISO 27001 وGDPR.',
                ],
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=600&h=600&q=80',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/julian-vance-apex',
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Sophia Morales',
                    'ar' => 'صوفيا موراليس',
                ],
                'role' => [
                    'en' => 'Head of Automation & Workflow Engineering',
                    'ar' => 'رئيسة قسم الأتمتة وهندسة مسارات العمل',
                ],
                'bio' => [
                    'en' => 'Pioneers intelligent RPA and automated revenue operations that compress friction across corporate billing, customer onboarding, and contract analysis.',
                    'ar' => 'رائدة في مجالات أتمتة العمليات الروبوتية وعمليات الإيرادات المؤتمتة التي تقلل الاحتكاك في الفوترة المؤسسية، واستقطاب العملاء، وتحليل العقود.',
                ],
                'photo' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=600&h=600&q=80',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/in/sophia-morales-apex',
                    'twitter' => 'https://x.com/smorales_automation',
                ],
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::updateOrCreate(['order' => $member['order']], $member);
        }

        // 8. Stats Counters (4 counters)
        $stats = [
            [
                'label' => [
                    'en' => 'Capital Assets Advised',
                    'ar' => 'أصول رأس مالية تحت الاستشارة',
                ],
                'value' => '$1.8B+',
                'suffix' => [
                    'en' => '',
                    'ar' => '',
                ],
                'icon' => 'currency-dollar',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'label' => [
                    'en' => 'Enterprise Implementations',
                    'ar' => 'مشاريع مؤسسية مكتملة',
                ],
                'value' => '250+',
                'suffix' => [
                    'en' => '',
                    'ar' => '',
                ],
                'icon' => 'building-office-2',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'label' => [
                    'en' => 'Average Operational Cost Savings',
                    'ar' => 'متوسط وفورات التكلفة التشغيلية',
                ],
                'value' => '42%',
                'suffix' => [
                    'en' => '',
                    'ar' => '',
                ],
                'icon' => 'arrow-trending-up',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'label' => [
                    'en' => 'Client Retention Rate',
                    'ar' => 'معدل الحفاظ على العملاء',
                ],
                'value' => '98.6%',
                'suffix' => [
                    'en' => '',
                    'ar' => '',
                ],
                'icon' => 'shield-check',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($stats as $stat) {
            StatsCounter::updateOrCreate(['order' => $stat['order']], $stat);
        }

        // 9. FAQs (6 categorized FAQs)
        $faqs = [
            [
                'category' => 'Engagement & Strategy',
                'question' => [
                    'en' => "How does {$appNameEn} initiate an advisory or transformation engagement?",
                    'ar' => "كيف تبدأ {$appNameAr} مهمة استشارية أو برنامج تحول مؤسسي؟",
                ],
                'answer' => [
                    'en' => 'Every engagement begins with a 2-week structured diagnostic sprint where we audit your existing workflows, codebases, compliance posture, and cost centers. We then deliver a clear roadmap with fixed milestones and measurable ROI metrics.',
                    'ar' => 'تبدأ كل مهمة بمرحلة تشخيصية منظمة لمدة أسبوعين نقوم خلالها بتدقيق مسارات العمل الحالية، والشيفرات البرمجية، ووضع الامتثال، ومراكز التكلفة. ثم نقدم خارطة طريق واضحة بمحطات ثابتة ومقاييس عائد استثماري قابلة للقياس.',
                ],
                'order' => 1,
                'is_active' => true,
            ],
            [
                'category' => 'Engagement & Strategy',
                'question' => [
                    'en' => 'Do you work directly with internal engineering and operations teams?',
                    'ar' => 'هل تعملون مباشرة مع فرق الهندسة والعمليات الداخلية في المؤسسة؟',
                ],
                'answer' => [
                    'en' => 'Yes. We operate as an embedded force-multiplier alongside your internal leads rather than an external silod agency. Knowledge transfer and comprehensive documentation are core deliverables in every sprint.',
                    'ar' => 'نعم. نعمل كقوة مضاعفة مدمجة إلى جانب قادتكم الداخليين وليس كوكالة خارجية منعزلة. يعد نقل المعرفة والتوثيق الشامل من المخرجات الأساسية في كل مرحلة عمل.',
                ],
                'order' => 2,
                'is_active' => true,
            ],
            [
                'category' => 'Compliance & Security',
                'question' => [
                    'en' => 'What compliance standards do your advisory frameworks support?',
                    'ar' => 'ما هي معايير الامتثال التي تدعمها أطركم الاستشارية؟',
                ],
                'answer' => [
                    'en' => 'Our frameworks cover SOC 2 Type I and Type II, ISO 27001, HIPAA, GDPR, PCI-DSS, and custom regulatory guidelines specific to institutional capital markets.',
                    'ar' => 'تغطي أطرنا معايير SOC 2 (النوعين الأول والثاني)، وISO 27001، وHIPAA، وGDPR، وPCI-DSS، بالإضافة إلى اللوائح التنظيمية الخاصة بأسواق المال والمؤسسات المالية.',
                ],
                'order' => 3,
                'is_active' => true,
            ],
            [
                'category' => 'Compliance & Security',
                'question' => [
                    'en' => 'How do you safeguard client data during architecture reviews and audits?',
                    'ar' => 'كيف تحمون بيانات العملاء أثناء مراجعات البنية المعمارية وعمليات التدقيق؟',
                ],
                'answer' => [
                    'en' => 'We execute enterprise NDAs, conduct audits exclusively via ephemeral sandboxed access, and never store or transmit sensitive client production credentials outside of dedicated hardware security modules.',
                    'ar' => 'نوقع اتفاقيات سرية مؤسسية صارمة (NDA)، ونجري عمليات التدقيق حصرياً عبر بيئات معزولة مؤقتة، ولا نقوم أبداً بتخزين أو نقل بيانات الاعتماد الحساسة خارج وحدات الأمان للأجهزة المخصصة.',
                ],
                'order' => 4,
                'is_active' => true,
            ],
            [
                'category' => 'Pricing & Communication',
                'question' => [
                    'en' => "Why does {$appNameEn} prioritize direct WhatsApp executive communication?",
                    'ar' => "لماذا تمنح {$appNameAr} الأولوية للتواصل التنفيذي المباشر عبر واتساب؟",
                ],
                'answer' => [
                    'en' => 'Enterprise initiatives require high-speed alignment without the bureaucratic delay of ticketing queues. Our WhatsApp channels connect leadership directly with managing partners for urgent consultations and real-time sprint updates.',
                    'ar' => 'تتطلب المبادرات المؤسسية تنسيقاً فائق السرعة دون التأخير البيروقراطي لأنظمة تذاكر الدعم. تربط قنوات واتساب لدينا القيادة التنفيذية بالشركاء الإداريين مباشرة للاستشارات العاجلة والتحديثات الفورية.',
                ],
                'order' => 5,
                'is_active' => true,
            ],
            [
                'category' => 'Pricing & Communication',
                'question' => [
                    'en' => 'Are your monthly retainer plans flexible as company requirements evolve?',
                    'ar' => 'هل باقات الدعم الشهري مرنة مع تطور متطلبات الشركة؟',
                ],
                'answer' => [
                    'en' => 'All plans operate on standard 30-day billing cycles with transparent scope adjustments. You can scale between Strategic Advisory, Operational Growth, or Enterprise Architecture as your roadmap demands.',
                    'ar' => 'تعمل جميع الباقات على دورات فوترة قياسية مدتها 30 يوماً مع تعديلات شفافة في نطاق العمل. يمكنك التبديل والترقية بين باقات الاستشارة الاستراتيجية، أو النمو التشغيلي، أو المعمارية المؤسسية وفقاً لمتطلبات خارطة طريقكم.',
                ],
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['order' => $faq['order']], $faq);
        }

        // Output Admin Account Details
        if ($this->command) {
            $this->command->newLine();
            $this->command->info('====================================================');
            $this->command->info('           ADMIN CREDENTIALS AFTER SEEDING          ');
            $this->command->info('====================================================');
            $this->command->table(
                ['Field', 'Value'],
                [
                    ['Name', $adminUser->name],
                    ['Email', $adminUser->email],
                    ['Password', $adminPasswordPlain],
                    ['Role', $adminUser->role],
                    ['Status', $adminUser->is_active ? 'Active' : 'Inactive'],
                    ['Login URL', '/login or /admin/login'],
                ]
            );
            $this->command->newLine();
        }
    }
}
