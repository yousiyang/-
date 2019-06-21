<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Fiction;
use yii\data\Pagination;
use yii\filters\PageCache;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function show()
    {
        $seach_title = \request()->get('seach_title');
//        var_dump($username);
        $show = Fiction::where([['ad_title','like','%'.$seach_title.'%']])->paginate(2);
        //$show = Admin::all()->paginate(2);

        return view('admin.show',['list'=>$show,'seach_title'=>$seach_title]);
    }

    public function show_one($id)
    {
        //$show_one = Admin::where('ad_id',$id)->get()->toArray();
        $show_one = Fiction::find($id)->toArray();
        return view('admin.show_one',['show_one'=>$show_one]);
    }

    public function save(Request $request)
    {
//        var_dump($request);die;
        $data = $this->validate($request, [
            //'ad_name' => 'required|unique:posts|max:6',
            'ad_title' => 'required|min:2|max:6',
            'ad_author' => 'required',
            'ad_content' => '',
        ],[
            'ad_title.required'=>'标题不能为空',
            'ad_title.min'=>'标题最少2位',
            'ad_title.max'=>'标题最多6位',
            'ad_author.required' => '作者不能为空',
        ]);
        //var_dump($data);die;
        //$table = Request()->post();
        //var_dump($request->post());die;
        if(isset($data['id']))
        {
            $Fiction = Fiction::find($data['ad_id']);
        }else{
            $Fiction = new Fiction();
        }

        $Fiction->ad_title = $data['ad_title'];
        $Fiction->save();
//        var_dump($Fiction)
        return redirect('admin/admin/show');

//        $id = $Fiction->fictionadd($data);
//        echo $id;
        //return view('admin.add');
    }

    public function update_one($id)
    {
        if (!$id){
            return 'ID 不能为空';
        }
        $update_one = Fiction::find($id);
        //$show = Admin::all()->paginate(2);

        return view('admin.update_one',['update_one'=>$update_one]);
    }

    //删除-单
    public function delete_one($id)
    {
        $del = Fiction::find($id)->delete();
        if($del) {
            return redirect('admin/admin/show');
        }
    }

    public function six()
    {
        $n = 5;
        function Sum_Solution($n)
        {
            $m = 1;

//            for($i=0;$i<$n; $i++)
//            {
                 $m && $res = Sum_Solution($n-1) + $n;
//                 echo "<br>";
                 return $res;
//                     return $res;
//            }
        }


        $num =  Sum_Solution($n);

        echo $num;
    }

}
