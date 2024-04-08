<?php
function wp_enqueue_assets() {
    wp_enqueue_style(
    'parent-style',
    get_template_directory_uri() . '/style.css'
    );
    wp_enqueue_script(
        'ajax-search',
        get_stylesheet_directory_uri() . '/ajax-search.js',
        array(),
        false,
        true
    );
    wp_localize_script(
        'ajax-search', 
        'ajax-search_params', 
        array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'wp_enqueue_assets');
 
function games_post_types() {
    $labels = array(
        'name' => 'Jeu',
        'all_items' => 'Tous les jeux',
        'singular_name' => 'Jeu',
        'plural_name' => 'Jeux',
        'add_new_item' => 'Ajouter un jeu',
        'edit_item' => 'Modifier le jeu',
        'menu_name' => 'Jeu'
        );
        $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'comments', 'excerpt'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-buddicons-activity',
        'taxonomies' => array('category')
    );
    register_post_type('games', $args);
}
add_action('init', 'games_post_types');


function init_metaboxes() {
    add_meta_box(
        'games_meta_box',
        'Informations jeu',
        'games_meta_box_callback',
        'games',
        'normal',
        'default'
    );
}

add_action('add_meta_boxes', 'init_metaboxes');
function collaborators_post_types() {
    $labels = array(
        'name' => 'Collaborateurs',
        'all_items' => 'Tous les collaborateurs',
        'singular_name' => 'Collaborateur',
        'plural_name' => 'Collaborateurs',
        'add_new_item' => 'Ajouter un collaborateur',
        'edit_item' => 'Modifier le collaborateur',
        'menu_name' => 'Collaborateur'
        );
        $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-users',
    );
    register_post_type('collaborators', $args);
}
add_action('init', 'collaborators_post_types');

function init_collab_metaboxes() {
    add_meta_box(
        'collaborators_meta_box',
        'Informations du collaborateur',
        'collaborators_meta_box_callback',
        'collaborators',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'init_collab_metaboxes');

function custom_taxonomy_thematics() {
    $labels = array(
        'name'              => _x('Thématique', 'taxonomy general name'),
        'singular_name'     => _x('Thématique', 'taxonomy singular name'),
        'search_items'      => __('Rechercher une thématique'),
        'all_items'         => __('Toutes les thématiques'),
        'parent_item'       => __('Parent Genre'),
        'parent_item_colon' => __('Parent Genre:'),
        'edit_item'         => __('Modifier une thématique'),
        'update_item'       => __('Update Genre'),
        'add_new_item'      => __('Ajouter une nouvelle thématique'),
        'new_item_name'     => __('Nouveau nom de thématique'),
        'menu_name'         => __('Thématique'),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'thematique'), 
    );
    
    register_taxonomy('thematique', 'games', $args);
}
add_action( 'init', 'custom_taxonomy_thematics', 0);

function custom_taxonomy_mechanics() {
    $labels = array(
        'name'              => _x('Mécanique', 'taxonomy general name'),
        'singular_name'     => _x('Mécanique', 'taxonomy singular name'),
        'search_items'      => __('Rechercher une mécanique'),
        'all_items'         => __('Toutes les mécaniques'),
        'parent_item'       => __('Parent Genre'),
        'parent_item_colon' => __('Parent Genre:'),
        'edit_item'         => __('Modifier une mécanique'),
        'update_item'       => __('Update Genre'),
        'add_new_item'      => __('Ajouter une nouvelle mécanique'),
        'new_item_name'     => __('Nouveau nom de mécanique'),
        'menu_name'         => __('Mécanique'),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'mecanique'), 
    );
    
    register_taxonomy('mecanique', 'games', $args);
}
add_action( 'init', 'custom_taxonomy_mechanics', 0);

function custom_taxonomy_collab() {
    $labels = array(
        'name'              => _x('Role du collaborateur', 'taxonomy general name'),
        'singular_name'     => _x('Role du collaborateur', 'taxonomy singular name'),
        'search_items'      => __('Rechercher un role de collaborateur'),
        'all_items'         => __('Tous les roles de collaborateurs'),
        'parent_item'       => __('Parent Genre'),
        'parent_item_colon' => __('Parent Genre:'),
        'edit_item'         => __('Modifier un role de collaborateur'),
        'update_item'       => __('Update Genre'),
        'add_new_item'      => __('Ajouter un nouveau role de collaborateur'),
        'new_item_name'     => __('Nouveau nom de role de collaborateur'),
        'menu_name'         => __('Role'),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'role_collaborateur'), 
    );
    
    register_taxonomy('roles', 'collaborators', $args);
}
add_action( 'init', 'custom_taxonomy_collab', 0);

function games_meta_box_callback($post) {
    $release_date = get_post_meta($post->ID, 'wpcfrelease_date', true);
    $players = get_post_meta($post->ID, 'wpcfplayers', true);
    $min_age = get_post_meta($post->ID, 'wpcfmin_age', true);
    $duration = get_post_meta($post->ID, 'wpcfduration', true);
    $price = get_post_meta($post->ID, 'wpcfprice', true);
    $collaborators = get_post_meta($post->ID, 'wpcfcollaborators', true);

    $collaborator_posts = get_posts(array(
        'post_type' => 'collaborators',
        'posts_per_page' => -1,
    ));
    ?>
    <div>
        <label for="release_date">Date de sortie : </label>
        <input type="date" id="release_date" name="release_date" value="<?= $release_date ?>" />
    </div>
    <div>
        <label for="players">Nombre de joueurs : </label>
        <input type="number" id="players" name="players" value="<?= $players ?>" />
    </div>
    <div>
        <label for="min_age">Age minimum : </label>
        <input type="number" id="min_age" name="min_age" value="<?= $min_age ?>" />
    </div>
    <div>
        <label for="price">Prix : </label>
        <input type="float" id="price" name="price" value="<?= $price ?>" />
    </div>
    <div>
        <label for="duration">Durée approximative du jeu : </label>
        <input type="number" id="duration" name="duration" value="<?= $duration ?>" />
    </div>
    <div>
        <label>Collaborateurs :</label><br>
        <?php
        // Afficher une case à cocher pour chaque collaborateur
        foreach ($collaborator_posts as $collaborator_post) {
            $checked = in_array($collaborator_post->ID, (array)$collaborators) ? 'checked' : '';
            ?>
            <input type="checkbox" id="collaborator_<?= $collaborator_post->ID ?>" name="collaborators[]" value="<?= $collaborator_post->ID ?>" <?= $checked ?>>
            <label for="collaborator_<?= $collaborator_post->ID ?>"><?= $collaborator_post->post_title ?></label><br>
            <?php
        }
        ?>
    </div>
    <div>
        <label for="rules">Règles du jeu :</label>
        <textarea name="rules"></textarea>
    </div>
    <?php
}

function save_metaboxes($post_id) {
    if (isset($_POST['release_date'])) {
        update_post_meta($post_id, 'wpcfrelease_date', esc_html($_POST['release_date']));
    }
    if (isset($_POST['players'])) {
        update_post_meta($post_id, 'wpcfplayers', esc_html($_POST['players']));
    }
    if (isset($_POST['min_age'])) {
        update_post_meta($post_id, 'wpcfmin_age', esc_html($_POST['min_age']));
    }
    if (isset($_POST['duration'])) {
        update_post_meta($post_id, 'wpcfduration', esc_html($_POST['duration']));
    }
    if (isset($_POST['price'])) {
        update_post_meta($post_id, 'wpcfprice', esc_html($_POST['price']));
    }
    if (isset($_POST['rules'])) {
        update_post_meta($post_id, 'wpcfrules', esc_html($_POST['rules']));
    }
    if (isset($_POST['collaborators'])) {
        $collaborators = serialize($_POST['collaborators']);
        update_post_meta($post_id, 'wpcfcollaborators', $collaborators);
    }
    else {
        delete_post_meta($post_id, 'wpcfcollaborators');
    }
}
add_action('save_post', 'save_metaboxes');

function collaborators_meta_box_callback($post) {
    $games = get_post_meta($post->ID, 'wpcfgames', true);

    $game_posts = get_posts(array(
        'post_type' => 'games',
        'posts_per_page' => -1,
    ));
    ?>
    <div>
        <label>Collaborateurs :</label><br>
        <?php
        // Afficher une case à cocher pour chaque collaborateur
        foreach ($game_posts as $game_post) {
            $checked = in_array($game_post->ID, (array)$games) ? 'checked' : '';
            ?>
            <input type="checkbox" id="game_<?= $game_post->ID ?>" name="games[]" value="<?= $game_post->ID ?>" <?= $checked ?>>
            <label for="game_<?= $game_post->ID ?>"><?= $game_post->post_title ?></label><br>
            <?php
        }
        ?>
    </div>
    <div>
        <label for="rules">Règles du jeu :</label>
        <textarea name="rules"></textarea>
    </div>
    <?php
}

function save_collaborators_metaboxes($post_id) {
    if (isset($_POST['games'])) {
        $games = $_POST['games'];
        // Assurons-nous que $games est un tableau d'identifiants de jeux
        $games = array_map('intval', $games);
        // Mettons à jour le champ de méta avec le tableau d'identifiants de jeux
        update_post_meta($post_id, 'wpcfgames', $games);
    } else {
        // S'il n'y a pas de jeux sélectionnés, supprimons le champ de méta
        delete_post_meta($post_id, 'wpcfgames');
    }
}
add_action('save_post', 'save_collaborators_metaboxes');


