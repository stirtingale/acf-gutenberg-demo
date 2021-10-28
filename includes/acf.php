<?php 

	/* ========================================================================================================================
	
	ACF Options
	
	======================================================================================================================== */

	// if( function_exists('acf_add_options_page') ) {
		
	// 	acf_add_options_page(array(
	// 		'page_title' 	=> 'Theme General Settings',
	// 		'menu_title'	=> 'Theme Settings',
	// 		'menu_slug' 	=> 'theme-general-settings',
	// 		'capability'	=> 'edit_posts',
	// 		'redirect'		=> false
	// 	));
		
	// 	acf_add_options_sub_page(array(
	// 		'page_title' 	=> 'Theme Header Settings',
	// 		'menu_title'	=> 'Header',
	// 		'parent_slug'	=> 'theme-general-settings',
	// 	));
		
	// 	acf_add_options_sub_page(array(
	// 		'page_title' 	=> 'Theme Footer Settings',
	// 		'menu_title'	=> 'Footer',
	// 		'parent_slug'	=> 'theme-general-settings',
	// 	));
		
	// }

	/* ========================================================================================================================
	
	ACF JSON
	
	======================================================================================================================== */
 
	add_filter('acf/settings/save_json', 'my_acf_json_save_point');
	function my_acf_json_save_point( $path ) {
	    // update path
	    $path = get_stylesheet_directory() . '/acf-json';
	    // return
	    return $path;
	}

	add_filter('acf/settings/load_json', 'my_acf_json_load_point');

	function my_acf_json_load_point( $paths ) {
	    // remove original path (optional)
	    unset($paths[0]);
	    // append path
	    $paths[] = get_stylesheet_directory() . '/acf-json';
	    // return
	    return $paths;
	}

	/* ========================================================================================================================
	
	Hide Backend
	
	======================================================================================================================== */

	add_filter('acf/settings/show_admin', 'my_acf_show_admin');

	function my_acf_show_admin( $show ) { 
		// where X equals tjhole user id
		if ( get_current_user_id() == "1" ){
			return true; // show it
		}
		else {
			return false; // hide it
		}

	}

	/* ========================================================================================================================
	
	MAKE GUTENBERG WIDER
	
	======================================================================================================================== */

	function custom_admin_css() {
		echo '<style type="text/css">
		.wp-block { max-width: 960px; }
		</style>';
	}
	add_action('admin_head', 'custom_admin_css');
	

	/* ========================================================================================================================
	
	CREATE BLOCK CATS
	
	======================================================================================================================== */

	function custom_blocks_custom( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'custom',
					'title' => __( 'Custom Blocks', 'custom' ),
				),
				// array(
				// 	'slug' => 'next',
				// 	'title' => __( 'Next', 'next' ),
				// )
			)
		);
	}
	add_filter( 'block_categories_all', 'custom_blocks_custom', 10, 2);


	/* ========================================================================================================================
	
	SETUP BLOCKS
	
	======================================================================================================================== */

	// restrict block types	
	add_filter( 'allowed_block_types_all', 'acf_restrict_default_block_types' );

	// allow our block types		 
	function acf_restrict_default_block_types( $allowed_blocks ) {
		
		global $post;
		
		$allowed_blocks = array(
			'core/image',
			'core/paragraph',
			'core/heading',
			'core/list',
			'core/code',
			'core/html',
			'core/columns',
			'acf/block1'
		);
		
		// allow only for specific posts types

		if( $post->post_type === 'page'  ) {
			$allowed_blocks[] = 'acf/block2';
		}
	 
		return $allowed_blocks;

	}

	/* ========================================================================================================================
	
	BLOCK 1
	
	======================================================================================================================== */

	add_action('acf/init', 'block_block1');
	function block_block1() {

	    // check function exists.
	    if( function_exists('acf_register_block_type') ) {

	        acf_register_block_type(array(
	            'name'              => 'block1',
	            'title'             => __('Block 1'),
				'icon' => '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 15.628c0-.713-.154-1.919-1.191-1.98-.493-.03-.89-.414-.936-.904-.055-.581-.186-1.184-.476-1.744h-10.793c-.29.56-.421 1.163-.476 1.743-.046.49-.443.874-.936.904-1.037.062-1.192 1.268-1.192 1.981 0 .316.333 1.613 1.331 1.963.284.1.508.322.61.605.966 2.694 3.628 4.804 6.059 4.804 2.552 0 5.195-2.499 6.063-4.834.108-.29.344-.515.641-.606 1.07-.332 1.296-1.68 1.296-1.932zm-13-7.229v1.601h3v-1.5c0-.276.224-.5.5-.5s.5.224.5.5v1.5h2v-1.5c0-.276.225-.5.5-.5s.5.224.5.5v1.5h3v-1.647c.244-.058 3-.439 3-3.068 0-1.994-1.753-3.58-3.875-3.58-.806 0-1.278.198-1.941.428-1.137-1.123-1.63-1.133-2.184-1.133-.482 0-1.038.002-2.184 1.133-.68-.235-1.134-.428-1.941-.428-2.122 0-3.875 1.586-3.875 3.58 0 2.456 2.662 3.013 3 3.114zm14 7.229c0 .67-.453 2.407-2 2.887-1.023 2.754-3.999 5.485-7 5.485s-5.957-2.557-7-5.466c-1.52-.532-2-2.301-2-2.906 0-1.509.603-2.888 2.132-2.979.098-1.038.412-1.855.868-2.528v-.977c-1.825-.546-3-2.239-3-3.859 0-2.528 2.185-4.58 4.875-4.58.591 0 1.157.099 1.681.28.615-.607 1.483-.985 2.444-.985.961 0 1.828.378 2.443.985.525-.181 1.091-.28 1.682-.28 2.69 0 4.875 2.052 4.875 4.58 0 1.62-1.229 3.442-3 3.859v.976c.456.675.771 1.492.868 2.529 1.527.091 2.132 1.462 2.132 2.979zm-9 1.688c-1.9-1.287-1.351 1.854-4 .566.4 1.78 2.805 2.082 4 1.009 1.195 1.073 3.6.771 4-1.009-2.648 1.289-2.1-1.852-4-.566zm3-4.316c-.552 0-1 .525-1 1.174 0 .647.448 1.174 1 1.174s1-.527 1-1.174c0-.649-.448-1.174-1-1.174zm-5 1.174c0 .647-.448 1.174-1 1.174s-1-.527-1-1.174c0-.649.448-1.174 1-1.174s1 .525 1 1.174z"/></svg>',
	            'render_template'   => 'blocks/block1.php',
	            'category'          => 'custom',
				// allow only edit (comment out if you want to write backend render for blocks)
	            'mode'				=> 'edit',
	            'supports' => array(
		            'align' => false,
		            'multiple' => true,
	            ),
				// enable thumbnail
				'example'  => array(
					'attributes' => array(
						'mode' => 'preview',
						'data' => array(
							'preview_image_help' => true,
						)
					)
				)
	        ));
	    }
	}

	/* ========================================================================================================================
	
	BLOCK 2
	
	======================================================================================================================== */

	add_action('acf/init', 'block_block2');
	function block_block2() {

	    // check function exists.
	    if( function_exists('acf_register_block_type') ) {

	        acf_register_block_type(array(
	            'name'              => 'block2',
	            'title'             => __('Block 2'),
				'icon' => '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M8.742 2.397c.82-.861 1.977-1.397 3.258-1.397 1.282 0 2.439.536 3.258 1.397.699-.257 1.454-.397 2.242-.397 3.587 0 6.5 2.912 6.5 6.5 0 2.299-1.196 4.321-3 5.476v9.024h-18v-9.024c-1.803-1.155-3-3.177-3-5.476 0-3.588 2.913-6.5 6.5-6.5.788 0 1.543.14 2.242.397zm6.258 19.603h5v-7.505c-.715.307-1.38.47-1.953.525-.274.026-.518-.176-.545-.45-.025-.276.176-.52.451-.545 1.388-.132 5.047-1.399 5.047-5.525 0-3.036-2.465-5.5-5.5-5.5-1.099 0-1.771.29-2.512.563-1.521-1.596-2.402-1.563-2.988-1.563-.595 0-1.474-.026-2.987 1.563-.787-.291-1.422-.563-2.513-.563-3.035 0-5.5 2.464-5.5 5.5 0 4.13 3.663 5.394 5.048 5.525.274.025.476.269.45.545-.026.274-.27.476-.545.45-.573-.055-1.238-.218-1.953-.525v7.505h5v-3.5c0-.311.26-.5.5-.5.239 0 .5.189.5.5v3.5h4v-3.5c0-.311.26-.5.5-.5s.5.189.5.5v3.5z"/></svg>',
	            'render_template'   => 'blocks/block2.php',
	            'category'          => 'custom',
				// allow only edit (comment out if you want to write backend render for blocks)
	            'mode'				=> 'edit',
	            'supports' => array(
		            'align' => false,
		            'multiple' => true,
	            ),
				// enable thumbnail
				'example'  => array(
					'attributes' => array(
						'mode' => 'preview',
						'data' => array(
							'preview_image_help' => true,
						)
					)
				)
	        ));
	    }
	}