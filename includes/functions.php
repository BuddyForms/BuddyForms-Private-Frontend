<?php

add_action( 'pre_get_posts', 'buddyforms_private_frontend_filter_cpt_listing_by_author' );
function buddyforms_private_frontend_filter_cpt_listing_by_author( $wp_query_obj ) {
	global $bfpp_author_id;

	$bfpp_author_id = $wp_query_obj->get('author');

	$private_frontend_settings = get_option( 'buddyforms_private_frontend_settings' );

	$private_post_types = isset( $private_frontend_settings['post_types'] ) ? $private_frontend_settings['post_types'] : array();
	$private_forbidden_page = isset( $private_frontend_settings['forbidden_page'] ) ? $private_frontend_settings['forbidden_page'] : '';

	$this_post_type = $wp_query_obj->get('post_type');
	$page_id        = $wp_query_obj->get('page_id');

	if( $page_id == 0 && empty( $this_post_type ) ){
		$this_post_type = 'post';
	}

	// First let us check if this is a page. We not want to restrict pages
	if( !isset( $wp_query_obj->query ) || isset( $wp_query_obj->query['page'] ) && !empty($wp_query_obj->query['page']) || isset($wp_query_obj->query['post_type']) && 'page' == $wp_query_obj->query['post_type'] ){
		$this_post_type = 'page';
	}

	$restricted_post_type = false;
	foreach ( $private_post_types as $key => $private_post_type){
		if( $key == $this_post_type ){
			$restricted_post_type = true;
		}
	}

	if( $restricted_post_type ){

		if( ! is_user_logged_in() ) {
			$wp_query_obj->set('post_type', 'page' );
			$wp_query_obj->set('page_id', $private_forbidden_page );
			return $wp_query_obj;
		}

		// Let us get the logged in user
		$current_user = wp_get_current_user();
		// If the user is not administrator or can at lest delete posts show all posts
		if( !current_user_can( 'delete_plugins' ) ){
			return $wp_query_obj->set('author', $current_user->ID );
		}

	}
	return $wp_query_obj;

}

add_action( 'template_redirect', 'buddyforms_private_frontend_redirect_cpt_single_by_author' );
function buddyforms_private_frontend_redirect_cpt_single_by_author(){
	global $post, $bfpp_author_id;

	$private_frontend_settings = get_option( 'buddyforms_private_frontend_settings' );
	$private_post_types = isset( $private_frontend_settings['post_types'] ) ? $private_frontend_settings['post_types'] : array();
	$private_forbidden_page = isset( $private_frontend_settings['forbidden_page'] ) ? $private_frontend_settings['forbidden_page'] : '';

	$post_type_restricted = false;
	foreach ( $private_post_types as $key => $post_type ) {
		if( is_singular( $post_type ) ){
			$post_type_restricted = true;
		}
	}

	if( $post_type_restricted ){

		// Let us get the logged in user
		$current_user = wp_get_current_user();

		$author_id = get_post_field( 'post_author', $post->ID);

		if( $current_user->ID != $author_id ) {
			wp_redirect(get_the_permalink($private_forbidden_page));
		}

	}

}