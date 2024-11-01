<?php 
/*
Plugin Name: 		WP Read Time 
Plugin URI:  		https://www.puzzlesideral.com/wp-read-time/
Description: 		Plugin ligero que incluye el tiempo estimado de lectura en todas tus entradas.
Version:     		1.0.1
Author:      		Puzzle Sideral
Author URI:  		https://puzzlesideral.com/donate/
Text Domain: 		Puzzle Sideral
Domain Path: 		/languages
License:     		GPL2
 
WP Read Time is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WP Read Time is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with WP Read Time. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.html.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wpr_estima_tiempo_lectura($title, $id = null) {	
	if(get_post_type() == 'post'){
		$entrada = get_post();
		$ppm      = 320; // podemos escoger el PPM que queramos (200-300, por ejemplo)
		$palabras = str_word_count( strip_tags( $entrada->post_content ) );
		$minutos  = floor( $palabras / $ppm );
		$segundos = floor( ( $palabras % $ppm ) / ( $ppm / 60 ) );

		if ( 1 <= $minutos ) {
			$tiempo_estimado = $minutos . ' '. __( 'minuto', 'Puzzle Sideral' ) . ( 1 === $minutos ? '' : 's');
			if ( $segundos > 0 ) {
				$tiempo_estimado .= ', ' . $segundos . ' '. __( 'segundo', 'Puzzle Sideral' )  . ( 1 === $segundos ? '' : 's' );
			}
		} else {
			$tiempo_estimado = $segundos . ' '. __( 'segundo', 'Puzzle Sideral' )  . ( 1 === $segundos ? '' : 's' );
		}
		if (in_the_loop()) {
			$title = '<p class="tiempo-estimado">'. __( 'Tiempo de lectura aprox:', 'Puzzle Sideral' ) . ' ' . $tiempo_estimado .'</p>' . $title;
		}		
	}  
	return $title;
}

add_filter( 'the_content', 'wpr_estima_tiempo_lectura', 10, 2 );