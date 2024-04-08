<?php
get_header();

// Récupération des valeurs des champs personnalisés
$collaborator_games = get_post_meta(get_the_ID(), 'wpcfgames', true);
// var_dump($collaborator_games);

?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

<div class="single-collaborator-card">
    <div class="collaborator-image">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
    </div>
</div>

<?php // Vérification si des jeux sont associés au collaborateur
// if (!empty($games)) {
    ?>
    <section class="games-affiliated">
        <h2>Jeux affiliés</h2>
        <div class="collaborators-list">
        <?php
            // Récupérer les jeux associés au collaborateur
            if (!empty($collaborator_games)) { ?>
                <div class="project-collab-card">
                    <?php foreach ($collaborator_games as $game_id) {
                        $game_title = get_the_title($game_id);
                        $game_link = get_permalink($game_id); 
                        $game_thumbnail = get_the_post_thumbnail($game_id, 'thumbnail'); ?>
                        <div class="game-card">
                            <a href="<?= $game_link ?>">
                                <?= $game_thumbnail ?>
                                <h3><?= $game_title ?></h3>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <p>Aucun jeu affilié à ce collaborateur.</p>
            <?php }
            ?>
        </div>
    </section>
    <?php

get_footer();
?>
