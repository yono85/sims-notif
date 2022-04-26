<?php
namespace App\Http\Controllers\config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class index extends Controller
{

    public function arrSublevel($request)
    {
        $data = [
            '1'         =>  ['2','3','4','5','6'],
            '2'         =>  ['2','3','5','6']
        ];

        return $data[$request];
    }

    //create new id to insert data
    public function createnewid($request)
    {
        $test = (int)$request['value'];
        $length = ( (int)$request['length'] - 1);
        $sprint = sprintf('%0'.$length.'s', 0);

        $condition = [ 
            10 . $sprint =>  9,
            9 . $sprint  =>  8,
            8 . $sprint  =>  7,
            7 . $sprint  =>  6,
            6 . $sprint  =>  5,
            5 . $sprint  =>  4,
            4 . $sprint  =>  3,
            3 . $sprint  =>  2,
            2 . $sprint  =>  1
        ];

        $sprintnew = strlen($test) === (int)$request['length'] ? substr($test, 1) : $test;

        foreach($condition as $row => $val)
        {
            if( $test < $row )
            {
                $value = $val . sprintf('%0'.$length.'s', $sprintnew);;
            }
        }


        return $value;
    }

    //create new id to insert data
    public function createnewidnew($request)
    {
        $numb = (int)$request['value'];
        $numb++;

        $length = ( (int)$request['length'] - 1);
        $sprint = sprintf('%0'.$length.'s', 0);

        $condition = [ 
            10 . $sprint =>  9,
            9 . $sprint  =>  8,
            8 . $sprint  =>  7,
            7 . $sprint  =>  6,
            6 . $sprint  =>  5,
            5 . $sprint  =>  4,
            4 . $sprint  =>  3,
            3 . $sprint  =>  2,
            2 . $sprint  =>  1
        ];

        $sprintnew = strlen($numb) === (int)$request['length'] ? substr($numb, 1) : $numb;

        foreach($condition as $row => $val)
        {
            if( $numb < $row )
            {
                $value = $val . sprintf('%0'.$length.'s', $sprintnew);;
            }
        }


        return $value;
    }


    // default date for table
    public function date()
    {
        return date('Y-m-d H:i:s', time());
    }


    //number
    public function number($request)
    {
        return preg_replace('/\D/', '', $request);
    }


    //create new uniq (number and char A-Z)
    public function createuniq($q)
    {
        $length = (int)$q['length'];
        $value = (int)$q['value'];

        //
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $value;
        $charlength = strlen($char);
        $rand = '';

        //
        for ($i = 0; $i < $length; $i++)
        {
            $rand .= $char[rand(0, $charlength - 1)];
        }
        return $rand;
    }


    //create uniq number
    public function createuniqnum($q)
    {
        $length = (int)$q['length'];
        $value = (int)$q['value'];

        //
        $char = '0123456789' . $value;
        $charlength = strlen($char);
        $rand = '';

        //
        for ($i = 0; $i < $length; $i++)
        {
            $rand .= $char[rand(0, $charlength - 1)];
        }
        return $rand;
    }


    //apps
    public function apps()
    {
        
        $data = [
            "company"       =>  [
                "name"          =>  "Herbindopersada",
                "url_logo"      =>  "https://crm.herbindopersada.com/assets/icon/herbindo-favicon.png",
                "url"           =>  "https://herbindopersada.com",
                "url_help"      =>  "https://help.herbindopersada.com"
                ],
            "crm"           =>  [
                // "name"          =>  "CRM Herbindo",
                "url"           =>  "https://crm.herbindopersada.com",
                "url_help"      =>  "https://crm.herbindopersada.com/help"
                ],
            "distributor"   =>  [
                // "name"          =>  "Herbindo",
                "url"           =>  "https://distributor.herbindopersada.com",
                "url_help"      =>  "https://distributor.herbindopersada.com/help"
            ],
            "maklon"   =>  [
                // "name"          =>  "Herbindo",
                "url"           =>  "https://maklon.herbindopersada.com",
                "url_help"      =>  "https://maklon.herbindopersada.com/help"
            ],
            "reseller"   =>  [
                // "name"          =>  "Herbindo",
                "url"           =>  "https://reseller.herbindopersada.com",
                "url_help"      =>  "https://reseller.herbindopersada.com/help"
            ],
            "storage"        => [
                "URL"           =>  env("URL_STORAGE"),
            ],
            "URL"           =>  [
                "STORE"         =>  env("URL_STORE"),
                "SLINK"         =>  env("URL_SLINK"),
                "STORAGE"       =>  env("URL_STORAGE"),
                "WEBWASENDTEXT" =>  "https://web.whatsapp.com/send?phone={{phone}}&text={{text}}",
                "APIWASENDTEXT" =>  "https://api.whatsapp.com/send?phone={{phone}}&text={{text}}",
                "APIWASEND"     =>  "https://api.whatsapp.com/send?phone={{phone}}",
                "WAMESEND"      =>  "https://wa.me/{{phone}}"        
            ]
        ];


        return $data;

    }


    public function rootapps($q)
    {
        $data = [
            '1'     =>  'crm',
            '2'     =>  'distributor',
            '3'     =>  'maklon',
            '4'     =>  'reseller'
        ];


        return $data[$q];
    }


    public function subURI()
    {
    	$subURI = explode("/", url()->full());
    	return $subURI;
    }


    public function cekURI($request)
    {
        return $request->getRequestUri();
    }


    public function table($request)
    {

        
        $item = 15;
        $limit = (( (int)$request['paging'] - 1) * $item);

        $data = [
            'paging_item'       =>  $item,
            'paging_limit'      =>  $limit,
            'paging'            =>  $request['paging']
        ];


        return $data;
    }

    public function scroll($request)
    {
        $item = 55;
        $limit = (( (int)$request['paging'] - 1) * $item);

        $data = [
            'paging_item'       =>  $item,
            'paging_limit'      =>  $limit,
            'paging'            =>  $request['paging']
        ];

        return $data;
    }

    public function uniqnum($first,$second)
    {

        return mt_rand($first, $second);

        // return mt_rand(125, 299);
    }

    // timeago
    public function timeago($ptime)
    {

        $gettime = strtotime($ptime);

        $estimate_time = time() - $gettime;
        if( $estimate_time < 1 )
        {
            return '1 dtk';
        }

        $condition = [ 
            12 * 30 * 24 * 60 * 60  =>  'thn',
            30 * 24 * 60 * 60       =>  'bln',
            24 * 60 * 60            =>  'hari',
            60 * 60                 =>  'jam',
            60                      =>  'mnt',
            1                       =>  'dtk'
        ];

        foreach( $condition as $secs => $str )
        {
            $d = $estimate_time / $secs;

            $r = round($d);


            if( $d >= 1 )
            {
                    // $r = round( $d );
                // return ' ' . $r . $str;
                
                if( $str == 'mnt' || $str == 'dtk')
                {   
                    return $r . $str; // . ' lalu';
                }
                elseif( $str == 'jam' )
                {
                    if( $r < 4 )
                    {
                        return $r . $str; // . ' lalu';
                    }
                    else
                    {
                        return date('H.i', $gettime);
                    }
                }
                elseif( $str == 'hari' && $r < 7)
                {
                    return $this->namahari($ptime) . ', ' . date('H:i', $gettime);
                    
                }
                else
                {
                    return date('d/m/Y', $gettime);

                }

            }
        }

    } 

    // end timeago

    function namahari($date)
    {
        $info=date('w', strtotime($date));

        switch($info){
            case '0': return "Minggu"; break;
            case '1': return "Senin"; break;
            case '2': return "Selasa"; break;
            case '3': return "Rabu"; break;
            case '4': return "Kamis"; break;
            case '5': return "Jumat"; break;
            case '6': return "Sabtu"; break;
        };
    }

    // end nama hari
}