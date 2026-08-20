<?php

namespace Tests\Feature;

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
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_all_tables_with_correct_company_data(): void
    {
        $this->seed(DatabaseSeeder::class);

        // 1. Verify Admin User
        $admin = User::where('email', 'admin@apexcorporate.com')->first();
        $this->assertNotNull($admin);
        $this->assertSame('Apex Admin', $admin->name);
        $this->assertSame('admin', $admin->role);
        $this->assertTrue($admin->is_active);
        $this->assertTrue(Hash::check('Admin@Secure2026!', $admin->password));

        // 2. Verify Dynamic Settings
        $this->assertSame('Apex Corporate Solutions', setting('site_name'));
        $this->assertSame('+15550192834', setting('whatsapp_number'));
        $this->assertCount(6, setting()->getGroup('branding'));

        // 3. Verify Services
        $this->assertGreaterThanOrEqual(5, Service::count());
        $this->assertDatabaseHas('services', [
            'slug' => 'enterprise-digital-modernization',
            'is_active' => true,
        ]);
        $activeServices = Service::active()->get();
        $this->assertGreaterThanOrEqual(5, $activeServices->count());

        // 4. Verify Pricing Plans
        $this->assertCount(3, PricingPlan::all());
        $this->assertDatabaseHas('pricing_plans', [
            'slug' => 'operational-growth',
            'is_featured' => true,
        ]);

        // 5. Verify Portfolio Categories and Items
        $this->assertCount(3, PortfolioCategory::all());
        $this->assertGreaterThanOrEqual(4, Portfolio::count());
        $this->assertDatabaseHas('portfolios', [
            'slug' => 'fintech-core-migration-vantage-capital',
            'is_featured' => true,
        ]);

        // 6. Verify Testimonials
        $this->assertCount(4, Testimonial::all());
        $firstTestimonial = Testimonial::where('order', 1)->first();
        $this->assertNotNull($firstTestimonial);
        $this->assertSame('Eleanor Vance', $firstTestimonial->client_name);
        $this->assertSame(5, $firstTestimonial->rating);

        // 7. Verify Team Members
        $this->assertCount(4, TeamMember::all());
        $firstMember = TeamMember::where('order', 1)->first();
        $this->assertNotNull($firstMember);
        $this->assertSame('David Sterling', $firstMember->name);
        $this->assertSame('Managing Partner & Head of Strategy', $firstMember->role);

        // 8. Verify Stats
        $this->assertCount(4, StatsCounter::all());
        $firstStat = StatsCounter::where('order', 1)->first();
        $this->assertNotNull($firstStat);
        $this->assertSame('Capital Assets Advised', $firstStat->label);
        $this->assertSame('$1.8B+', $firstStat->value);

        // 9. Verify FAQs
        $this->assertCount(6, Faq::all());
        $this->assertDatabaseHas('faqs', [
            'category' => 'Engagement & Strategy',
        ]);
    }
}
