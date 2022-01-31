<form class="search-form<?php echo is_search() || is_archive() ? ' search-form--search' : '';  ?>" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label>
        <input type="search" required class="search-form__input" name="s" placeholder="Search"
               value="<?php echo get_search_query(); ?>">
    </label>
    <button class="search-form__submit-button submit-button" type="submit"> Search</button>
</form>