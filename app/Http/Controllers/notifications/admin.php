<?php
namespace App\Http\Controllers\notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\config\index as Config;
use DB;

class admin extends Controller
{
    //
    public function main(Request $request)
    {

        $Config = new Config;

        $level = trim($request->level);
        $slevel = trim($request->slevel);
        $id = trim($request->id);
        $pg = trim($request->pg);
        $compid = trim($request->compid);

        //jika level admin pembayaran maka totype nya tidak nol

        $where = [
            'an.to_companyid'   =>  $compid,
            'an.open'           =>  0,
            'an.status'         =>  1
        ];

        $getcount = DB::table('vw_notify as an');
        if($slevel < 4)
        {
            $getcount = $getcount->where([
                'an.to_type'   =>  0,
                'an.to_id'     =>  $id
            ]);
        }
        if( $slevel == '5')
        {
            $getcount = $getcount->whereIn('an.to_type', ['5', '6']);
            //akses admin payement bisa mendapatkan notifikasi dari CS/Enduser/ Admin stock
        }
        if( $slevel == '6')
        {
            $getcount = $getcount->where(['an.to_type'=>'6']);
            // notif admin shiping
        }
        $getcount = $getcount->where($where)->count();

        if( $getcount > 0 )
        {
            $data = [
                'response'      =>  [
                    'count'         =>  $getcount,
                    'list'          =>  $this->listNotif($request)
                ]
            ];

            return response()->json($data, 200);
        }

        //
        $data = [
            'message'       =>  'Data not found',
            'response'      =>  [
                'list'          =>  $this->listNotif($request)
            ]
        ];

        return response()->json($data, 404);
    }


    public function listNotif($request)
    {
       
        $Config = new Config;


        $level = trim($request['level']);
        $slevel = trim($request['slevel']);
        $id = trim($request['id']);
        $paging = trim($request['pg']);
        $compid = trim($request['compid']);

        $where = [
            'an.to_companyid'   =>  $compid,
            'an.status'         =>  1
        ];

        $getnotif = DB::table('vw_notify as an');
        if($slevel < 4)
        {
            $getnotif = $getnotif->where([
                'an.to_type'   =>  0,
                'an.to_id'     =>  $id
            ]);
        }
        if( $slevel == '5')
        {
            $getnotif = $getnotif->whereIn('an.to_type', ['5', '6']);
            //akses admin payement bisa mendapatkan notifikasi dari CS/Enduser/ Admin stock
        }
        if( $slevel == '6')
        {
            $getnotif = $getnotif->where(['an.to_type'=>'6']);
            // notif admin shiping
        }
        $getnotif = $getnotif->where($where);
        

        if( $getnotif->count() > 0 )
        {

            $getnotif = $getnotif->take($Config->table(['paging'=>$paging])['paging_item'])
            ->skip($Config->table(['paging'=>$paging])['paging_limit'])
            ->orderBy('id', 'desc')
            ->get();

            foreach($getnotif as $row)
            {
                $list[] = [
                    "id"            =>  $row->id,
                    "content"       =>  json_decode($row->content),
                    "from_id"       =>  $row->from_id,
                    "read_date"     =>  $row->read_date === "" ? "false" : "true",
                    "open"          =>  $row->open === 1 ? "true" : "false",
                    "date"          =>  $Config->timeago($row->created_at)
                ];
            }
        }
        else
        {
            $list = "";
        }

        return $list;
    }


    public function open(Request $request)
    {
        $Config = new Config;

        //
        $id = trim($request->id);
        $level = trim($request->level);
        $slevel = trim($request->slevel);
        $compid = trim($request->compid);

        $where = [
            'an.to_companyid'   =>  $compid,
            'an.open'           =>  0,
            'an.status'         =>  1
        ];

        $readnotif = DB::table('vw_notify as an');
        if($slevel < 4)
        {
            $readnotif = $readnotif->where([
                'an.to_type'   =>  0,
                'an.to_id'     =>  $id
            ]);
        }
        if( $slevel == '5')
        {
            $readnotif = $readnotif->whereIn('an.to_type', ['5', '6']);
        }
        if( $slevel == '6')
        {
            $readnotif = $readnotif->where(['an.to_type'=>'6']);
        }
        $readnotif = $readnotif->where($where)
        ->update([
            'an.open'           =>  1,
            'an.open_date'      =>  date('Y-m-d H:i:s', time())
        ]);


       if( $readnotif )
       {
           return response()->json(['message'=>"success"],200);
       }
       
       return response()->json(['message'=>"Tidak ada perubahan"],404);
    }

    public function read(Request $request)
    {
        $Config = new Config;

        //
        $id = trim($request->id);

        $readnotif = DB::table('vw_notify as an')
        ->where(['an.id'=>$id])
        ->update([
            'an.read_date'     =>  date('Y-m-d H:i:s', time())
        ]);


       if( $readnotif )
       {
           return response()->json(['message'=>"success"],200);
       }
       
       return response()->json(['message'=>"Tidak ada perubahan"],404);
    }


}