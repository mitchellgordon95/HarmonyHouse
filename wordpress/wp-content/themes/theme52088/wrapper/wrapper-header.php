<?php /* Wrapper Name: Header */ ?>
<div class="custom_poz0">
	<div class="container">
		<div class="row header_widgets">
			<div class="span12">
				<div data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="header-sidebar-1">
					<?php dynamic_sidebar("header-sidebar-1"); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="custom_poz">
	<div class="container">
		<div class="row block_menu">
			<div class="span12 cont">
				<div class="row">
					<div class="span3 logo_poz" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
						<?php get_template_part("static/static-logo"); ?>
					</div>
					<div class="span9 menu_poz">
						<div class="hidden-phone" data-motopress-type="static" data-motopress-static-file="static/static-search.php">
							<?php get_template_part("static/static-search"); ?>
						</div>
						<div data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
							<?php get_template_part("static/static-nav"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>