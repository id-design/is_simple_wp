<?php
/**
 * Homepage Control Hooks
 * @see  issimple_homepage_content()
 * @see  issimple_product_categories()
 * @see  issimple_recent_products()
 * @see  issimple_featured_products()
 * @see  issimple_popular_products()
 * @see  issimple_on_sale_products()
 */
add_action( 'homepage', 'issimple_homepage_content',        10 );
//add_action( 'homepage', 'issimple_product_categories',    20 );
//add_action( 'homepage', 'issimple_recent_products',       30 );
//add_action( 'homepage', 'issimple_featured_products',     40 );
//add_action( 'homepage', 'issimple_popular_products',      50 );
//add_action( 'homepage', 'issimple_on_sale_products',      60 );


if ( ! function_exists( 'issimple_homepage_content' ) ) {
    /**
     * Display homepage content
     * Hooked into the `homepage` action in the homepage template
     * @since  1.0.0
     * @return  void
     */
    function issimple_homepage_content() {
        // Include the page content template.
        get_template_part( 'content', 'page' );
        
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) comments_template();
    }
}