<?php
/**
 * Unit tests for Sophia Chat plugin core functionality.
 */

use PHPUnit\Framework\TestCase;

class SophiaChatTest extends TestCase
{
    protected function setUp(): void
    {
        sophia_test_reset();
    }

    /**
     * Test sophia_chat_should_display() with 'all' visibility mode.
     */
    public function test_should_display_all_mode()
    {
        update_option('sophia_chat_visibility', 'all');

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'homepage' mode on front page.
     */
    public function test_should_display_homepage_mode_on_front_page()
    {
        update_option('sophia_chat_visibility', 'homepage');
        $GLOBALS['sophia_test_page_state']['is_front_page'] = true;

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'homepage' mode on home page.
     */
    public function test_should_display_homepage_mode_on_home()
    {
        update_option('sophia_chat_visibility', 'homepage');
        $GLOBALS['sophia_test_page_state']['is_home'] = true;

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'homepage' mode on other page.
     */
    public function test_should_display_homepage_mode_on_other_page()
    {
        update_option('sophia_chat_visibility', 'homepage');
        $GLOBALS['sophia_test_page_state']['is_front_page'] = false;
        $GLOBALS['sophia_test_page_state']['is_home'] = false;

        $this->assertFalse(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'specific' mode - empty IDs.
     */
    public function test_should_display_specific_mode_empty_ids()
    {
        update_option('sophia_chat_visibility', 'specific');
        update_option('sophia_chat_page_ids', '');

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'specific' mode - matching page.
     */
    public function test_should_display_specific_mode_matching_page()
    {
        update_option('sophia_chat_visibility', 'specific');
        update_option('sophia_chat_page_ids', '42, 100, 200');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 42;
        $GLOBALS['sophia_test_page_state']['is_page'] = true;

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'specific' mode - non-matching page.
     */
    public function test_should_display_specific_mode_non_matching_page()
    {
        update_option('sophia_chat_visibility', 'specific');
        update_option('sophia_chat_page_ids', '42, 100, 200');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 99;
        $GLOBALS['sophia_test_page_state']['is_page'] = true;

        $this->assertFalse(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'exclude' mode - empty IDs.
     */
    public function test_should_display_exclude_mode_empty_ids()
    {
        update_option('sophia_chat_visibility', 'exclude');
        update_option('sophia_chat_exclude_ids', '');

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'exclude' mode - excluded page.
     */
    public function test_should_display_exclude_mode_excluded_page()
    {
        update_option('sophia_chat_visibility', 'exclude');
        update_option('sophia_chat_exclude_ids', '42, 100');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 42;
        $GLOBALS['sophia_test_page_state']['is_page'] = true;

        $this->assertFalse(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with 'exclude' mode - non-excluded page.
     */
    public function test_should_display_exclude_mode_non_excluded_page()
    {
        update_option('sophia_chat_visibility', 'exclude');
        update_option('sophia_chat_exclude_ids', '42, 100');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 99;
        $GLOBALS['sophia_test_page_state']['is_page'] = false;
        $GLOBALS['sophia_test_page_state']['is_single'] = false;

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_should_display() with default (unknown) mode.
     */
    public function test_should_display_default_mode()
    {
        update_option('sophia_chat_visibility', 'unknown_mode');

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test sophia_chat_get_icons() returns expected array.
     */
    public function test_get_icons_returns_array()
    {
        $icons = sophia_chat_get_icons();

        $this->assertIsArray($icons);
        $this->assertArrayHasKey('1', $icons);
        $this->assertArrayHasKey('25', $icons);
        $this->assertCount(20, $icons);
    }

    /**
     * Test sophia_chat_get_icon_url() with valid icon key.
     */
    public function test_get_icon_url_valid_key()
    {
        update_option('sophia_chat_icon', '6');

        $url = sophia_chat_get_icon_url();

        $this->assertStringContainsString('Sophia_6.png', $url);
    }

    /**
     * Test sophia_chat_get_icon_url() with 'none' option.
     */
    public function test_get_icon_url_none()
    {
        update_option('sophia_chat_icon', 'none');

        $url = sophia_chat_get_icon_url();

        $this->assertEmpty($url);
    }

    /**
     * Test sophia_chat_get_icon_url() with custom URL.
     */
    public function test_get_icon_url_custom()
    {
        update_option('sophia_chat_icon', 'custom');
        update_option('sophia_chat_custom_icon_url', 'https://example.com/my-icon.png');

        $url = sophia_chat_get_icon_url();

        $this->assertEquals('https://example.com/my-icon.png', $url);
    }

    /**
     * Test sophia_chat_get_icon_url() with invalid key falls back to default.
     */
    public function test_get_icon_url_invalid_key_fallback()
    {
        update_option('sophia_chat_icon', '999');

        $url = sophia_chat_get_icon_url();

        $this->assertStringContainsString('Sophia_1.png', $url);
    }

    /**
     * Test sophia_chat_get_icon_url() with default option.
     */
    public function test_get_icon_url_default()
    {
        // No option set, should use default '1'
        $url = sophia_chat_get_icon_url();

        $this->assertStringContainsString('Sophia_1.png', $url);
    }

    /**
     * Test page ID parsing with spaces.
     */
    public function test_page_id_parsing_with_spaces()
    {
        update_option('sophia_chat_visibility', 'specific');
        update_option('sophia_chat_page_ids', '  42 ,  100 , 200  ');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 100;
        $GLOBALS['sophia_test_page_state']['is_page'] = true;

        $this->assertTrue(sophia_chat_should_display());
    }

    /**
     * Test page ID parsing converts strings to integers.
     */
    public function test_page_id_parsing_converts_to_int()
    {
        update_option('sophia_chat_visibility', 'specific');
        update_option('sophia_chat_page_ids', '42abc, xyz100');
        $GLOBALS['sophia_test_page_state']['current_page_id'] = 42;
        $GLOBALS['sophia_test_page_state']['is_page'] = true;

        $this->assertTrue(sophia_chat_should_display());
    }
}
