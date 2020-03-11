<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ReportableException;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Show selected user roles
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function have(Request $request)
    {
        $user_id = $request->get('id');
        $user = User::where('id', $user_id)->first();

        return view('pages.admin.users.role-add-revoke')->with('user', $user);
    }

    /**
     * List selected user roles
     *
     * @param Request $request
     * @return
     * @throws \Exception
     */
    public function haveList(Request $request)
    {
        $user_id = $request->get('user_id');
        $has_role = DB::table('roles')
            ->join('role_user', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', '=', $user_id)
            ->get();

        return datatables()->of($has_role)->make(true);
    }

    /**
     * Fetch selected users non-roles
     *
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function hasNoRole(Request $request)
    {
        $user_id = $request->get('user_id');

        $active_roles = DB::table('roles')
            ->join('role_user', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', '=', $user_id)
            ->pluck('roles.id')
            ->toArray();

        return DB::table('roles')
            ->whereNotIn('id', $active_roles)
            ->get();
    }

    /**
     * Assign role from selected user
     *
     * @param Request $request
     * @return string
     * @throws ReportableException
     */
    public function assignRole(Request $request)
    {
        try {
            DB::beginTransaction();
            $role_user = new RoleUser();
            $role_user->role_id = $request->get('role_id');
            $role_user->user_id = $request->get('user_id');
            $role_user->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
        return 'success';
    }

    /**
     * Revoke role from selected user
     *
     * @param Request $request
     * @throws ReportableException
     */
    public function revokeRole(Request $request)
    {
        $id = $request->get('id');

        try {
            DB::beginTransaction();

            $role_user = RoleUser::where('id', '=', $id)->firstOrFail();
            $role_user->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Lists user roles
     *
     * @param Request $request
     */
    public function list(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
