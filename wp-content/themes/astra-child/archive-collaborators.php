<?php get_header(); 
$price = get_post_meta(get_the_ID(), 'wpcfprice', true); 
?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

<form role="search" method="get" id="search-form">
    <input type="text" value="" id="search-input" placeholder="Recherchez...">
</form>

<h1 class="site__heading">
<?php post_type_archive_title(); ?>
</h1>
<main class="site__game">
    <?php if (have_posts()) :
    while (have_posts()) : the_post(); ?>
    <div class="project-card">
        <a href="<?php the_permalink(); ?>" class="project-card__link">
            <div class="project-card__image">
                <?php the_post_thumbnail(); ?>
            </div>
            <div class="project-card__content">
                <h2 class="project-card__title"><?php the_title(); ?></h2>
                <div class="project-card__excerpt">
                    <p>
                        Role
                    </p>
                </div>
            </div>
        </a>
    </div>
    <?php endwhile;
    endif; ?>
</main>
<?php the_posts_pagination(); ?>
<?php get_footer(); ?>