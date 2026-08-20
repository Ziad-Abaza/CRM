<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SettingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(SettingService::class);
    }

    public function test_can_set_and_get_setting_with_type_casting(): void
    {
        $this->service->set('site_name', 'Apex Corporate Solutions', 'branding', 'string');
        $this->service->set('maintenance_mode', false, 'system', 'boolean');
        $this->service->set('max_users', 150, 'system', 'integer');
        $this->service->set('social_links', ['twitter' => '@apex', 'linkedin' => 'apexcorp'], 'branding', 'json');

        $this->assertSame('Apex Corporate Solutions', $this->service->get('site_name'));
        $this->assertFalse($this->service->get('maintenance_mode'));
        $this->assertSame(150, $this->service->get('max_users'));
        $this->assertSame(['twitter' => '@apex', 'linkedin' => 'apexcorp'], $this->service->get('social_links'));
    }

    public function test_returns_default_when_key_does_not_exist(): void
    {
        $this->assertNull($this->service->get('non_existent_key'));
        $this->assertSame('fallback_val', $this->service->get('non_existent_key', 'fallback_val'));
    }

    public function test_can_get_group_settings(): void
    {
        $this->service->set('contact_phone', '+1 (555) 019-2834', 'contact', 'string');
        $this->service->set('contact_whatsapp', '+15550192834', 'contact', 'string');
        $this->service->set('site_title', 'Apex', 'branding', 'string');

        $contactSettings = $this->service->getGroup('contact');

        $this->assertCount(2, $contactSettings);
        $this->assertArrayHasKey('contact_phone', $contactSettings);
        $this->assertArrayHasKey('contact_whatsapp', $contactSettings);
        $this->assertArrayNotHasKey('site_title', $contactSettings);
        $this->assertSame('+1 (555) 019-2834', $contactSettings['contact_phone']);
    }

    public function test_can_set_many_settings_and_clear_cache(): void
    {
        $this->service->setMany([
            'hero_title' => 'Transforming Enterprise Operations',
            'hero_badge' => 'Verified Global Leader',
            'hero_rating' => 5,
        ], 'hero');

        $this->assertSame('Transforming Enterprise Operations', $this->service->get('hero_title'));
        $this->assertSame('Verified Global Leader', $this->service->get('hero_badge'));
        $this->assertSame(5, $this->service->get('hero_rating'));
    }

    public function test_can_forget_setting(): void
    {
        $this->service->set('temp_key', 'temporary_value');
        $this->assertSame('temporary_value', $this->service->get('temp_key'));

        $this->service->forget('temp_key');
        $this->assertNull($this->service->get('temp_key'));
        $this->assertDatabaseMissing('settings', ['key' => 'temp_key']);
    }

    public function test_cache_is_utilized_and_cleared_on_mutation(): void
    {
        Setting::create([
            'key' => 'cached_item',
            'value' => 'first_value',
            'group' => 'general',
            'type' => 'string',
            'is_public' => true,
        ]);

        $this->assertSame('first_value', $this->service->get('cached_item'));

        // Direct DB update without service
        Setting::where('key', 'cached_item')->update(['value' => 'updated_in_db']);

        // Cached value should still be returned
        $this->assertSame('first_value', $this->service->get('cached_item'));

        // Clearing cache should load the fresh DB value
        $this->service->clearCache();
        $this->assertSame('updated_in_db', $this->service->get('cached_item'));
    }

    public function test_global_setting_helper_works(): void
    {
        $this->service->set('company_tagline', 'Empowering Tomorrow', 'branding', 'string');

        // Test getter
        $this->assertSame('Empowering Tomorrow', setting('company_tagline'));
        $this->assertSame('Default Fallback', setting('unknown_setting', 'Default Fallback'));

        // Test service instance retrieval when called without args
        $this->assertInstanceOf(SettingService::class, setting());

        // Test setter array
        setting(['batch_key_1' => 'batch_val_1', 'batch_key_2' => 'batch_val_2']);
        $this->assertSame('batch_val_1', setting('batch_key_1'));
        $this->assertSame('batch_val_2', setting('batch_key_2'));
    }
}
