<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/'));?>">
  <label> <span class="screen-reader-text"><?php _e("Search for","avata");?>:</span>
    <input type="search" class="search-field" placeholder="<?php esc_attr_e("Search","avata");?>&hellip;" value="<?php the_search_query(); ?>" name="s">
  </label>
  <input type="submit" class="search-submit" value="Search">
</form>
