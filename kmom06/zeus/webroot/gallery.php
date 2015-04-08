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


 
// Settings for the gallery object
$options =  array(
  'galleryPath' => __DIR__ . DIRECTORY_SEPARATOR . 'img' , 
  'galleryBaseURL' => '' ,
  );

// Create the gallery object
$cGallery = new CGallery($options);


// Get gallery
$gallery = $cGallery->getGallery();


// Do it and store it all in variables in the Zeus container.
$zeus['title'] = "Galleri";

$zeus['main'] = <<<EOD
<h1>{$zeus['title']}</h1>
{$gallery}
EOD;



// Finally, leave it all to the rendering phase of Zeus.
include(ZEUS_THEME_PATH);

 
