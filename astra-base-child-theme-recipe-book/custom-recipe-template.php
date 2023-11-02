<?php
/*
Template Name: Custom Recipe Template
*/

get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
          if (is_user_logged_in()) {
              $current_user_id = get_current_user_id();
              $args = array(
                  'post_type' => 'recipe', 
                  'posts_per_page' => -1,
                  'author' => $current_user_id,
              );
  
              $recipes = new WP_Query($args);
  
              if ($recipes->have_posts()) :
                  echo '<div class="recipe-cards-container">';
                  while ($recipes->have_posts()) : $recipes->the_post();
                      ?>
                      <div class="flip-card">
                          <div class="flip-card-inner">
                              <div class="flip-card-front">
                                  <?php
                                    $thumbnail_url = get_the_post_thumbnail_url();
                                    if (empty($thumbnail_url)) {
                                        $thumbnail_url = '/wp-content/uploads/2023/09/missingImage.png';
                                    }
                                    ?>
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title(); ?>">
                              </div>
                              <div class="flip-card-back">
                                  <h4 class="card-back-header">Recipe</h4>
                                  <p class="card-back-content"><?php echo esc_textarea($post->post_content);?></p>
                                  <a class="card-back-link" href="/recipepage/?post_id=<?php the_ID(); ?>" style="color: black;">Full Recipe</a>
                              </div>
                          </div>
                          <h4 class="card-front-header"><a href="/recipepage/?post_id=<?php the_ID(); ?>"><?php the_title(); ?></a></h4>
                      </div>
                      <?php
                  endwhile;
                  echo '</div>';
                  wp_reset_postdata();
              else :
                  echo 'No recipes found.';
              endif;
          } else {
              echo '<p>Please log in to view your recipes.</p>';
          }
        ?>
    </main>
</div>

<?php get_footer(); ?>
