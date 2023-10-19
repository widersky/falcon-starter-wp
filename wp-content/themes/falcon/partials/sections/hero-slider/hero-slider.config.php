<?php

  // https://www.advancedcustomfields.com/resources/register-fields-via-php/

  if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_1',
        'title' => 'My Group',
        'fields' => array (
            array (
                'key' => 'field_1',
                'label' => 'Sub Title',
                'name' => 'sub_title',
                'type' => 'text',
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
    ));

    endif;
