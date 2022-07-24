<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Resources\Admin\AdminAuthResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AdminAuthController extends Controller
{


    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('phone', $request->phone)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->makeToken($admin);
    }


    public function makeToken($admin)
    {
        $token =  $admin->createToken('admin-token')->plainTextToken;
        return (new AdminAuthResource($admin))
            ->additional(['meta' => [
                'token' => $token,
                'token_type' => 'Bearer',
            ]]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return send_ms('admin logout', true, 200);
    }

    public function user(Request $request)
    {
        return AdminAuthResource::make($request->user());
    }
}
