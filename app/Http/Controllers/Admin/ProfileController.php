<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでProfiles Modelが扱えるようになる
use App\Profiles;
use App\PHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add()
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
        // Varidationを行う
        $this->validate($request, Profiles::$rules);
        $profiles = new Profiles;
        $form = $request->all();
        
        unset($profiles_form['_token']);
        
        // データベースに保存する
        $profiles->fill($form);
        $profiles->save();
        
        return redirect('admin/profile/create');
    }

    public function index(Request $request)
    {
      $cond_name = $request->cond_name;
      if ($cond_name != '') {
          $posts = Profiles::where('name', $cond_name)->get();
      } else {
          $posts = Profiles::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
        // Profiles Modelからデータを取得する
        $profiles = Profiles::find($request->id);
        if (empty($profiles)) {
        abort(404);    
        }
        return view('admin.profile.edit', ['profiles_form' => $profiles]);
    }
    
    public function update(Request $request)
    {
        // Validationをかける
        $this->validate($request, Profiles::$rules);
        // Profiles Modelからデータを取得する
        $profiles = Profiles::find($request->id);
        // 送信されてきたフォームデータを格納する
        $profiles_form = $request->all();
        unset($profiles_form['_token']);

        // 該当するデータを上書きして保存する
        $profiles->fill($profiles_form)->save();

        // 以下を追記
        $phistory = new PHistory;
        $phistory->profiles_id = $profiles->id;
        $phistory->edited_at = Carbon::now();
        $phistory->save();

        return redirect('admin/profile');
    }

    public function delete(Request $request)
    {
        // 該当するProfiles Modelを取得
        $profiles = Profiles::find($request->id);
        // 削除する
        $profiles->delete();
        return redirect('admin/profile');
    }
}
    