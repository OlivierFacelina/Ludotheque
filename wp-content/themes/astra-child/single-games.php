<?php 
    get_header();
    // Récupération des valeurs des champs personnalisés
    $release_date = get_post_meta(get_the_ID(), 'wpcfrelease_date', true);
    $players = get_post_meta(get_the_ID(), 'wpcfplayers', true);
    $min_age = get_post_meta(get_the_ID(), 'wpcfmin_age', true);
    $duration = get_post_meta(get_the_ID(), 'wpcfduration', true);
    $price = get_post_meta(get_the_ID(), 'wpcfprice', true); 
    $rules = get_post_meta(get_the_ID(), 'wpcfrules', true);
    $thematics = get_the_terms(get_the_ID(), 'thematique');
    $mechanics = get_the_terms(get_the_ID(), 'mecanique');
    $collaborators = unserialize(get_post_meta($post->ID, 'wpcfcollaborators', true));
?>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

<div class="single-game-card">
    <div class="game-image">
        <?php the_post_thumbnail(); ?>
        <h2><?php the_title(); ?></h2>
    </div>
    <div class="game-details">
        <p><strong>Date de sortie:</strong> <?= $release_date; ?></p>
        <p><strong>Nombre de joueurs:</strong> <?= $players; ?></p>
        <p><strong>Age minimum:</strong> <?= $min_age; ?></p>
        <p><strong>Durée approximative du jeu:</strong> <?= $duration; ?></p>
        <p><strong>Prix:</strong> <?= $price; ?></p>
        <p><strong>Thématique:</strong> 
            <?php foreach ($thematics as $thematic) { ?>
                <?= $thematic->name ?>  
            <?php }?>
        </p>
        <p><strong>Mécanique:</strong> 
            <?php foreach ($mechanics as $mechanic) { ?>
                <?= $mechanic->name . ', ' ?>  
            <?php }?>
        </p>
    </div>
</div>

<div class="single-game-content">
    <section class="description">
        <!-- Contenu de la section description -->
        <h2>Description</h2>
        <?php the_content() ?>
    </section>
    
    <section class="rules">
        <h2>Règles</h2>
        <p><?= $rules ?></p>
    </section>
</div>
<section class="collaborators">
    <h2>Collaborateurs</h2>
    <?php 
    if (!empty($collaborators)) {
        foreach ($collaborators as $collaborator_id) { 
            $collaborator = get_post($collaborator_id);
            $collaborator_name = $collaborator->post_title;
            $collaborator_type = wp_get_post_terms($collaborator_id, 'roles');
            ?>
            <div>
                <p><strong>Nom du collaborateur :</strong> <?= $collaborator_name ?></p>
                <?= get_the_post_thumbnail($collaborator_id, 'thumbnail') ?>
                <?php if (!empty($collaborator_type)) { ?>
                    <p><strong>Rôle :</strong> <?= $collaborator_type[0]->name ?></p>
                <?php } ?>
            </div>
            <?php
        }
    } else { ?>
        <?= "Aucun collaborateur associé" ?>
    <?php } ?>
</section>
<section class="comments">
    <h2>Commentaires</h2>
    <?php comments_template(); ?>
</section>
<section class="rating">
    <div class="rating">
        <span class="star" data-value="1">&#9734;</span>
        <span class="star" data-value="2">&#9734;</span>
        <span class="star" data-value="3">&#9734;</span>
        <span class="star" data-value="4">&#9734;</span>
        <span class="star" data-value="5">&#9734;</span>
    </div>

    <input type="hidden" name="rating" id="rating" value="0">
</section>

