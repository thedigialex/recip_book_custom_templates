<?php
/*
Template Name: Edit Recipe Template
*/
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

        $current_user_id = get_current_user_id();

        $post = get_post($post_id);

        if ($post && $post->post_type === 'recipe') {
            if ($post->post_author == $current_user_id) {
                ?>
                <div class="recipe-container">
                    <h2>Edit Recipe</h2>
                    <form method="post" action="" enctype="multipart/form-data">
                        <label for="post_title">Recipe Title</label>
                        <input type="text" id="post_title" name="post_title" value="<?php echo esc_attr($post->post_title); ?>" placeholder="Recipe Title">

                        <div class="half-width">
                            <label for="recipe-servingsize">Serving Size</label>
                            <input type="text" id="recipe-servingsize" name="recipe-servingsize" value="<?php echo esc_attr(get_post_meta($post_id, 'recipe-servingsize', true)); ?>" placeholder="Serving Size">
                        </div>

                        <div class="half-width">
                            <label for="recipe-cooktime">Cook Time Minutes</label>
                            <input type="text" id="recipe-cooktime" name="recipe-cooktime" value="<?php echo esc_attr(get_post_meta($post_id, 'recipe-cooktime', true)); ?>" placeholder="Cook Time">
                        </div>
                        
                        <div class="clearfix"></div> 

                        <label for="recipe-ingredients">Ingredients</label>
                        <textarea id="recipe-ingredients" name="recipe-ingredients"><?php echo esc_textarea(get_post_meta($post_id, 'recipe-ingredients', true)); ?></textarea>

                        <label for="recipe-steps">Steps</label>
                        <textarea id="recipe-steps" name="recipe-steps"><?php echo esc_textarea(get_post_meta($post_id, 'recipe-steps', true)); ?></textarea>

                        <label for="post_content">Recipe Description</label>
                        <textarea id="post_content" name="post_content"><?php echo esc_textarea($post->post_content); ?></textarea>

                        <input type="submit" name="update_post" value="Update Recipe">
                    </form>

                    <?php
                    if (isset($_POST['update_post'])) {
                        $new_title = sanitize_text_field($_POST['post_title']);
                        $new_content = sanitize_textarea_field($_POST['post_content']);
                        $updated_post = array(
                            'ID'           => $post_id,
                            'post_title'   => $new_title,
                            'post_content' => $new_content,
                        );

                        $result = wp_update_post($updated_post);

                        if ($result !== 0) {
                            update_post_meta($post_id, 'recipe-servingsize', sanitize_text_field($_POST['recipe-servingsize']));
                            update_post_meta($post_id, 'recipe-cooktime', sanitize_text_field($_POST['recipe-cooktime']));
                            update_post_meta($post_id, 'recipe-ingredients', sanitize_textarea_field($_POST['recipe-ingredients']));
                            update_post_meta($post_id, 'recipe-steps', sanitize_textarea_field($_POST['recipe-steps']));

                            echo 'Recipe updated successfully.';
                            custom_recipe_update_redirect($post_id);
                        } else {
                            echo 'Error updating recipe.';
                        }
                    }
                    ?>
                </div>
                <?php
            } else {
                echo 'Recipe not found.';
            }
        } else {
            echo 'Recipe not found.';
        }
        ?>
    </main>
</div>

<?php get_footer(); ?>
