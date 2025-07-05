<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use App\Traits\PermissionMiddlewareTrait;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use PermissionMiddlewareTrait;
    public function __construct()
    {

        $this->applyPermissionMiddleware('roles'); // أو 'order' أو 'category' حسب الحاجة
    }
    public function index()
    {
        $roles=Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();
        $role = Role::create(['name' => $validated['name']]);
        $role->syncPermissions($validated['permissions']);

        return to_route('roles.index')->with('success', 'تم إنشاء الدور بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions'); // تحميل الصلاحيات المرتبطة
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        // تحديث اسم الدور
        $role->update(['name' => $validated['name']]);

        // مزامنة الصلاحيات
        $role->syncPermissions($validated['permissions']);

        return to_route('roles.index')->with('success', 'تم تحديث الدور بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return back();
    }
}
