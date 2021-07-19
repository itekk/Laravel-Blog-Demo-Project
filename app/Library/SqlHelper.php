<?php

namespace App\Library;

use Illuminate\Support\Facades\DB;

class SqlHelper
{
    /**
     * Fetching enum values from table.
     *
     * @return array
     */
    public static function getEnumValues($table, $column)
    {
        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM '.$table.' WHERE Field = "'.$column.'"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $enumStr, $matches);
        isset($matches[1]) ? $matches[1] : [];
        $EnumName = str_replace("'", "", $matches[1]);
        $res = explode(",", $EnumName);
        $arrayres = array();
        $i=0;
        foreach ($res as $key => $value) {
            if ($value != '') {
                $arrayres[$i]['key']   = $value;
                $arrayres[$i]['value'] = $value;
                $i++;
            }
        }
        return $arrayres;
    }
}
