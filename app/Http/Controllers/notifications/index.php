<?php
namespace App\Http\Controllers\notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\config\index as Config;
use DB;

class index extends Controller
{
    //
    public function main(Request $request)
    {
        $Config = new Config;

        //
        $level = trim($request->level);


        //
        $getdata = DB::table('notifications as n')
        ->select(
            'n.id', 'n.token', 'n.type', 'n.from_id', 'n.to_id', 'n.content', 'n.created_at'
        )
        ->where([
            'n.open'        =>  0
        ]);

        $count = $getdata->count();

        if( $count == 0 )
        {
            $data = [
                'message'       =>  'Tidak ada pemberitahuan'
            ];

            return response()->json($data, 404);
        }


        $gettable = $getdata->orderBy('n.id', 'desc')
        ->get();
        foreach($gettable as $row)
        {
            $content = json_decode($row->content);

            $list[] = [
                'id'        =>  $row->id,
                'from'      =>  $row->from_id,
                'to'        =>  $row->to_id,
                'token'     =>  $row->token,
                'content'       =>  [
                    'title'             =>  $content->title,
                    'text'           =>  $content->text,
                    'icon'              =>  $content->icon,
                    'cmd'               =>  $content->cmd,
                    'link'              =>  $content->link,
                    'token'             =>  $content->token
                ],
                'date'          =>  $Config->timeago($row->created_at)
            ];
        }

        $data = [
            'message'       =>  '',
            'response'          =>  [
                'count'         =>  $count,
                'list'          =>  $list
            ]
        ];

        return response()->json($data, 200);
    }
}