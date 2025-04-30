<?php

/**
 * Search form
 *
 * @category WordPress theme
 * @package haemo
 */

?>
<form action="/" method="get" class="search-form">
    <label for="search" class="sr-only">Search:</label>
    <input
        type="text"
        name="s"
        id="search"
        value="<?php the_search_query(); ?>"
        placeholder="Search" class="input search-form__input"
    />
    <button class="search-form__button">
        <svg class="icon" width="30px" height="30px">
            <use xlink:href="#icon-search"></use>
        </svg>
    </button>
</form>

