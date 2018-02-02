<?php

class TaghoundFunctionsTest extends WP_UnitTestCase {
	/**
	 * Make sure our upload only utility function works
	 */
	function test_upload_only_function_works() {
		$option_name = TMT_SETTING_PREFIX . 'upload_only';

		update_option( $option_name, '' );
		$this->assertFalse( tmt_is_upload_only() );

		update_option( $option_name, 'on' );
		$this->assertTrue( tmt_is_upload_only() );
	}

	public function test_tags_can_use_alternate_taxonomy() {
		$new_tax = 'my_dummy_taxonomy';

		// Override TMT's default slug
		add_filter( 'tmt_tag_taxonomy', array( $this, 'taxonomy_override' ) );

		$this->assertEquals($new_tax, tmt_get_tag_taxonomy());

		remove_filter( 'tmt_tag_taxonomy', array( $this, 'taxonomy_override' ) );
	}

	public function test_know_when_alternate_taxonomy_used() {
		$this->assertFalse(tmt_using_alternate_taxonomy());

		add_filter( 'tmt_tag_taxonomy', array( $this, 'taxonomy_override' ) );

		$this->assertTrue(tmt_using_alternate_taxonomy());

		remove_filter( 'tmt_tag_taxonomy', array( $this, 'taxonomy_override' ) );
	}

	public function taxonomy_override($slug) {
		return 'my_dummy_taxonomy';
	}
}
