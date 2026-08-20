<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\StatsCounter;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'email' => 'admin@corporate.test',
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_guest_is_redirected_away_from_content_crud(): void
    {
        $this->get(route('admin.services.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.portfolio.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.pricing.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.testimonials.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.team.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.stats.index'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.faqs.index'))->assertRedirect(route('admin.login'));
    }

    // 1. Services Tests
    public function test_service_crud_and_image_upload_and_toggle_and_audit(): void
    {
        Storage::fake('public');

        // Create
        $image = UploadedFile::fake()->image('service.jpg');
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Cloud Migration Advisory',
            'short_description' => 'End-to-end multi-cloud advisory and architecture.',
            'description' => 'Comprehensive multi-phase assessment, refactor, and migration pipelines.',
            'icon' => 'cloud',
            'image' => $image,
            'features' => ['AWS / GCP / Azure', 'Zero-downtime cutover'],
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'title' => 'Cloud Migration Advisory',
            'slug' => 'cloud-migration-advisory',
            'order' => 1,
            'is_active' => true,
        ]);

        $service = Service::where('slug', 'cloud-migration-advisory')->firstOrFail();
        $this->assertEquals(['AWS / GCP / Azure', 'Zero-downtime cutover'], $service->features);
        $this->assertNotNull($service->image);

        // Audit check
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->admin->id,
            'action' => 'create_service',
            'auditable_type' => Service::class,
            'auditable_id' => $service->id,
        ]);

        // Update
        $updateResp = $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title' => 'Cloud Modernization Advisory',
            'short_description' => 'Updated short description.',
            'features' => ['Enhanced SLA', 'Kubernetes Orchestration'],
            'is_active' => '1',
        ]);

        $updateResp->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'title' => 'Cloud Modernization Advisory',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->admin->id,
            'action' => 'update_service',
            'auditable_id' => $service->id,
        ]);

        // Toggle
        $toggleResp = $this->actingAs($this->admin)->patch(route('admin.services.toggle', $service));
        $toggleResp->assertRedirect();
        $this->assertFalse($service->fresh()->is_active);

        // Delete
        $deleteResp = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));
        $deleteResp->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->admin->id,
            'action' => 'delete_service',
            'auditable_id' => $service->id,
        ]);
    }

    public function test_service_validation_errors(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => '',
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    // 2. Portfolio & Categories Tests
    public function test_portfolio_and_categories_crud_and_audit(): void
    {
        Storage::fake('public');

        // Category Store
        $catResp = $this->actingAs($this->admin)->post(route('admin.portfolio.categories.store'), [
            'name' => 'Financial Technology',
            'description' => 'Fintech and banking transformations',
            'order' => 1,
        ]);
        $catResp->assertRedirect(route('admin.portfolio.categories'));
        $category = PortfolioCategory::where('slug', 'financial-technology')->firstOrFail();

        // Portfolio Store
        $image = UploadedFile::fake()->image('case.png');
        $portResp = $this->actingAs($this->admin)->post(route('admin.portfolio.store'), [
            'category_id' => $category->id,
            'title' => 'Global Payments Infrastructure Rebuild',
            'client' => 'FinCorp International',
            'completion_date' => '2026-06-15',
            'summary' => 'Scaled transaction throughput by 400%',
            'content' => 'Complete core banking microservices rewrite.',
            'image' => $image,
            'technologies' => ['PHP 8.3', 'Laravel 11', 'PostgreSQL', 'Redis'],
            'website_url' => 'https://fincorp.test',
            'is_featured' => '1',
            'is_active' => '1',
            'order' => 2,
        ]);

        $portResp->assertRedirect(route('admin.portfolio.index'));
        $portfolio = Portfolio::where('slug', 'global-payments-infrastructure-rebuild')->firstOrFail();
        $this->assertTrue($portfolio->is_featured);
        $this->assertEquals(['PHP 8.3', 'Laravel 11', 'PostgreSQL', 'Redis'], $portfolio->technologies);

        // Update
        $this->actingAs($this->admin)->put(route('admin.portfolio.update', $portfolio), [
            'title' => 'Global Payments Infrastructure Modernization',
            'category_id' => $category->id,
            'technologies' => ['PHP 8.3', 'AWS ECS'],
            'is_featured' => '0',
            'is_active' => '1',
        ])->assertRedirect(route('admin.portfolio.index'));

        $this->assertDatabaseHas('portfolios', [
            'id' => $portfolio->id,
            'title' => 'Global Payments Infrastructure Modernization',
            'is_featured' => false,
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.portfolio.toggle', $portfolio))->assertRedirect();
        $this->assertFalse($portfolio->fresh()->is_active);

        // Delete Portfolio
        $this->actingAs($this->admin)->delete(route('admin.portfolio.destroy', $portfolio))->assertRedirect(route('admin.portfolio.index'));
        $this->assertDatabaseMissing('portfolios', ['id' => $portfolio->id]);

        // Delete Category
        $this->actingAs($this->admin)->delete(route('admin.portfolio.categories.destroy', $category))->assertRedirect(route('admin.portfolio.categories'));
        $this->assertDatabaseMissing('portfolio_categories', ['id' => $category->id]);
    }

    // 3. Pricing Plan Tests
    public function test_pricing_plan_crud_and_audit(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.pricing.store'), [
            'name' => 'Enterprise Architecture Retainer',
            'price' => '4999.00',
            'currency' => 'USD',
            'billing_period' => 'month',
            'description' => 'Dedicated fractional CTO & systems engineering squad.',
            'features' => ['Weekly Sprint Planning', 'SOC2 Architecture Audit', 'Unlimited Repositories'],
            'is_featured' => '1',
            'is_active' => '1',
            'order' => 1,
            'whatsapp_message' => 'Hello, I want to reserve the Enterprise Architecture Retainer.',
        ]);

        $response->assertRedirect(route('admin.pricing.index'));
        $plan = PricingPlan::where('slug', 'enterprise-architecture-retainer')->firstOrFail();
        $this->assertEquals(4999.00, $plan->price);
        $this->assertTrue($plan->is_featured);

        // Audit Log Check
        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->admin->id,
            'action' => 'create_pricing_plan',
            'auditable_id' => $plan->id,
        ]);

        // Update
        $this->actingAs($this->admin)->put(route('admin.pricing.update', $plan), [
            'name' => 'Enterprise Architecture Retainer Plus',
            'price' => '5999.00',
            'currency' => 'USD',
            'billing_period' => 'month',
            'features' => ['24/7 Priority Support'],
            'is_featured' => '0',
            'is_active' => '1',
        ])->assertRedirect(route('admin.pricing.index'));

        $this->assertDatabaseHas('pricing_plans', [
            'id' => $plan->id,
            'price' => 5999.00,
            'is_featured' => false,
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.pricing.toggle', $plan))->assertRedirect();
        $this->assertFalse($plan->fresh()->is_active);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.pricing.destroy', $plan))->assertRedirect(route('admin.pricing.index'));
        $this->assertDatabaseMissing('pricing_plans', ['id' => $plan->id]);
    }

    // 4. Testimonials Tests
    public function test_testimonial_crud_and_audit(): void
    {
        Storage::fake('public');

        $avatar = UploadedFile::fake()->image('ceo.jpg');
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'client_name' => 'Jonathan Reynolds',
            'client_role' => 'Chief Executive Officer',
            'company' => 'Acro Logistics',
            'avatar' => $avatar,
            'content' => 'Apex delivered an enterprise CRM transition ahead of schedule with flawless reliability.',
            'rating' => 5,
            'is_featured' => '1',
            'is_active' => '1',
            'order' => 1,
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $testimonial = Testimonial::where('client_name', 'Jonathan Reynolds')->firstOrFail();
        $this->assertEquals(5, $testimonial->rating);
        $this->assertNotNull($testimonial->avatar);

        // Update
        $this->actingAs($this->admin)->put(route('admin.testimonials.update', $testimonial), [
            'client_name' => 'Jonathan Reynolds',
            'client_role' => 'Executive Chairman',
            'company' => 'Acro Logistics Global',
            'content' => 'Updated testimonial content.',
            'rating' => 5,
            'is_featured' => '0',
            'is_active' => '1',
        ])->assertRedirect(route('admin.testimonials.index'));

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'client_role' => 'Executive Chairman',
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.testimonials.toggle', $testimonial))->assertRedirect();
        $this->assertFalse($testimonial->fresh()->is_active);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testimonial))->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    // 5. Team Members Tests
    public function test_team_member_crud_and_audit(): void
    {
        Storage::fake('public');

        $photo = UploadedFile::fake()->image('member.jpg');
        $response = $this->actingAs($this->admin)->post(route('admin.team.store'), [
            'name' => 'Elena Rostova',
            'role' => 'Head of Cloud Security',
            'bio' => 'Former Principal Security Engineer specializing in zero-trust architectures.',
            'photo' => $photo,
            'social_links' => [
                'linkedin' => 'https://linkedin.com/in/elena-rostova',
                'twitter' => 'https://twitter.com/elena_rostova',
            ],
            'email' => 'elena@apex.test',
            'phone' => '+15551234567',
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.team.index'));
        $member = TeamMember::where('email', 'elena@apex.test')->firstOrFail();
        $this->assertEquals('https://linkedin.com/in/elena-rostova', $member->social_links['linkedin']);

        // Update
        $this->actingAs($this->admin)->put(route('admin.team.update', $member), [
            'name' => 'Elena Rostova, Ph.D.',
            'role' => 'VP of Cloud Security',
            'email' => 'elena.rostova@apex.test',
            'is_active' => '1',
        ])->assertRedirect(route('admin.team.index'));

        $this->assertDatabaseHas('team_members', [
            'id' => $member->id,
            'name' => 'Elena Rostova, Ph.D.',
            'role' => 'VP of Cloud Security',
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.team.toggle', $member))->assertRedirect();
        $this->assertFalse($member->fresh()->is_active);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.team.destroy', $member))->assertRedirect(route('admin.team.index'));
        $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
    }

    // 6. Stats Counter Tests
    public function test_stats_counter_crud_and_audit(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.stats.store'), [
            'label' => 'Enterprise System Migrations',
            'value' => '350',
            'suffix' => '+',
            'icon' => 'server-stack',
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.stats.index'));
        $stat = StatsCounter::where('label', 'Enterprise System Migrations')->firstOrFail();
        $this->assertEquals('350', $stat->value);

        // Update
        $this->actingAs($this->admin)->put(route('admin.stats.update', $stat), [
            'label' => 'Global Enterprise Migrations',
            'value' => '400',
            'suffix' => '+',
            'is_active' => '1',
        ])->assertRedirect(route('admin.stats.index'));

        $this->assertDatabaseHas('stats_counters', [
            'id' => $stat->id,
            'value' => '400',
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.stats.toggle', $stat))->assertRedirect();
        $this->assertFalse($stat->fresh()->is_active);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.stats.destroy', $stat))->assertRedirect(route('admin.stats.index'));
        $this->assertDatabaseMissing('stats_counters', ['id' => $stat->id]);
    }

    // 7. FAQs Tests
    public function test_faq_crud_and_audit(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
            'question' => 'What is the average turnaround for an enterprise architecture audit?',
            'answer' => 'Standard comprehensive infrastructure and code audit cycles are delivered within 10 business days.',
            'category' => 'Audit & Advisory',
            'order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $faq = Faq::where('category', 'Audit & Advisory')->firstOrFail();

        // Update
        $this->actingAs($this->admin)->put(route('admin.faqs.update', $faq), [
            'question' => 'What is the standard turnaround for an enterprise architecture audit?',
            'answer' => 'Audits are completed in 7-10 business days.',
            'category' => 'Advisory Services',
            'is_active' => '1',
        ])->assertRedirect(route('admin.faqs.index'));

        $this->assertDatabaseHas('faqs', [
            'id' => $faq->id,
            'category' => 'Advisory Services',
        ]);

        // Toggle
        $this->actingAs($this->admin)->patch(route('admin.faqs.toggle', $faq))->assertRedirect();
        $this->assertFalse($faq->fresh()->is_active);

        // Delete
        $this->actingAs($this->admin)->delete(route('admin.faqs.destroy', $faq))->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }
}
