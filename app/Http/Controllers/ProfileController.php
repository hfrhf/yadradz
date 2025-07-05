<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Traits\PermissionMiddlewareTrait;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    use PermissionMiddlewareTrait;
    public function __construct()
    {
        $this->applyPermissionMiddleware('profile');
    }

    public function index()
    {
        $profiles = User::latest()->paginate(5);
        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('profile.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        $validated = $request->validated();

        $paymentRate = null;
        if ($request->confirmer_payment_type === 'monthly_salary') {
            $paymentRate = $validated['confirmer_payment_rate_monthly'];
        } elseif ($request->confirmer_payment_type === 'per_order') {
            $paymentRate = $validated['confirmer_payment_rate_per_order'];
        }

        $user = User::create([
            'name'                      => $validated['name'],
            'email'                     => $validated['email'],
            'password'                  => Hash::make($validated['password']),
            'email_verified_at'         => now(),
            'confirmer_payment_type'    => $validated['confirmer_payment_type'],
            'confirmer_payment_rate'    => $paymentRate,
            'confirmer_cancellation_rate' => ($request->confirmer_payment_type === 'per_order') ? $validated['confirmer_cancellation_rate'] : null,
            'salary_payout_day'         => ($request->confirmer_payment_type === 'monthly_salary') ? $validated['salary_payout_day'] : null,
        ]);

        $user->assignRole($validated['role']);

        return to_route('profile.index')->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    public function show(User $profile)
    {
        //
    }

    public function edit(User $profile)
    {
        $roles = Role::all();
        return view('profile.edit', compact('profile', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request, User $profile)
    {
        $validated = $request->validated();

        $paymentRate = null;
        if ($request->confirmer_payment_type === 'monthly_salary') {
            $paymentRate = $validated['confirmer_payment_rate_monthly'];
        } elseif ($request->confirmer_payment_type === 'per_order') {
            $paymentRate = $validated['confirmer_payment_rate_per_order'];
        }

        $profile->fill([
            'name'                      => $validated['name'],
            'email'                     => $validated['email'],
            'confirmer_payment_type'    => $validated['confirmer_payment_type'],
            'confirmer_payment_rate'    => $paymentRate,
            'confirmer_cancellation_rate' => ($request->confirmer_payment_type === 'per_order') ? $validated['confirmer_cancellation_rate'] : null,
            'salary_payout_day'         => ($request->confirmer_payment_type === 'monthly_salary') ? $validated['salary_payout_day'] : null,
        ]);

        if (!empty($validated['password'])) {
            $profile->password = Hash::make($validated['password']);
        }

        $profile->save();

        $profile->syncRoles([$validated['role']]);

        return redirect()->route('profile.index')->with('success', 'تم تحديث المستخدم بنجاح');
    }
    public function destroy(User $profile)
    {
        $profile->delete();
        return to_route('profile.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }
}
