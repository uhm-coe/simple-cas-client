<?php

// Load CAS config.
require __DIR__ . '/config.php';

// Autoload dependencies (phpCAS).
require __DIR__ . '/vendor/autoload.php';

// Init phpCAS (in order to define constants like SAML_VERSION_1_1).
$phpCAS = new phpCAS;

// Set the CAS client configuration.
phpCAS::client(SAML_VERSION_1_1, CONFIG_CAS_HOST, CONFIG_CAS_PORT, CONFIG_CAS_PATH);

// Allow redirects at the CAS server endpoint (e.g., allow connections
// at an old CAS URL that redirects to a newer CAS URL).
phpCAS::setExtraCurlOption(CURLOPT_FOLLOWLOCATION, true);

// Set sertificate bundle (copied from the WordPress certificate bundle at
// /wp-includes/certificates/ca-bundle.crt).
phpCAS::setCasServerCACert(dirname(__FILE__)  . '/certificates/ca-bundle.crt');

// Set the CAS service URL (where to redirect after authentication, i.e., here).
$cas_service_url = CONFIG_CAS_REDIRECT_URL;
if (! empty($_GET['action'])) {
	$cas_service_url .= '?action=' . preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['action']);
}
phpCAS::setFixedServiceURL($cas_service_url);

// Authenticate against CAS.
try {
	phpCAS::forceAuthentication();
} catch (CAS_AuthenticationException $e) {
	// CAS server threw an error in isAuthenticated(), potentially because the
	// cached ticket is outdated. Log the error and quit.
	error_log('CAS server returned an Authentication Exception. Details:'); // phpcs:ignore
	error_log($e->getMessage()); // phpcs:ignore
	phpCAS::logout();
	die();
}

// Log out user if requested.
if (isset($_REQUEST['logout'])) {
	phpCAS::logout();
}

// Get username (as specified by the CAS server).
$username = phpCAS::getUser();

// Can assume at this point that we have an authenticated user.
?>
<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Simple CAS Client Example</title>
	</head>
	<body>
		<h1>Welcome, <?php echo $username; ?></h1>
		<p><a href="?logout=">Logout</a></p>
	</body>
</html>
