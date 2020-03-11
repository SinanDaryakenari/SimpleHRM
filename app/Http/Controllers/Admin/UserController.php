<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ReportableException;
use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.admin.users.index');
    }

    /**
     * Display the listing of the resource for datatable.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function list()
    {
        $users = DB::table('users')
            ->select('users.id', 'users.name', 'users.surname', 'users.email', DB::raw("GROUP_CONCAT(roles.name) as role"))
            ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->groupBy("users.id")
            ->get();
        return datatables()->of($users)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     * @throws ReportableException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $new_user = new User();
            $new_user->name = $request->get('name');
            $new_user->surname = $request->get('surname');
            $new_user->email = $request->get('email');
            $new_user->password = Hash::make($request->get('password'));
            $new_user->save();
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }


        return 'success';
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return string
     * @throws ReportableException
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $update_user = User::where('id', '=', $request->get('id'))->firstOrFail();
            $update_user->name = $request->get('name');
            $update_user->surname = $request->get('surname');
            $update_user->email = $request->get('email');
            if ($request->get('password')) {
                $update_user->password = Hash::make($request->get('password'));
            }
            $update_user->save();
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     * @throws ReportableException
     */
    public function destroy(Request $request)
    {
        $user_id = $request->get('id');

        try {
            DB::beginTransaction();

            $role_user = RoleUser::where('user_id', '=', $user_id)->first();
            if ($role_user) {
                $role_user = RoleUser::where('user_id', '=', $user_id)->firstOrFail();
                $role_user->delete();
            }

            $user = User::where('id', '=', $user_id)->firstOrFail();
            $user->delete();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
    }
}
