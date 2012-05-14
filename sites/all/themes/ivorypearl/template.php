<?php
// $Id: template.php,v 1.6 2008/11/07 23:22:47 ipwa Exp $

//Override phptemplate_variables().
 
function ivorypearl_preprocess_node(&$vars, $hook) {

      $node = $vars['node'];

      // Variables for the calendar date display.
      $vars['month'] = date('M', $node->created);
      $vars['day'] = date('j', $node->created);
//variables for comments
 $vars['comments'] = theme('blocks', 'comments');
  //return $vars;
}


/*
* Override filter.module's theme_filter_tips() function to disable tips display.
*/
//function ivorypearl_filter_tips($tips, $long = FALSE, $extra = '') {
 // return '';
//}


function ivorypearl_filter_tips_more_info() { // this one for the link
  return ''; 
}

function ivorypearl_filter_tips() { // this one for the other stuff
  return ''; 
}


// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('ivorypearl_rebuild_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

function ivorypearl_preprocess_html(&$variables, $hook) {
  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$variables['is_front']) {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section, ) = explode('/', $path, 2);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        $section = 'node-add';
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        $section = 'node-' . arg(2);
      }
    }
    $variables['classes_array'][] = drupal_html_class('section-' . $section);
  }
  if (theme_get_setting('ivorypearl_wireframes')) {
    $variables['classes_array'][] = 'with-wireframes'; // Optionally add the wireframes style.
  }
}