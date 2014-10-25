<?php

/**
 * LICENSE:
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @categories	Games/Entertainment, Systems Administration
 * @package		Bright Game Panel V2
 * @author		warhawk3407 <warhawk3407@gmail.com> @NOSPAM
 * @copyleft	2014
 * @license		GNU General Public License version 3.0 (GPLv3)
 * @version		0.1
 * @link		http://www.bgpanel.net/
 */

/**
 * Load Plugin Controller
 */

require( MODS_DIR . '/login/login.controller.class.php' );

// Init Controller
$loginController = new BGP_Controller_Login();

/**
 * Plug-in Dependencies
 */
require( LIBS_DIR . '/securimage/securimage.php' );


// Get the method
if ( isset($_POST['task']) ) {
	$task = $_POST['task'];
}
else if ( isset($_GET['task']) ) {
	$task = $_GET['task'];
}
else {
	$task = 'None';
}


// Call the method
switch ($task)
{
	case 'authenticateUser':
		echo $loginController->authenticateUser( $_POST );
		exit( 0 );

	case 'getCaptcha':
		$img = new Securimage();

		if (!empty($_GET['namespace'])) $img->setNamespace($_GET['namespace']);

		$img->show();  // outputs the image and content headers to the browser

		exit( 0 );

	case 'sendNewPassword':
		$image = new Securimage();

		if ( $image->check( $_POST['captcha'] ) == TRUE ) {
			// Good captcha
			echo $loginController->sendNewPassword( $_POST, TRUE );
		}
		else {
			// Bad captcha
			echo $loginController->sendNewPassword( $_POST, FALSE );
		}
		exit( 0 );

	default:
		Flight::redirect('/400');
}

Flight::redirect('/403');