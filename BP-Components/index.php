<?php
/**
 * @package Buddypress Components
 * @version 1.0
 */
/*
Plugin Name: Buddypress Components
Plugin URI: http://shockoe.com
Description: Parent class for custom Buddypress components. Requires buddypress and buddypress-custom-posts
Author: Shockoe
Version: 1.0
Author URI: http://shockoe.com/
*/

	class BP_Components {
		var $name;
		var $singular;
		var $post_type;
		
		function __construct () {
			add_action( 'init', array(&$this, 'init') );
			
			$this->create_bp_component();
		}
		
		function init () {
			$this->add_posttype();
			$this->check_new_item();
		}
		
		function add_posttype () {
			register_post_type( $this->post_type,
				array(
					'labels' => array(
						'name' => __( $this->name ),
						'singular_name' => __( $this->singular )
					),
	
					'public' => true,
					'rewrite' => array('slug' => strtolower($this->name))
				)
			);
		}
		
		function create_bp_component () {
			//create a Buddypress component, similar to the default 'groups' or 'messages'
			//requires the buddypress-custom-posts plugin

		    $labels = Array(
		        'my_posts'         => 'My ' . $this->name . ' (%s)',
		        'posts_directory'    => $this->singular . ' Directory',
		        'name'            => $this->name,
		        'all_posts'        => 'All ' .  $this->name . ' (%s)',
		        'type_creator'        => $this->singular . ' Creator',
		        'activity_tab'        => $this->name,
		        'show_created'        => 'Show New ' . $this->name,
		        'my_posts_public_activity' => 'My ' . $this->name . ' - Public Activity'
		    );
            
		    $activity = Array(
		        'create_posts' => true,
		        'edit_posts' => true
		    );
            
		    $args = Array(
		        'id'        => $this->post_type,
		        'nav'        => true,
		        'theme_nav'    => true,
				'theme_dir' => get_bloginfo('stylesheet_directory') . "/{$this->post_type}",
		        'labels'    => $labels,
		        'activity'    => $activity,
		        'forum'        => false
		    );
            
			if (function_exists('bpcp_register_post_type')) {
				bpcp_register_post_type($args);
			}
		}
	}

?>