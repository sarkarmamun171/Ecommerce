<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleManagerController extends Controller
{
    function role_manager(){
        $permissions = Permission::all();
        $users = User::all();
        $roles = Role::all();
        return view('admin.role.role',[
            'permissions'=> $permissions,
            'roles'=> $roles,
            'users'=> $users,
        ]);
    }

    function permission_store(Request $request){
        $permission = Permission::create(['name' => $request->permission_name]);
        return back()->with('success','New Permission Added');
    }

    function role_store(Request $request){
        $role = Role::create(['name'=> $request->role_name]);
        $role->givePermissionTo($request->permission);

        return back()->with('role_added','New Role Added');
    }

    function role_assign(Request $request){
        // print_r($request->all);
        $user = User::find($request->user_id);
        $user->assignRole($request->role); //assignRole() function coming from spatie package

        return back()->with('role_assigned','Role Assigned Successfully!');
    }

    function remove_user_role($id){
        $user = User::find($id);
        $user->syncRoles([]);

        return back()->with('remove_role','Role Removed');
    }

    function delete_role($id){
        $role = Role::find($id);
        $role->syncPermissions([]);
        Role::find( $id )->delete();
        DB::table('model_has_roles')->where('role_id', $id )->delete();

        return back()->with('delete_role','Role Deleted');
    }

    function edit_role($id){
        $permissions = Permission::all();
        $roles = Role::find($id);
        return view('admin.role.edit',[
            'permissions'=> $permissions,
            'roles'=> $roles,
        ]);
    }

    function update_role(Request $request, $id){
        $role = Role::find($id);
        $role->syncPermissions($request->permission);
        Role::find( $id )->update(['name'=> $request->role_name]);
        return redirect()->route('role.manager');
    }
}
