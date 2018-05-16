<form class="search_form" role="search" method="get" action="<?php echo home_url('/'); ?>">
	<div>
	<input type="search" class="search_input"  placeholder="Search..." value="<?php echo get_search_query() ?>" name="s" title="Search"/>
	<button class="search_button" type="submit" style="float: right" alt="Search"><i class="fa fa-search" aria-hidden="true"></i></button>
	</div>
</form>