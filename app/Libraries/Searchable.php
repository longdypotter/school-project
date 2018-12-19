<?php
  namespace App\Libraries;

  /**
   *
   */
  class Searchable
  {

    /* ----
    protected $seachable = [
        'name'=>'', 'directory'=>'', 'id'=>'>',
    ];

      -BETWEEN : " BETWEEN $input_name AND $input_name_tail"
        star: input_name
        end: input_name_tail

      -BEGIN WITH: " LIKE '$value%'"

      -END WITH: " LIKE '%$value'"

      -CONTAINS: " LIKE '%$value%'"


    */

    public static function _getQuery($query=[], $seachable=[]){
        $collection = collect($query)->only(array_keys($seachable));
        $newQuery = [];
        foreach($collection as $k=>$v){
            $condition = strtoupper($seachable[$k]);
            // $v check if value is not null
            if (!empty($v)) {
                switch ($condition) {
                    case 'BETWEEN':
                        $newQuery[] =  [$k,'>=',$v];
                        $newQuery[] =  [$k,'<=',$query[$k.'_tail']];
                        break;
                    case 'BEGIN WITH':
                        $newQuery[] =  [$k,'LIKE', $v.'%'];
                        break;
                    case 'END WITH':
                        $newQuery[] =  [$k,'LIKE', '%'.$v];
                        break;
                    case 'CONTAINS':
                        $newQuery[] =  [$k,'LIKE', '%'.$v.'%'];
                        break;
                    default:
                    $newQuery[] = (empty($condition))? [$k,$v]:[$k,$condition,$v];
                    break;

                }
            }
        }
        return $newQuery;
    }

    public static function getSearchDateRange()
    {
        // $start = $end = date('Y-m-d');
        $start = $end = '';
        $dates = explode(' - ', session('search.datetimes'));
        if (session()->exists('search')) {
            if ($dates[0] != '' && $dates[1] != '') {
                $start = \Carbon\Carbon::parse($dates[0])->toDateString();
                $end = \Carbon\Carbon::parse($dates[1])->toDateString();
            }
            
        }
        return ['start' => $start, 'end' => $end];
    }

}


