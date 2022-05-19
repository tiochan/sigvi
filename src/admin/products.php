<?php
/**
 * @author Sebastian Gomez (tiochan@gmail.com)
 * For: Politechnical University of Catalonia (UPC), Spain.
 *
 * @package sigvi
 * @subpackage services
 * @uses form, dw_products
 */

	$AUTH_REQUIRED=true;
	$AUTH_LVL=5;

	include_once "../include/init.inc.php";
	include_once INC_DIR . "/forms/forms.inc.php";
	include_once INC_DIR . "/forms/form_elements/tab.inc.php";
	include_once MY_INC_DIR . "/classes/dw_products.class.php";

	$form_name= "form_products";

	html_header($MESSAGES["PRODUCT_MGM_TITLE"]);

	$tab= new tab_box("tab_1");

	$tb_prod= new tab("tab_prods", $MESSAGES["PRODUCT_MGM_TITLE"]);
	$dw_prod= new dw_product();
	$tb_prod->add_element($dw_prod);
	$tab->add_tab($tb_prod);

	$tb_cpe= new tab("tab_cpe", $MESSAGES["PRODUCT_DICTIONARIES_MGM_TITLE"]);
	$dw_cpe= new dw_product_cpe_ext();
	$tb_cpe->add_element($dw_cpe);
	$tab->add_tab($tb_cpe);


	$frm= new form($form_name);
	$frm->add_element($tab);

	$frm->form_control();

	html_footer();
