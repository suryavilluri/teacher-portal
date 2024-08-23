<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class TeacherController extends Controller
{
    public function index()
    {
        $teacherId = \Session::get('teacher_id');
        $data['students'] = Student::where(['teacher_id' => $teacherId])->get();
        return view('teacher.home')->with($data);
    }

    public function studentAdd(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'marks' => 'required|integer|min:0',
        ]);

        $id = $request->id;
        $name = $request->name;
        $subject = $request->subject;
        $marks = $request->marks;
        $teacherId = \Session::get('teacher_id');

        if(isset($id)) {
            $student = Student::find($id);
            if ($student) {

                $existingStudent = Student::where('name', $name)
                    ->where('subject', $subject)
                    ->where('teacher_id', $teacherId)
                    ->where('id', '!=', $id)
                    ->first();

                if ($existingStudent) {
                    $existingStudent->marks += $marks;
                    $existingStudent->save();

                    return redirect()->back()->with('success', 'Marks updated for existing student.');
                } else {
                    $student->name = $name;
                    $student->subject = $subject;
                    $student->marks = $marks;
                    $student->teacher_id = $teacherId;
                    $student->save();

                    return redirect()->back()->with('success', 'Student updated successfully.');
                }
            } else {
                return redirect()->back()->with('error', 'Student not found.');
            }
        } else {

            $student = Student::where('name', $name)
                ->where('subject', $subject)
                ->where('teacher_id', $teacherId)
                ->first();

            if ($student) {
                $student->marks += $marks;
                $student->save();

                return redirect()->back()->with('success', 'Marks updated for existing student.');
            } else {
                Student::create([
                    'name' => $name,
                    'subject' => $subject,
                    'marks' => $marks,
                    'teacher_id' => $teacherId
                ]);

                return redirect()->back()->with('success', 'Student created successfully.');
            }
        }

        return redirect()->route('teacher.home');
    }

    public function deleteStudent($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();
            return response()->json(['success' => true, 'message' => 'Student deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Student not found.'], 404);
    }
}
