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
/**
 * Read directory and return all items in a ul/li list.
 *
 * @param string $path to the current gallery directory.
 * @param array $validImages to define extensions on what are considered to be valid images.
 * @return string html with ul/li to display the gallery.
 */
function readAllItemsInDir($path, $validImages = array('png', 'jpg', 'jpeg')) {
  $files = glob($path . '/*'); 
  $gallery = "<ul class='gallery'>\n";
  $len = strlen(GALLERY_PATH);
 
  foreach($files as $file) {
    $parts = pathinfo($file);
    $href  = str_replace('\\', '/', substr($file, $len + 1));
 
    // Is this an image or a directory
    if(is_file($file) && in_array($parts['extension'], $validImages)) {
      $item    = "<img src='img.php?src=" 
        . GALLERY_BASEURL 
        . $href 
        . "&amp;width=128&amp;height=128&amp;crop-to-fit' alt=''/>";
      $caption = basename($file); 
    }
    elseif(is_dir($file)) {
      $item    = "<img src='img/folder.png' alt=''/>";
      $caption = basename($file) . '/';
    }
    else {
      continue;
    }
 
    // Avoid to long captions breaking layout
    $fullCaption = $caption;
    if(strlen($caption) > 18) {
      $caption = substr($caption, 0, 10) . '…' . substr($caption, -5);
    }
 
    $gallery .= "<li><a href='?path={$href}' title='{$fullCaption}'><figure class='figure overview'>{$item}<figcaption>{$caption}</figcaption></figure></a></li>\n";
  }
  $gallery .= "</ul>\n";
 
  return $gallery;
}

/**
 * Read and return info on choosen item.
 *
 * @param string $path to the current gallery item.
 * @param array $validImages to define extensions on what are considered to be valid images.
 * @return string html to display the gallery item.
 */
function readItem($path, $validImages = array('png', 'jpg', 'jpeg')) {
  $parts = pathinfo($path);
  if(!(is_file($path) && in_array($parts['extension'], $validImages))) {
    return "<p>This is not a valid image for this gallery.";
  }
 
  // Get info on image
  $imgInfo = list($width, $height, $type, $attr) = getimagesize($path);
  $mime = $imgInfo['mime'];
  $gmdate = gmdate("D, d M Y H:i:s", filemtime($path));
  $filesize = round(filesize($path) / 1024); 
 
  // Get constraints to display original image
  $displayWidth  = $width > 800 ? "&amp;width=800" : null;
  $displayHeight = $height > 600 ? "&amp;height=600" : null;
 
  // Display details on image
  $len = strlen(GALLERY_PATH);
  $href = GALLERY_BASEURL . str_replace('\\', '/', substr($path, $len + 1));
  $item = <<<EOD
<p><img src='img.php?src={$href}{$displayWidth}{$displayHeight}' alt=''/></p>
<p>Original image dimensions are {$width}x{$height} pixels. <a href='img.php?src={$href}'>View original image</a>.</p>
<p>File size is {$filesize}KBytes.</p>
<p>Image has mimetype: {$mime}.</p>
<p>Image was last modified: {$gmdate} GMT.</p>
EOD;
 
  return $item;
}

/**
 * Create a breadcrumb of the gallery query path.
 *
 * @param string $path to the current gallery directory.
 * @return string html with ul/li to display the thumbnail.
 */
function createBreadcrumb($path) {
  $parts = explode('/', trim(substr($path, strlen(GALLERY_PATH) + 1), '/'));
  $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='?'>Hem</a> »</li>\n";
 
  if(!empty($parts[0])) {
    $combine = null;
    foreach($parts as $part) {
      $combine .= ($combine ? '/' : null) . $part;
      $breadcrumb .= "<li><a href='?path={$combine}'>$part</a> » </li>\n";
    }
  }
 
  $breadcrumb .= "</ul>\n";
  return $breadcrumb;
}



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

 
