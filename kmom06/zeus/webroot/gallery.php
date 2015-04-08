<?php 
/**
 * This is a Zeus pagecontroller.
 *
 */
// Include the essential config-file which also creates the $zeus variable with its defaults.
include(__DIR__.'/config.php'); 
$zeus['stylesheets'][] = 'css/gallery.css';
$zeus['stylesheets'][] = 'css/figure.css';
$zeus['stylesheets'][] = 'css/breadcrumbs.css';


 
// Declare functions only used for this page controller




// Define the basedir for the gallery
define('GALLERY_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'img');
define('GALLERY_BASEURL', '');
 


// Get incoming parameters
$path = isset($_GET['path']) ? $_GET['path'] : null;
$pathToGallery = realpath(GALLERY_PATH . DIRECTORY_SEPARATOR . $path);



// Validate incoming arguments
is_dir(GALLERY_PATH) or errorMessage('The gallery dir is not a valid directory.');
substr_compare(GALLERY_PATH, $pathToGallery, 0, strlen(GALLERY_PATH)) == 0 or errorMessage('Security constraint: Source gallery is not directly below the directory GALLERY_PATH.');
 


// Read and present images in the current directory
if(is_dir($pathToGallery)) {
  $gallery = readAllItemsInDir($pathToGallery);
}
else if(is_file($pathToGallery)) {
  $gallery = readItem($pathToGallery);
}



// Do it and store it all in variables in the Zeus container.
$breadcrumb = createBreadcrumb($pathToGallery);
$zeus['title'] = "Galleri";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
$breadcrumb
 
$gallery
EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

 
