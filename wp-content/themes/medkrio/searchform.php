<?php
/**
 * The template for displaying search forms
 */
?>
	<div class="searchform">
	<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input  onfocus="this.value=''" onblur="this.value='Search...'" type="text" value="Search..." name="s" class="s" />
			</form>
	</div>