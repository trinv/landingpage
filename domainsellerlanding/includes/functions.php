<?php 

/**
 * Convert hexidecimal color to RGB color
 * Source: http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
 *
 * @param string $hex hexidecimal color code
 * @return string comma separated R,G,B values
 */
function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

/**
 * Validate and sanitizes POST input, mark missing fields
 * 
 * @param array $fields list of allowed fields, the key being the POSTed field name, 
 *    and the value its human-friendly name
 *
 * @return array nested array with 'field_data' and 'missing-fields' 
 *    (sanitized field data and list of fields missing from the POST data, respectively)
 */

function validateAndSanitize($fields, $fields_not_required = array()) {

   $field_data = array();
   $missing_fields = array();

   foreach( $fields as $key => $value ) {

      // If any field is not present, add it to the $missing_fields array
      // ----------------------------------------------------------------
      if( 
         ! isset($fields_not_required[$key])
         && ( ! isset($_POST[$key]) || trim($_POST[$key]) == '' )
      ) {
         
         $missing_fields[] = $key;

      // field is present
      // ----------------------------------------------------------------
      } elseif ( isset($_POST[$key]) ) {

         if( is_array($value) ) { // Handle array - domains 

            // The domain portfolio array is structured like this:
            //
            // 'domainone.com' => array(
            //    'price' => '$100',
            //    'price_description' => 'test price description',
            //    'description' => 'test description',
            // ),
            // ...
            foreach ($value as $domain) {
               // Sanitize each value
               $domain_name = filter_var( $domain['domain'], FILTER_SANITIZE_STRING );
               $domain['price'] = filter_var( $domain['price'], FILTER_SANITIZE_STRING );
               $domain['price_description'] = filter_var( $domain['price_description'], FILTER_SANITIZE_STRING );
               $domain['description'] = filter_var( $domain['description'], FILTER_SANITIZE_STRING );
               // Remove extra value
               unset($domain['domain']);
               // Put sanitized values in $field_data
               $field_data[$key][$domain_name] = $domain;
            }

         } else { // Handle strings

            // Sanitize and store string in $field_data
            $field_data[$key] = filter_var( $_POST[$key], FILTER_SANITIZE_STRING );

            // Validate email with a specific filter
            //
            // Scenarios:
            // 1. Email is required, and invalid - trigger missing
            // 2. Email is not required, not blank, and invalid - trigger missing
            // 3. Email is not required, blank - exit condition
            if(
               $key === 'email' 
               && ( ! isset($fields_not_required[$key]) || $field_data['email'] != '' ) 
            ) {
               if( filter_var( $_POST[$key], FILTER_VALIDATE_EMAIL ) === FALSE ) {
                  $missing_fields[] = 'email';
               }
            }
         }

         
      }
   }

   return array(
      'field_data' => $field_data,
      'missing_fields' => $missing_fields
   );
}

/**
 * Replaces a config placeholder in the format *|SETTINGNAME_VALUE|* 
 * with a specified string
 *
 * Assumes $config array is included beforehand
 *
 * @param string $search string to search for
 * @param string $replace string to replace with
 * @param string $subject to find and replace in
 *
 * @return string text with search/replace operations performed
 */

function replaceConfigPlaceholder($search, $replace, $subject) {
   return str_replace('*'.strtoupper($search . '_VALUE').'*', $replace, $subject);
}

/**
 * Convert array keys to lowercase
 *
 * @param array $array
 */
function lowercaseArrayKeys($array) {
   
   return array_key_change_case($array, CASE_LOWER);
}