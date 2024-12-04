<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'publishable_key',
    'is_active',
    'status',
];
$sIndexColumn     = 'id';
$sTable           = db_prefix() . 'stripe_merchants';
$additionalSelect = [];
$join = [
    // 'LEFT JOIN ' . db_prefix() . 'knowledge_base_groups ON ' . db_prefix() . 'knowledge_base_groups.groupid = ' . db_prefix() . 'knowledge_base.articlegroup',
];

$where   = [];
$filter  = [];
$groups  = $this->ci->knowledge_base_model->get_kbg();
$_groups = [];

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, $additionalSelect);
$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $key => $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aColumns[$i] == 'id' ? $key +1:  $aRow[$aColumns[$i]];

        $_data = '<a href="' . admin_url('stripe_merchants/edit/' . $aRow['id']) . '" class="font-size-14">' . $_data . '</a>';

        $row[]              = $_data;
        $row['DT_RowClass'] = 'has-row-options';
    }

    $output['aaData'][] = $row;
}
