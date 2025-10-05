<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Models\Token_User;
use http\Env\Response;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //Enroll a user in the given course.
    public function enroll(Request $request){

        //get user with token
          $token_c = $request->bearerToken();
          $token = Token_User::where('token', $token_c)->first();

          $user = $token->user;

          $course_id = $request->input('course_id');

        //check if course exist enroll in course
            if(Course::where('course_id', $course_id)->exists()){
                if(!$user->courses->where('course_id', $course_id)->exist())
                    $user->courses()->attach($course_id);
                else
                    return \response()->json([
                        'error' => 'You are already enrolled in this course.'
                    ], 409);
            }

          return response()->json([
              'message' => 'User successfully enrolled in this course.',
          ], 200);
    }

    //* Unenroll the given user from this course.
    public function unenroll(Request $request){
        //get user with token
          $token_c = $request->bearerToken();
          $token = Token_User::where('token', $token_c)->first();

          $user = $token->user;

          $course_id = $request->input('course_id');

        //check if user enroll in this course unenroll
            if($user->courses->where('course_id', $course_id)->exists()) {

                $user->courses()
                    ->where('course_id', $course_id)
                    ->detach($course_id);

                return response()->json([
                    'message' => 'User successfully unenrolled in this course.'
                ], 200);

            }else
                return \response()->json([
                    'error' => 'You are not enrolled in this course.'
                ], 404);
    }
}
