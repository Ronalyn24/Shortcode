<?php 

/************************************************ 

CUSTOM SHORTCODE

Example: [post-shortcode post_type="post" category_name="category" single_cat_name="red" post_item="4"]

**************************************************/


function post_shortcode_function( $attr ) {
    
    ob_start();

        // define attributes and their defaults
        extract( shortcode_atts( array (
            'post_type'         => 'post Name',      
            'post_item'         => '3',
            'category_name'     => 'category',
            'single_cat_name'   => 'red',

        ), $attr ) );
     
        // define query parameters based on attributes

        $options = array(
            'post_type'      => $post_type,
            'posts_per_page' => $post_item,  
            'order'          => 'DESC',
            'orderby'        => 'date',
            'tax_query'      => array(
                                 array (
                                        'taxonomy' => $category_name,
                                         'field'   => 'slug',
                                         'terms'   => $single_cat_name,
                                     )
                  ),
        );
    
        $the_query = new WP_Query( $options );

        // run the loop based on the query
        if ( $the_query->have_posts() ) : 

    
            echo '<div class="row-info mr-row-full">';
    
                $count = 1; 
        
                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 
            
                        <div id="post-<?php echo $count;?>" class="mr-column info-wrapper">
            
                            <div class="post-item-ctn">

                                <div class="mr-column col-1-of-2 text-left inner-thumb">

                                    <?php the_post_thumbnail( 'medium', ['class' => 'people-image img-fluid'] ); ?>

                                </div>

                                <div class="mr-column col-1-of-2">

                                    <div class="mr-content text-right inner-info large-p">

                                        <h3><?php the_title();?></h3>

                                        <h5><?php the_field('headline');?></h5>

                                        <?php the_field('short_descriptions');?>

                                            <?php $people_items_link = get_field('link');

                                            if( $people_items_link ): 
                                                $people_items_link_url = $people_items_link['url'];
                                                $people_items_link_title = $people_items_link['title'];
                                                $people_items_link_target = $people_items_link['target'] ? $people_items_link['target'] : '_self'; ?>

                                                <a class="gen-btn" role="button" href="<?php echo esc_url( $people_items_link_url ); ?>" target="<?php echo esc_attr( $people_items_link_target ); ?>"><?php echo esc_html( $people_items_link_title ); ?></a>

                                            <?php endif; ?>

                                    </div><!-- .mr-content -->

                                </div>

                            </div><!-- .people-post-item-ctn -->  
            
                        </div><!-- .mr-column -->  
            
                <?php $count ++;
            
                    endwhile; 
    
            echo '</div>';
    
        endif; 
    
    wp_reset_postdata();

    $post_content =  ob_get_contents();

    ob_end_clean();

    return $post_content;
}
add_shortcode( 'post-shortcode', 'post_shortcode_function' ); ?>