<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Token_User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //check data and return error
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'meta_title' => ['sometimes', 'string', 'max:255'],
                'meta_description' => ['sometimes', 'string'],
            ]);

        //get token => get user;
            $token_check = $request->bearerToken();
            $token = Token_User::where('token', $token_check)->first();
            //get user
                $user = $token->user;

        //create new record
            $course = Course::create([
               'title' => $request->title,
               'description' => $request->description,
               'meta_title' => $request->meta_title,
               'user_id' => $user->user_id,
               'meta_description' => $request->meta_description,
            ]);

        return response()->json([
            'course' => $course,
            'message' => 'Course added successfully',
        ], 201);

    }

    public function show(Course $course)
    {
        //
    }

    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
