<?php
/*
 * Contains modified code copied from and/or based on Divi
 * See the license.txt file in the root directory for more information and licenses
 */
get_header(); ?>

    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
                <div id="left-area">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            $post_format = et_pb_post_format(); ?>

                            <article id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post'); ?>>

                                <?php
                                $thumb = '';

                                $width = (int)apply_filters('et_pb_index_blog_image_width', 1080);

                                $height = (int)apply_filters('et_pb_index_blog_image_height', 675);
                                $classtext = 'et_pb_post_main_image';
                                $titletext = get_the_title();
                                $alttext = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                                $thumbnail = get_thumbnail($width, $height, $classtext, $alttext, $titletext, false, 'Blogimage');
                                $thumb = $thumbnail["thumb"];

                                et_divi_post_format_content();

                                if (!in_array($post_format, array('link', 'audio', 'quote'))) {
                                    if ('video' === $post_format && false !== ($first_video = et_get_first_video())) :
                                        printf(
                                            '<div class="et_main_video_container">
									%1$s
								</div>',
                                            et_core_esc_previously($first_video)
                                        );
                                    elseif (!in_array($post_format, array('gallery')) && 'on' === et_get_option('divi_thumbnails_index', 'on') && '' !== $thumb) : ?>
                                        <a class="entry-featured-image-url" href="<?php the_permalink(); ?>">
                                            <?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height); ?>
                                        </a>
                                    <?php
                                    elseif ('gallery' === $post_format) :
                                        et_pb_gallery_images();
                                    endif;
                                } ?>

                                <div class="post-content-wrapper">
                                    <?php if (!in_array($post_format, array('link', 'audio', 'quote'))) : ?>
                                    <?php if (!in_array($post_format, array('link', 'audio'))) : ?>
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <?php endif; ?>

                                    <?php
                                    et_divi_post_meta();

                                    if ('on' !== et_get_option('divi_blog_style', 'false') || (is_search() && ('on' === get_post_meta(get_the_ID(), '_et_pb_use_builder', true)))) {
                                        truncate_post(270);
                                    } else {
                                        the_content();
                                    }
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="more-link"><?php echo esc_html__('read more', 'divi_ecommerce'); ?></a>
                                </div>
                            <?php endif; ?>

                            </article> <!-- .et_pb_post -->
                        <?php
                        endwhile;

                        if (function_exists('wp_pagenavi'))
                            wp_pagenavi();
                        else
                            get_template_part('includes/navigation', 'index');
                    else :
                        get_template_part('includes/no-results', 'index');
                    endif;
                    ?>
                </div> <!-- #left-area -->

                <?php get_sidebar(); ?>
            </div> <!-- #content-area -->
        </div> <!-- .container -->
    </div> <!-- #main-content -->

<?php get_footer(); ?>