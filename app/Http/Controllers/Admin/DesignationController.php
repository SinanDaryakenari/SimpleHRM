<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ReportableException;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.admin.designation.index');
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     * @throws ReportableException
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $designation = new Designation();
            $designation->name = $request->get('name');
            $designation->save();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
        return 'success';
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
     * @return string
     * @throws ReportableException
     */
    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $designation = Designation::findOrFail($request->get('id'));
            $designation->name = $request->get('name');
            $designation->save();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return string
     * @throws ReportableException
     */
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();
            $designation = Designation::findOrFail($request->get('id'));
            $designation->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new ReportableException($exception->getMessage());
        }
        return 'success';
    }

    /**
     * Display the list of resource.
     *
     * @throws \Exception
     */
    public function list()
    {
        $designation = Designation::get();
        return datatables()->of($designation)->make(true);
    }
}
