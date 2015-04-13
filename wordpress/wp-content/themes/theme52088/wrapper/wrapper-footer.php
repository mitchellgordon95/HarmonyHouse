<?php /* Wrapper Name: Footer */ ?>
<div class="footer_spl">
</div>
<div class="row footer-widgets">
	<div class="span3 ext_poz0">
		<div class="ext_poz0_2" data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-1">
			<?php dynamic_sidebar("footer-sidebar-1"); ?>
		</div>
	</div>
	<div class="span3 ext_poz1">
		<div data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-2">
			<?php dynamic_sidebar("footer-sidebar-2"); ?>
		</div>
	</div>
	<div class="span3 ext_poz2">
		<div data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-3">
			<?php dynamic_sidebar("footer-sidebar-3"); ?>
		</div>
	</div>
	<div class="span3 ext_poz3">
		<div data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-4">
			<?php dynamic_sidebar("footer-sidebar-4"); ?>
		</div>
	</div>
</div>
<div class="row">
	<div class="span12 block_01" data-motopress-type="static" data-motopress-static-file="static/static-footer-text.php">
		<?php get_template_part("static/static-footer-text"); ?>
	</div>
	<div class="span12 block_02">
		<div data-motopress-type="dynamic-sidebar" data-motopress-sidebar-id="footer-sidebar-5">
			<?php dynamic_sidebar("footer-sidebar-5"); ?>
		</div>
	</div>
	<div class="span12 ext_poz4" data-motopress-type="static" data-motopress-static-file="static/static-footer-nav.php">
		<?php get_template_part("static/static-footer-nav"); ?>
	</div>
</div>