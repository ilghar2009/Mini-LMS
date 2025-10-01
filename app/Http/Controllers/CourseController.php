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
               'teacher' => $user->user_id,
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


    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
