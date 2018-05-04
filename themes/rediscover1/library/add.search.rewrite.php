<?php 
add_action( 'init', 'search_business_init' );
function search_business_init()
{
    add_rewrite_rule( 'searchbusiness$', 'index.php?search_submited=1', 'top' );
    add_rewrite_rule( 'businesslocations$', 'index.php?get_locations=1', 'top' );
    add_rewrite_rule( 'business-categories$', 'index.php?busines_categories=1', 'top' );
    add_rewrite_rule( 'contact-busines$', 'index.php?contact-busines=1', 'top' );
}

add_filter( 'query_vars', 'search_business_query_vars' );
function search_business_query_vars( $query_vars )
{
    $query_vars[] = 'search_submited';
    $query_vars[] = 'get_locations';
    $query_vars[] = 'busines_categories';
    $query_vars[] = 'contact-busines';
    return $query_vars;
}

add_action( 'parse_request', 'search_business_parse_request' );
function search_business_parse_request( &$wp )
{
    if ( array_key_exists( 'search_submited', $wp->query_vars ) ) {
        $load = locate_template('template-searchbusiness.php', true);
        if ($load) {
            exit(); // just exit if template was found and loaded
        }
   }
   if ( array_key_exists( 'get_locations', $wp->query_vars ) ) {
    $load = locate_template('library/business-locations.php', true);
    if ($load) {
      exit(); // just exit if template was found and loaded
    }
   }
   if ( array_key_exists( 'busines_categories', $wp->query_vars ) ) {
		$load = locate_template('business-categories.php', true);
		if ($load) {
			exit(); // just exit if template was found and loaded
		}
   }
   if ( array_key_exists( 'contact-busines', $wp->query_vars ) ) {
		$load = locate_template('contact-busines.php', true);
		if ($load) {
			exit(); // just exit if template was found and loaded
		}
   }
    return;
}