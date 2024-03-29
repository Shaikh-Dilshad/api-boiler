<?php

namespace App\Http\Controllers;

use App\ImportBatch;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use \Carbon\Carbon;
use App\Sku;
use App\Stock;
use App\Value;

class UsersController extends Controller
{
  public function __construct()
  {
    $this->middleware(['auth:api', 'company']);
  }

  public function masters(Request $request)
  {
    $rolesController = new RolesController();
    $rolesResponse = $rolesController->index($request);

    $regionValue = Value::where('name', '=', 'REGION')
      ->where('company_id', '=', $request->company->id)
      ->first();
    $regions = [];
    if ($regionValue)
      $regions = $regionValue->active_value_lists;


    $branchValue = Value::where('name', '=', 'BRANCH')
      ->where('company_id', '=', $request->company->id)
      ->first();
    $branches = [];
    if ($branchValue)
      $branches = $branchValue->active_value_lists;

    return response()->json([
      'roles'                 =>  $rolesResponse->getData()->data,
      'regions'               =>  $regions,
      'branches'               =>  $branches,
    ], 200);
  }

  /*
   * To get all the users
   *
   *@
   */
  public function index(Request $request)
  {
    $count = 0;
    $role = 3;
    $users = [];
    if (request()->page && request()->rowsPerPage) {
      $users = request()->company->users()
        ->whereHas('roles',  function ($q) {
          $q->where('name', '!=', 'ADMIN');
        });
      $users = $users->paginate(request()->rowsPerPage)->toArray();
      $users = $users['data'];
    } else if ($request->search == 'all') {
      $users = $request->company->users()
        ->whereHas('roles',  function ($q) {
          $q->where('name', '!=', 'ADMIN');
        })
        ->latest()->get();
    } else if ($request->searchEmp) {
      $users = $request->company->users()->with('roles')
        ->whereHas('roles',  function ($q) {
          $q->where('name', '!=', 'ADMIN');
        });

      $users = $users->where('name', 'LIKE', '%' . $request->searchEmp . '%')
        ->orWhere('email', 'LIKE', '%' . $request->searchEmp . '%')
        ->orWhere('phone', 'LIKE', '%' . $request->searchEmp . '%')
        ->orWhere('branch', 'LIKE', '%' . $request->searchEmp . '%')
        ->orWhere('region', 'LIKE', '%' . $request->searchEmp . '%')
        ->latest()->get();
      return $users;
    } else if ($request->role_id) {
      $role = Role::find($request->role_id);
      $users = $request->company->allUsers()
        ->whereHas('roles', function ($q) use ($role) {
          $q->where('name', '=', $role->name);
        });
      if ($request->status != 'all')
        $users = $users->where('active', '=', 1);
      $users = $users->latest()->get();
    } else {
      $users = $request->company->users()->with('roles')
        ->whereHas('roles',  function ($q) {
          $q->where('name', '!=', 'ADMIN');
        })->latest()->get();
    }
    $count = sizeOf($users);
    return response()->json([
      'data'  =>  $users,
      'count' =>   $count,
      'success' =>  true,
    ], 200);
  }

  public function searchByRole(Request $request)
  {
    ini_set('max_execution_time', -1);
    ini_set('memory_limit', '1000M');
    set_time_limit(0);
    $count = 0;
    $users = [];

    if ($request->role_id && request()->page && request()->rowsPerPage) {
      $role = Role::find($request->role_id);
      $users = $request->company->allUsers()
        ->whereHas('roles', function ($q) use ($role) {
          $q->where('name', '=', $role->name);
        });
      if ($request->status != 'all')
        $users = $users->where('active', '=', 1);
      if ($request->superVisor_id) {
        $users = $users->where('supervisor_id', '=', $request->superVisor_id);
      }
      $count = $users->count();
      $users = $users->paginate(request()->rowsPerPage)->toArray();
      $users = $users['data'];
    }
    return response()->json([
      'data'     =>  $users,
      'count' =>   $count,
      'success'   =>  true
    ], 200);
  }

  public function excelDownload(Request $request)
  {
    ini_set('max_execution_time', -1);
    ini_set('memory_limit', '1000M');
    set_time_limit(0);
    $count = 0;
    $users = [];

    $users = $request->company->users()
      ->whereHas('roles',  function ($q) {
        $q->where('name', '!=', 'ADMIN');
      });;
    if ($request->region) {
      $users = $users
        ->where('region', 'LIKE', '%' . $request->region . '%');
    }
    $users = $users->get();
    $count = $users->count();
    return response()->json([
      'data'     =>  $users,
      'count' =>   $count,
      'success'   =>  true
    ], 200);
  }
  /*
   * To store a new company user
   *
   *@
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'                    => ['required', 'string', 'max:255'],
      'email'                   => ['required', 'string', 'max:255', 'unique:users'],
      'role_id'                 =>  'required',
    ]);

    $user['name'] = $request->name;
    $user['email'] = $request->email;
    $user['email_2'] = $request->email_2;
    $user['active'] = $request->active;
    $user['phone'] = $request->phone;
    $user['password'] = bcrypt('123456');
    $user['password_backup'] = bcrypt('123456');

    $user = new User($user);
    $user->save();

    $user->assignRole($request->role_id);
    $user->roles = $user->roles;
    $user->assignCompany($request->company_id);
    $user->companies = $user->companies;
    return response()->json([
      'data'     =>  $user
    ], 201);
  }

  /*
   * To show particular user
   *
   *@
   */
  public function show($id)
  {
    $user = User::where('id', '=', $id)
      ->with('roles', 'companies')->first();

    return response()->json([
      'data'  =>  $user,
      'success' =>  true
    ], 200);
  }

  /*
   * To update user details
   *
   *@
   */
  public function update(Request $request, User $user)
  {
    $request->validate([
      'name'                    => ['required', 'string', 'max:255'],
      'email'                   => ['required', 'string', 'max:255'],
    ]);

    $user->update($request->all());

    if ($request->role_id)
      $user->assignRole($request->role_id);

    $user->assignCompany(1);
    $user->roles = $user->roles;
    $user->companies = $user->companies;

    return response()->json([
      'data'  =>  $user,
      'message' =>  "User is Logged in Successfully",
      'success' =>  true
    ], 200);
  }

  /*
   * To check or update unique id
   *
   *@
   */
  public function checkOrUpdateUniqueID(Request $request, User $user)
  {
    if ($user->unique_id == null | $user->unique_id == '') {
      $user->update($request->all());
    }

    return response()->json([
      'data'  =>  $user,
      'success' =>  $user->unique_id == $request->unique_id ? true : false
    ], 200);
  }

  public function countUsers(Request $request)
  {
    $count = $request->company->users()
      ->whereHas('roles', function ($q) {
        $q->where('name', '=', 'Employee');
      })->count();

    return response()->json([
      'data'  =>  $count
    ], 200);
  }
}
