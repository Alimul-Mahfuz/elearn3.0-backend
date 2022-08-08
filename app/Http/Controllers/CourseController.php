<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enroll;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //Recived course_id and return all studnet details under the course
    function printCoursStudnetList($csid): \Illuminate\Http\JsonResponse
    {
        $coursestudentinfo=array();
        $enrolls=Enroll::where('course_id',$csid)->get();
        $courseinfo=Course::find($csid);
        foreach ($enrolls as $enroll){
            $student=$enroll->student()->first();
            $coursestudentinfo[] = $student;
        }
        return response()->json(["crsinfo"=>$courseinfo,"crsstdinfo"=>$coursestudentinfo],200);
    }
    //Print all the course where active status is 1 and t_id is not null
    function printAllCourse(): \Illuminate\Http\JsonResponse
    {
        $couses=Course::where('status',1)->whereNotNull('t_id')->get();
        return response()->json($couses,200);
    }

    function dropCourse($enrid){
        $enroll=Enroll::find($enrid);
        $enroll->delete();
        return response()->json(['msg'=>"Course dropped"],200);
    }
}
