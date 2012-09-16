<form action="" method="post" id="search_form" class="form-search pull-right">
	<input type="text" name="search_query" class="input-large search-query mainSearch" value="<?php echo Request::initial()->query('search_query', null);?>">
		<i class="icon-search insideSearch"></i>
	<input type="submit" id="form_submit" value="Search" class="none">
</form>