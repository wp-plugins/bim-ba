<?php
/*
Plugin Name: BIM_ba
Plugin URI: http://www.andywar.net/BIM_ba/
Description: A very basic Building Information Modeling
Version: 1.0
Author: andywar65
Author URI: http://www.andywar.net/
License: GPLv2
*/

/*  Copyright 2015  Andrea Guerra  (email : me@andywar.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 * ATTIVAZIONE
*/

register_activation_hook(__FILE__, 'bimba_activate');//registra l'attivazione della plugin

function bimba_activate() {//attivazione plugin
	register_gestudio_cpt_tax();//registra cpt e taxonomy per il pacchetto gestudio
}

/*
 * INIZIALIZZAZIONE
*/


/*
 * COSTANTI
*/

define('BIMBA_PLUGIN_VERSION', '1.0');
define('BIMBA_PLUGIN_SLUG', 'bimba');

define('BIMBA_DS', DIRECTORY_SEPARATOR);
define('BIMBA_PLUGIN_DIR', dirname(__FILE__));
define('BIMBA_PLUGIN_LIB_DIR', BIMBA_PLUGIN_DIR . BIMBA_DS . 'lib');
define('BIMBA_PLUGIN_LANG_DIR', BIMBA_PLUGIN_DIR . BIMBA_DS . 'languages');

/*
 * LIBRERIE
*/

require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio.php';
require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio-settings-page.php';//carica tutto il pacchetto gestudio
require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio-operatori.php';
require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio-lavori.php';
require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio-rapporti.php';
require_once BIMBA_PLUGIN_LIB_DIR . BIMBA_DS . 'gestudio-prime-note.php';


/*
 * INTERNATIONALIZATION
*/

add_action ( 'plugins_loaded' , 'bimba_textdomain');
function bimba_textdomain(){
	load_plugin_textdomain( 'bimba', false, BIMBA_PLUGIN_LANG_DIR);
}


/*
 * PROCEDURE DI ATTIVAZIONE
*/

function register_gestudio_cpt_tax(){
	
	//registra taxonomy categoria contabile del cpt prime note
	register_taxonomy('categoria-contabile' , 'prime-note', array ( 'hierarchical' => true, 'label' => __('Counting Category','bimba'),
	'query-var' => true,'rewrite' => true));
	
	$terms = array (__('Incomes','bimba'),
					__('Expenses','bimba'),
					__('Clearances','bimba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'categoria-contabile' ) ){
			wp_insert_term( $term, 'categoria-contabile' );
		}
	}
	
	$parent_term_id = term_exists(__('Incomes','bimba'), 'categoria-contabile' );
	
	if ( !term_exists( __('Anticipations','bimba'), 'categoria-contabile' ) ){
		wp_insert_term( 'Anticipations', 'categoria-contabile', array('slug' => 'anticipations', 'parent'=> $parent_term_id['term_id']));
	}
	
	$parent_term_id = term_exists(__('Expenses','bimba'), 'categoria-contabile' );
	
	$terms = array (
			array(__('01-Taxes','bimba'),__('taxes','bimba')),
			array(__('02-Profits','bimba'),__('profits','bimba')),
			array(__('03-Restitutions','bimba'),__('restitutions','bimba')),
			array(__('04-Social Security','bimba'),__('social-security','bimba')),
			array(__('05-Salaries','bimba'),__('salaries','bimba')),
			array(__('06-Internal Contributors','bimba'),__('internal-contributors','bimba')),
			array(__('07-External Contributors','bimba'),__('external-contributors','bimba')),
			array(__('08-Loans','bimba'),__('loans','bimba')),
			array(__('09-Energy Supplies','bimba'),__('energy-supplies','bimba')),
			array(__('10-Communications','bimba'),__('communications','bimba')),
			array(__('11-Assistence','bimba'),__('assistence','bimba')),
			array(__('12-Office Supplies','bimba'),__('office-supplies','bimba')),
			array(__('13-Fleet','bimba'),__('fleet','bimba')),
			array(__('14-Policies','bimba'),__('policies','bimba')),
			array(__('15-Other','bimba'),__('other','bimba'))
	);
	foreach ( $terms as $term ){
		if ( !term_exists( $term[0], 'categoria-contabile' ) ){
			wp_insert_term( $term[0], 'categoria-contabile', array('slug' => $term[1], 'parent'=> $parent_term_id['term_id']));
		}
	}
	
	//registra taxonomy qualifiche del cpt operatori
	
	register_taxonomy('gstu-ruoli' , 'gstu-operatori', array ( 'hierarchical' => true, 'label' => __("Role of Operator", 'bimba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (__('Studio','bimba'),
			__('Contributor','bimba'),
			__('Client','bimba'),
			__('Contractor','bimba'),
			__('Bank','bimba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-ruoli' ) ){
			wp_insert_term( $term, 'gstu-ruoli' );
		}
	}
	
	//registra taxonomy fase del cpt lavori
	
	register_taxonomy('gstu-fasi' , 'gstu-lavori', array ( 'hierarchical' => true, 'label' => __('Fase di Lavorazione', 'bimba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (__('01-Inquest','bimba'),
			__('02-Draft','bimba'),
			__('03-Final Project','bimba'),
			__('04-Executive project','bimba'),
			__("05-Tender Invitation",'bimba'),
			__("06-Contract",'bimba'),
			__('07-Project Management','bimba'),
			__('08-Trials','bimba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-fasi' ) ){
			wp_insert_term( $term, 'gstu-fasi' );
		}
	}
	
	//registra taxonomy fase del cpt rapporti
	
	register_taxonomy('gstu-tipi' , 'gstu-rapporti', array ( 'hierarchical' => true, 'label' => __('Type of Report', 'bimba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (
			__('Draft Bill','bimba'),
			__('Final Bill','bimba'),
			__('Fee','bimba'),
			__('Invoice','bimba'),
			__('Credit','bimba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-tipi' ) ){
			wp_insert_term( $term, 'gstu-tipi' );
		}
	}
}