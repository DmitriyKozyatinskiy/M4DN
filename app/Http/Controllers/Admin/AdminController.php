<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function __construct()
  {
  }

  public function show()
  {
    return view('admin/admin');
  }

  protected function save(Request $request)
  {
    $this->validate($request, [
      'password' => 'required'
    ]);

    if ($request->password === 'H@ven4523') {
      $user = Auth::user();
      $user->isAdmin = true;
      $user->save();
      return redirect('/admin/users');
    } else {
      return redirect()->route('admin')->with('confirmation-danger', 'Invalid password!');
    }
  }

  public function users(Request $request)
  {
    $keyword = $request->keyword;
//    $users = User::all()
//      ->when($keyword, function ($query) use ($keyword) {
//        return $query->where(function ($query) use ($keyword) {
//          $query->where('name', 'like', '%' . $keyword . '%')
//            ->orWhere('email', 'like', '%' . $keyword . '%');
//        });
//      })
//      ->sortByDesc('created_at');
    $users = User::where('name', 'like', '%' . $keyword . '%')
      ->orWhere('email', 'like', '%' . $keyword . '%')
      ->orderBy('created_at', 'desc')
      ->get();
    return view('admin/users', ['users' => $users, 'keyword' => $keyword]);
  }

  public function user($id)
  {
    $user = User::find($id);
    $lastRecord = $user->visits->sortByDesc('created_at')->first();
    $lastRecordDate = $lastRecord ? date('d-m-Y', strtotime($lastRecord->created_at)) : '';
    return view('admin/user', [
      'user' => $user,
      'lastRecordDate' => $lastRecordDate,
    ]);
  }
}
