<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Token_User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Show all Course
    public function index()
    {
        //
    }

    //Show lessons of one Course
    public function show(Request $request){

        //get course
            $course = Course::where('course_id', $request->course_id)->first();

            if(!$course)
                return response()->json(['error'=>'course not found'],404);


            $lessons = $course->lessons
                ->map(function($lesson){
                    return [
                        'id' => $lesson->id,
                        'title' => $lesson->meta_title,
                        'description' => $lesson->meta_description,
                        'course' => $lesson->course->title,
                    ];
                });

            return response()->json([
                'course' => $course,
                'lessons' => $lessons
            ], 200);
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


    public function update(Request $request, Course $course)
    {
        //get token for get user
            $token_c = $request->bearerToken();
            $token = Token_User::where('token', $token_c)->first();


        //check if this user create course change else return error

            if(!$course->user?->user_id === $token->user?->user_id)
                return response()->json([
                    'error' => 'you are not authorized to access this page',
                ], 403);
            else
            {
                //check data and return error
                    $request->validate([
                        'title' => ['sometimes', 'string', 'max:255'],
                        'description' => ['sometimes', 'string'],
                        'meta_title' => ['sometimes', 'string', 'max:255'],
                        'meta_description' => ['sometimes', 'string'],
                    ]);

                //update this course
                    $course->update($request->all());

                return response()->json([
                    'course' => $course,
                    'message' => 'Course updated successfully',
                ], 201);
            }
    }

    public function destroy(Course $course, Request $request)
    {
        $token_c = $request->bearerToken();
        $token = Token_User::where('token', $token_c)->first();

        if($course->user->user_id === $token->user?->user_id) {
            $course->delete();

            return response()->json([
                'message' => 'Course deleted successfully',
            ], 200);
        }else
            return response()->json([
                'error' => 'you are not authorized to access this page',
            ], 403);
    }
}
