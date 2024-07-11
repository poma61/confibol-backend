<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Throwable;

class RoleController extends Controller
{
    public function list()
    {
        try {

            $role = Role::all();

            return response()->json([
                'records' => $role,
                'status' => true,
                'message' => "OK",
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'records' => null,
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

} //class
