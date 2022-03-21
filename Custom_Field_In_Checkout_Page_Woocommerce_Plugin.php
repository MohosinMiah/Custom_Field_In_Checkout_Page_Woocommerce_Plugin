<?php 



/**
 * Author Added Woocommerce Functionality : MD MOHOSIN MIAH   *************  START **************
 * 
 * -----------------------------
 * How To Use This Code ****************************************************. 
* 1) Add in Functions.php file or add in seperate file then include in functions.php file.
* If Need any help, feel free contact with me , hamza161033@gmail.com 
* ---------------------------------------------------------
 * Added Woocommerce functionality in Wocommerce Plugin
 *  1) Added Extra Field in checkout Fienlds for classes 
 *  2) Class created as a product but that will not display in shop page
 *  3) iF classes and product added to the card then both field will be available in checkout field
 */


/**
 * Remove Optional Text
 *
 */


add_filter( 'woocommerce_form_field' , 'elex_remove_checkout_optional_text', 10, 4 );
function elex_remove_checkout_optional_text( $field, $key, $args, $value ) {
if( is_checkout() && ! is_wc_endpoint_url() ) {
$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
$field = str_replace( $optional, '', $field );
}
return $field;
} 




/**
 * Add fields to the checkout page based on products in cart.
 *
 */

 $result_status_classes = false;
 $result_no_product = true;



add_action( 'woocommerce_checkout_fields', 'woo_add_conditional_checkout_fields' );

function woo_add_conditional_checkout_fields( $fields ) {
   

	foreach( WC()->cart->get_cart() as $cart_item ){
        $product_id = $cart_item['product_id'];
        
        $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
        $cat_id = (int)$term_list[0];
        // var_dump($cat_id);

        /**
         * You Can use specific Product or product category . Example Code Given below
         */
        // if($cat_id == "379" || $product_id == "381" || $product_id == "382"|| $product_id == "383" || $product_id == "393" || $product_id == "400" || $product_id == "401" || $product_id == "403" || $product_id == "408" || $product_id == "409" ){
        
        if($cat_id == "44"){   // Based On Category 
			   global $result_status_classes;
             $result_status_classes = true;
        }else{
            $result_no_product = false;
        }

	}
        // 346
        if($result_status_classes == true){

            
        // unset Unnecessary Fields **********************
                if($result_no_product == true){

        unset($fields['order']['order_comments']);
        unset($fields['billing']['billing_country']);
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_postcode']);
        
                }
     
     $fields['order']['parent_name'] = array(
        'label'     => __('For minors: Name of parent', 'woocommerce'),
        'type'     => 'text',
        'optional' => '',
        'placeholder'   => _x('For minors: Name of parent', 'placeholder', 'woocommerce'),
        'required'  => false
    );

    $fields['order']['parent_info'] = array(
        'label'     => __('Parent contact info (email or phone)', 'woocommerce'),
        'type'     => 'text',
        'placeholder'   => _x('Parent contact info (email or phone)', 'placeholder', 'woocommerce'),
        'required'  => false
    );


    $fields['order']['describe_yourself'] = array(
        'label'     => __('Describe yourself and tell us.Why you are interested in this class.', 'woocommerce'),
        'type'     => 'textarea',
        'placeholder'   => _x('Describe yourself and tell us.Why you are interested in this class.', 'placeholder', 'woocommerce'),
        'required'  => false
    );
    $fields['order']['questions'] = array(
        'label'     => __('Questions', 'woocommerce'),
        'type'     => 'textarea',
        'placeholder'   => _x('Questions', 'placeholder', 'woocommerce'),
        'required'  => false
    );
    


    
	





/**
 * Outputs a radio button form field   first radion field 11111111111111111111 start
 */
function woocommerce_form_field_radio( $key, $args, $value = '' ) {
    global $woocommerce;
      $defaults = array(
                      'type' => 'radio',
                      'label' => '',
                      'placeholder' => '',
                      'required' => true,
                      'class' => array( ),
                      'label_class' => array( ),
                      'return' => false,
                      'options' => array( )
      );
      $args     = wp_parse_args( $args, $defaults );
      if ( ( isset( $args[ 'clear' ] ) && $args[ 'clear' ] ) )
                      $after = '<div class="clear"></div>';
      else
                      $after = '';
      $required = ( $args[ 'required' ] ) ? ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>' : '';
      switch ( $args[ 'type' ] ) {
                      case "select":
                                      $options = '';
                                      if ( !empty( $args[ 'options' ] ) )
                                                      foreach ( $args[ 'options' ] as $option_key => $option_text )  
                                                    //   $options .= '<input type="radio" name="' . $key . '" id="' . $key . '" value="' . $option_key . '" ' . selected( $value, $option_key, false ) . 'class="select">' . $option_text . '' . "\r\n";
                                                      $options .= '<input type="radio" name="' . $key . '" id="' . $key . '" value="' . $option_key . '"  checked'. selected( $value, $option_key, true ). 'class="select">' . $option_text . '' . "\r\n";
                                                      $field = '<p class="form-row ' . implode( ' ', $args[ 'class' ] ) . '" id="' . $key . '_field">
<label for="' . $key . '" class="' . implode( ' ', $args[ 'label_class' ] ) . '">' . $args[ 'label' ] . $required . '</label>
' . $options . '
</p>' . $after;
                                      break;
      } //$args[ 'type' ]
      if ( $args[ 'return' ] )
                      return $field;
      else
                      echo $field;
}
/**
* Add the field to the checkout
**/

        if($result_status_classes == true){

add_action( 'woocommerce_after_checkout_billing_form', 'experience_level_field', 10 );
function experience_level_field( $checkout ) {
      echo '<div id="experience_level_field" ><h3 style="color:black;">' . __( 'Experience Level' ) . '</h3>';
      woocommerce_form_field_radio( 'experience_level', array(
                       'type' => 'select',
                      'class' => array(
                                       'experience-level form-row-wide'
                      ),
                      'label' => __( '' ),
                      'placeholder' => __( '' ),
                      'required' => false,
                      'options' => array(
                                      'No_Experience' => 'No Experience',
                                      'Beginner' => 'Beginner',
                                      'Some_Experience' => 'Some Experience',
                                      'Advanced' => 'Advanced',
                                      

                                      
                      )
      ), $checkout->get_value( 'experience_level' ) );
      echo '</div>';
}
		}
/**
* Process the checkout
**/
// add_action( 'woocommerce_checkout_process', 'my_custom_checkout2_field_process' );
// function my_custom_checkout_field_process( ) {
//       global $woocommerce;
//       // Check if set, if its not set add an error.
//       if ( !$_POST[ 'experience_level' ] )
//                        $woocommerce->add_error( __( 'Please enter something into this new shiny field.' ) );
// }
/**
* Update the order meta with field value
**/
add_action( 'woocommerce_checkout_update_order_meta', 'experience_level_field_update_order_meta' );
function experience_level_field_update_order_meta( $order_id ) {
      if ( $_POST[ 'experience_level' ] )
                      update_post_meta( $order_id, 'Experience Level ?', esc_attr( $_POST[ 'experience_level' ] ) );
}



// Radion button field for experienced lavel 1 end *********************

    









/**
 * Outputs a rasio button form field   two  radion field for education level 11111111111111111111 start
 */
function woocommerce_form_field_radio_education( $key, $args, $value = '' ) {
    global $woocommerce;
      $defaults = array(
                      'type' => 'radio',
                      'label' => '',
                      'placeholder' => '',
                      'required' => true,
                      'class' => array( ),
                      'label_class' => array( ),
                      'return' => false,
                      'options' => array( )
      );
      $args     = wp_parse_args( $args, $defaults );
      if ( ( isset( $args[ 'clear' ] ) && $args[ 'clear' ] ) )
                      $after = '<div class="clear"></div>';
      else
                      $after = '';
      $required = ( $args[ 'required' ] ) ? ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce' ) . '">*</abbr>' : '';
      switch ( $args[ 'type' ] ) {
                      case "select":
                                      $options = '';
                                      if ( !empty( $args[ 'options' ] ) )
                                                      foreach ( $args[ 'options' ] as $option_key => $option_text )  
                                                    //   $options .= '<input type="radio" name="' . $key . '" id="' . $key . '" value="' . $option_key . '" ' . selected( $value, $option_key, false ) . 'class="select">' . $option_text . '' . "\r\n";
                                                      $options .= '<input type="radio" name="' . $key . '" id="' . $key . '" value="' . $option_key . '"  checked'. selected( $value, $option_key, true ). 'class="select">' . $option_text . '' . "\r\n";
                                                      $field = '<p class="form-row ' . implode( ' ', $args[ 'class' ] ) . '" id="' . $key . '_field">
<label for="' . $key . '" class="' . implode( ' ', $args[ 'label_class' ] ) . '">' . $args[ 'label' ] . $required . '</label>
' . $options . '
</p>' . $after;
                                      break;
      } //$args[ 'type' ]
      if ( $args[ 'return' ] )
                      return $field;
      else
                      echo $field;
}
/**
* Add the field to the checkout
**/
         if($result_status_classes == true){
add_action( 'woocommerce_after_checkout_billing_form', 'education_level_field', 10 );
function education_level_field( $checkout ) {
      echo '<div id="education_level_field" ><h3 style="color:black;">' . __( 'Education Level' ) . '</h3>';
      woocommerce_form_field_radio_education( 'education_level', array(
                       'type' => 'select',
                      'class' => array(
                                       'education-level form-row-wide'
                      ),
                      'label' => __( '' ),
                      'placeholder' => __( '' ),
                      'required' => false,
                      'options' => array(
                                      'Elementary' => 'Elementary',
                                      'High_School' => 'High School',
                                      'Some_College' => 'Some_College',
                                      'Graduated_From_College' => 'Graduated from College',
                                      'University' => 'University',
                                      

                                      
                      )
      ), $checkout->get_value( 'education_level' ) );
      echo '</div>';
}
		 }
/**
* Process the checkout
**/
// add_action( 'woocommerce_checkout_process', 'my_custom_checkout2_field_process' );
// function my_custom_checkout_field_process( ) {
//       global $woocommerce;
//       // Check if set, if its not set add an error.
//       if ( !$_POST[ 'experience_level' ] )
//                        $woocommerce->add_error( __( 'Please enter something into this new shiny field.' ) );
// }
/**
* Update the order meta with field value
**/
add_action( 'woocommerce_checkout_update_order_meta', 'education_level_update_order_meta' );
function education_level_update_order_meta( $order_id ) {
      if ( $_POST[ 'education_level' ] )
                      update_post_meta( $order_id, 'Education Level ?', esc_attr( $_POST[ 'education_level' ] ) );
}



// Radion button field for Education lavel 2 end *********************
}
// Return checkout fields.
	return $fields;
    }

     

 // global $post_id;
    // $order = new WC_Order( $post_id );
    // echo '<p><strong>'.__('Field Value').':</strong> ' . get_post_meta($order->get_id(), 'order_field_value', true ) . '</p>';
    // echo '<p><strong>'.__('Field Value2').':</strong> ' . get_post_meta($order->get_id(), 'order_field_value2', true ) . '</p>';
    // echo '<p><strong>'.__('Field Value3').':</strong> ' . get_post_meta($order->get_id(), 'order_field_value3', true ) . '</p>';

 



/**
 * Add the field to the checkout
 */
// add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

// function my_custom_checkout_field( $checkout ) {

//     echo '<div id="my_custom_checkout_field"><h2>' . __('My Field') . '</h2>';

//     woocommerce_form_field( 'my_field_name', array(
//         'type'          => 'text',
//         'class'         => array('my-field-class form-row-wide'),
//         'label'         => __('Fill in this field'),
//         'placeholder'   => __('Enter something'),
//         ), $checkout->get_value( 'my_field_name' ));

//     echo '</div>';

// }

/**
 * Process the checkout  ***********************
 */
// add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

// function my_custom_checkout_field_process() {
//     // Check if set, if its not set add an error.
//     if ( ! $_POST['my_field_name'] )
//         wc_add_notice( __( 'Please enter something into this new shiny field.' ), 'error' );
// }


/**
 * Update the order meta with field value              ******************************
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {

    if ( ! empty( $_POST['parent_name'] ) ) {

        update_post_meta( $order_id, 'Name of Parent ', sanitize_text_field( $_POST['parent_name'] ) );
       
        
        }else{
            update_post_meta( $order_id, 'Name of Parent ', "Not Given" );

        }
    if ( ! empty( $_POST['parent_info'] ) ) {

        update_post_meta( $order_id, 'Parent Contact Info', sanitize_text_field( $_POST['parent_info'] ) );
        
        }else{
            update_post_meta( $order_id, 'Parent Info ', "Not Given" );

        }
    if ( ! empty( $_POST['describe_yourself'] ) ) {

        update_post_meta( $order_id, 'Why you are interested in this class ?', sanitize_text_field( $_POST['describe_yourself'] ) );
        
        }else{
            update_post_meta( $order_id, 'Describe Yourself ', "Not Given" );

        }
    if ( ! empty( $_POST['questions'] ) ) {

        update_post_meta( $order_id, 'Questions', sanitize_text_field( $_POST['questions'] ) );
        
        }else{
            update_post_meta( $order_id, 'Questions ', "Not Given" );

        }
                        

}     


/**
 * Author Added Woocommerce Functionality : MD MOHOSIN MIAH   *************  END **************
 * Added Woocommerce functionality in Wocommerce Plugin
 *  1) Added Extra Field in checkout Fienlds for classes 
 *  2) Class created as a product but that will not display in shop page
 *  3) iF classes and product added to the card then both field will be available in checkout field
 */
?>