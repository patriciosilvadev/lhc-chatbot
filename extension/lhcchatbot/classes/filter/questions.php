<?php

$fieldsSearch = array();

$fieldsSearch['question'] = array (
    'type' => 'text',
    'trans' => 'Username',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'like',
    'filter_table_field' => 'question',
    'validation_definition' => new ezcInputFormDefinitionElement (
        ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
    )
);

$fieldsSearch['chat_id'] = array (
    'type' => 'text',
    'trans' => 'Sort by',
    'required' => false,
    'valid_if_filled' => false,
    'filter_type' => 'like',
    'filter_table_field' => 'chat_id',
    'validation_definition' => new ezcInputFormDefinitionElement (
        ezcInputFormDefinitionElement::OPTIONAL, 'string'
    )
);


$fieldSortAttr = array (
    'field'      => false,
    'default'    => false,
    'serialised' => true,
    'disabled'   => true,
    'options'    => array()
);

return array(
    'filterAttributes' => $fieldsSearch,
    'sortAttributes'   => $fieldSortAttr
);