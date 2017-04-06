<?php

// Gravity Forms Custom Addresses (Australia)
add_filter('gform_address_types', 'australian_address', 10, 2);

function australian_address( $address_types, $form_id ) {
    $address_types['australia'] = array(
    'label'       =>   'Australia', //labels the dropdown
    'country'     =>   'Australia', //sets Australia as default country
    'zip_label'   =>   'Post Code', //what it says
    'state_label' =>   'State', //as above
    'states' => array( 
        '', 
        'Australian Capital Territory',
        'New South Wales',
        'Northern Territory',
        'Queensland',
        'South Australia',
        'Tasmania',
        'Victoria',
        'Western Australia'
        )
    );
    return $address_types;
}