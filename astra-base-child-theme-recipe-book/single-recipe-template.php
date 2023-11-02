<?php
/*
Template Name: Custom Single Recipe Template
*/

get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
          $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
          
          $current_user_id = get_current_user_id();
          
          $post = get_post($post_id);
          
          if ($post && $post->post_type === 'recipe') {
              if ($post->post_author == $current_user_id) {
                  ?>
                  <div class="image-container">
                        <?php
                              $thumbnail_url = get_the_post_thumbnail_url();
                              if (empty($thumbnail_url)) {
                                  $thumbnail_url = '/wp-content/uploads/2023/09/missingImage.png';
                              }
                          ?>
                          <img class="image-single-recipe" src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title(); ?>">
                      
                      <h1 class="image-single-header"><?php the_title(); ?></h1>
                  </div>
                  
                   <div class="recipe-container">
                      <div class="section-menu-single">
                          <p><strong>Serving Size: </strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'recipe-servingsize', true)); ?></p>
                          <p><strong>Cook Time: </strong> <?php echo esc_html(get_post_meta(get_the_ID(), 'recipe-cooktime', true)); ?></p>
                          
                          <p></p>
                      </div>
                  <hr class="line" size="2" color="black">
                      <div class="subsection">
                          <div class="left-section">
                              <h2>Ingredients</h2>
                              <?php
                                    $ingredients = get_post_meta(get_the_ID(), 'recipe-ingredients', true);
                                    echo create_list($ingredients);
                                ?>
                          </div>
                          <div class="right-section">
                              <h2>Steps</h2>
                              <?php
                                    $ingredients = get_post_meta(get_the_ID(), 'recipe-steps', true);
                                    echo create_list($ingredients);
                                ?>
                          </div>
                      </div>
                      <div class="bordered-div">
                        <?php the_content(); ?>
                      </div>
                      
                      <button onclick="redirectToEdit(<?php echo $post_id; ?>);" class="button">Edit Recipe</button>
                      <script>
                      function redirectToEdit(postId) {
                          window.location.href = '/edit-recipe/?post_id=' + postId;
                      }
                      </script>

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
