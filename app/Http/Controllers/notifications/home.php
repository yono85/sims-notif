<?php
namespace App\Http\Controllers\notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\config\index as Config;
use DB;

class home extends Controller
{
    //
    public function main(Request $request)
    {
        $Config = new Config;
        $totaltoid = 0;
        $totalgp = 0;

        $getcounttoid = DB::table("count_op_hm_notif_toid")
        ->where([
            "to_id"     =>  trim($request->id)
        ])->first();

        $totaltoid = $getcounttoid === null ? 0 : $getcounttoid->total;

        if( trim($request->gp) != "0")
        {
            $getcountgp = DB::table("count_op_hm_notif_gp")
            ->where([
                "groups"     =>  trim($request->gp)
            ])->first();

            $totalgp = $getcountgp === null ? 0 : $getcountgp->total;
        }

        $total = ($totaltoid + $totalgp);
        //
        $data = [
            "message"       =>  "",
            "response"      =>  [
                "count"         =>  $total
            ]
        ];

        return response()->json($data, 200);
    }

    public function list(Request $request)
    {
        $Config = new Config;

        $id = trim($request->id);
        $gp = trim($request->gp);

        $getlist = DB::table("vw_home_notif as hn")
        ->where([
            "hn.to_id"          =>  $id,
            "hn.status"         =>  1
        ]);
        if($gp != "0") //not groups
        {
            $getlist = $getlist->orWhere([
                "hn.groups"     =>  $gp
            ]);
        }
        $count = $getlist->count();

        //
        if( $count > 0 )
        {
            $vdata = $getlist->orderBy("hn.id", "desc")
            ->get();
            
            foreach($vdata as $row)
            {
                $list [] = [
                    "id"                =>  $row->id,
                    "type"              =>  $row->type,
                    "label"             =>  $row->label,
                    "content"           =>  $row->content,
                    "link"              =>  $row->link,
                    "date"              =>  $Config->timeago($row->created_at),
                    "read"              =>  $row->read_status
                ];
            }


            //OPEN NOTIFICATION
            $opened = DB::table("vw_home_notif")
            ->where([
                "to_id"          =>  $id,
                "open"           =>  0,
                "status"         =>  1  
            ]);
            if($gp != "0") //not groups
            {
                $getlist = $getlist->orWhere([
                    "groups"     =>  $gp
                ]);
            }
            $getlist = $getlist->update([
                "open"           =>  1,
                "open_date"         =>  date("Y-m-d H:i:s", time())
            ]);


            // view data
            $data = [
                "message"           =>  "",
                "list"              =>  $list
            ];
    
            return response()->json($data, 200);

        }

        $data = [
            "message"           =>  "Data tidak ditemukan"
        ];

        return response()->json($data,404);

    }

    public function listAll(Request $request)
    {
        $Config = new Config;

        $id = trim($request->id);
        $gp = trim($request->gp);

        $getlist = DB::table("vw_home_notif as hn")
        ->where([
            "hn.to_id"          =>  $id,
            "hn.status"         =>  1
        ]);
        if($gp != "0") //not groups
        {
            $getlist = $getlist->orWhere([
                "hn.groups"     =>  $gp
            ]);
        }
        $count = $getlist->count();

        //
        if( $count > 0 )
        {
            $vdata = $getlist->orderBy("hn.id", "desc")
            ->skip(0)
            ->take(30)
            ->get();
            
            foreach($vdata as $row)
            {
                $list [] = [
                    "id"                =>  $row->id,
                    "type"              =>  $row->type,
                    "label"             =>  $row->label,
                    "content"           =>  $row->content,
                    "link"              =>  $row->link,
                    "date"              =>  $Config->timeago($row->created_at),
                    "read"              =>  $row->read_status
                ];
            }

            // view data
            $data = [
                "message"           =>  "",
                "list"              =>  $list
            ];
    
            return response()->json($data, 200);

        }

    }
}