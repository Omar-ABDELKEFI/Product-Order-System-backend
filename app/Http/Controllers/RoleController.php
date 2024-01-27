<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        return RoleResource::collection(Role::all());
    }

    public function store(Request $request)
    {
        $role = Role::create($request->only('name'));

        $role->permissions()->attach($request->input('permissions'));

        return response(new RoleResource($role->load('permissions')), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        return new RoleResource(Role::with('permissions')->find($id));
    }

    public function update(Request $request, $id)
    {
        // Get the authenticated user
        $user = Auth::user();
    
        // Check if the user has access to "edit_roles"
        if (!$user->hasAccess("edit_roles")) {
            // User does not have access, return unauthorized response
            return response('Unauthorized: Insufficient permissions', 403);
        }
    
        // User has access, proceed with the update logic
        $role = Role::find($id);
    
        // Update the role's attributes
        $role->update($request->only('name'));
    
        // Synchronize the permissions associated with the role
        $role->permissions()->sync($request->input('permissions'));
    
        // Return a response with a RoleResource representation of the updated role
        return response(new RoleResource($role->load('permissions')), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        Role::destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
