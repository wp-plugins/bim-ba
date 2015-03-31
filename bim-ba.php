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
define('BIMBA_PLUGIN_SLUG', 'bim-ba');

define('BIMBA_DS', DIRECTORY_SEPARATOR);
define('BIMBA_PLUGIN_DIR', dirname( __FILE__ ) );
define('BIMBA_PLUGIN_LIB_DIR', BIMBA_PLUGIN_DIR . BIMBA_DS . 'lib');
//define('BIMBA_PLUGIN_LANG_DIR', BIMBA_PLUGIN_DIR . BIMBA_DS . 'languages');

/*
 * INTERNATIONALIZATION
*/

add_action ( 'plugins_loaded' , 'bimba_textdomain');
function bimba_textdomain(){
	load_plugin_textdomain( 'bim-ba', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');
}

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
 * PROCEDURE DI ATTIVAZIONE
*/

function register_gestudio_cpt_tax(){
	
	//registra taxonomy categoria contabile del cpt prime note
	register_taxonomy('categoria-contabile' , 'prime-note', array ( 'hierarchical' => true, 'label' => __('Counting Category','bim-ba'),
	'query-var' => true,'rewrite' => true));
	
	$terms = array (__('Incomes','bim-ba'),
					__('Expenses','bim-ba'),
					__('Clearances','bim-ba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'categoria-contabile' ) ){
			wp_insert_term( $term, 'categoria-contabile' );
		}
	}
	
	$parent_term_id = term_exists(__('Incomes','bim-ba'), 'categoria-contabile' );
	
	if ( !term_exists( __('Anticipations','bim-ba'), 'categoria-contabile' ) ){
		wp_insert_term( 'Anticipations', 'categoria-contabile', array('slug' => 'anticipations', 'parent'=> $parent_term_id['term_id']));
	}
	
	$parent_term_id = term_exists(__('Expenses','bim-ba'), 'categoria-contabile' );
	
	$terms = array (
			array(__('01-Taxes','bim-ba'),__('taxes','bim-ba')),
			array(__('02-Profits','bim-ba'),__('profits','bim-ba')),
			array(__('03-Restitutions','bim-ba'),__('restitutions','bim-ba')),
			array(__('04-Social Security','bim-ba'),__('social-security','bim-ba')),
			array(__('05-Salaries','bim-ba'),__('salaries','bim-ba')),
			array(__('06-Internal Contributors','bim-ba'),__('internal-contributors','bim-ba')),
			array(__('07-External Contributors','bim-ba'),__('external-contributors','bim-ba')),
			array(__('08-Loans','bim-ba'),__('loans','bim-ba')),
			array(__('09-Energy Supplies','bim-ba'),__('energy-supplies','bim-ba')),
			array(__('10-Communications','bim-ba'),__('communications','bim-ba')),
			array(__('11-Assistence','bim-ba'),__('assistence','bim-ba')),
			array(__('12-Office Supplies','bim-ba'),__('office-supplies','bim-ba')),
			array(__('13-Fleet','bim-ba'),__('fleet','bim-ba')),
			array(__('14-Policies','bim-ba'),__('policies','bim-ba')),
			array(__('15-Other','bim-ba'),__('other','bim-ba'))
	);
	foreach ( $terms as $term ){
		if ( !term_exists( $term[0], 'categoria-contabile' ) ){
			wp_insert_term( $term[0], 'categoria-contabile', array('slug' => $term[1], 'parent'=> $parent_term_id['term_id']));
		}
	}
	
	//registra taxonomy qualifiche del cpt operatori
	
	register_taxonomy('gstu-ruoli' , 'gstu-operatori', array ( 'hierarchical' => true, 'label' => __("Role of Operator", 'bim-ba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (__('Studio','bim-ba'),
			__('Contributor','bim-ba'),
			__('Client','bim-ba'),
			__('Contractor','bim-ba'),
			__('Bank','bim-ba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-ruoli' ) ){
			wp_insert_term( $term, 'gstu-ruoli' );
		}
	}
	
	//registra taxonomy fase del cpt lavori
	
	register_taxonomy('gstu-fasi' , 'gstu-lavori', array ( 'hierarchical' => true, 'label' => __('Fase di Lavorazione', 'bim-ba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (__('01-Inquest','bim-ba'),
			__('02-Draft','bim-ba'),
			__('03-Final Project','bim-ba'),
			__('04-Executive project','bim-ba'),
			__("05-Tender Invitation",'bim-ba'),
			__("06-Contract",'bim-ba'),
			__('07-Project Management','bim-ba'),
			__('08-Trials','bim-ba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-fasi' ) ){
			wp_insert_term( $term, 'gstu-fasi' );
		}
	}
	
	//registra taxonomy fase del cpt rapporti
	
	register_taxonomy('gstu-tipi' , 'gstu-rapporti', array ( 'hierarchical' => true, 'label' => __('Type of Report', 'bim-ba' ),
		  'query-var' => true,'rewrite' => true));
	
	$terms = array (
			__('Draft Bill','bim-ba'),
			__('Final Bill','bim-ba'),
			__('Fee','bim-ba'),
			__('Invoice','bim-ba'),
			__('Credit','bim-ba') );
	foreach ( $terms as $term ){
		if ( !term_exists( $term, 'gstu-tipi' ) ){
			wp_insert_term( $term, 'gstu-tipi' );
		}
	}
}