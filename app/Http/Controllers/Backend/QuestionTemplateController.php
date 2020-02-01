<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Model\Subject;
use App\Model\Department;
use App\Model\QuestionType;
use App\Model\Question;
use App\Model\QuestionTemplate;
use Illuminate\Http\Request;

class QuestionTemplateController extends Controller
{
   
    public function index(Request $request)
    {
        $perPage = $request->perPage ?: 10;
        
        $questionTemplates =  QuestionTemplate::with('department', 'subject', 'questionType');
        $questionTemplates = $questionTemplates->latest()->paginate($perPage);

        return view('backend.questionTemplate.index', compact('questionTemplates'));
    }

    public function create()
    {
        $departments   = Department::get();
        $subjects      = Subject::get();
        $questionTypes = QuestionType::get();

        return view('backend.questionTemplate.create', compact('departments', 'subjects', 'questionTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id'    => 'required',
            'subject_id'       => 'required',
            'question_type_id' => 'required',
            'total_questions'  => 'required',
            'total_marks'      => 'required'
        ]);

        QuestionTemplate::create($request->all());

        return redirect()->route('questionTemplates.index')->with('successTMsg','Question Template save successfully');
    }
   
    public function edit(QuestionTemplate $questionTemplate)
    {
        $departments   = Department::get();
        $subjects      = Subject::get();
        $questionTypes = QuestionType::get();

        return view('backend.questionTemplate.edit', compact('questionTemplate', 'departments', 'subjects', 'questionTypes'));
    }

    public function update(Request $request, QuestionTemplate $questionTemplate)
    {
         $request->validate([
            'department_id'    => 'required',
            'subject_id'       => 'required',
            'question_type_id' => 'required',
            'total_questions'  => 'required',
            'total_marks'      => 'required'
        ]);

        $questionTemplate->update($request->all());
        return redirect(route('questionTemplates.index'))->with('successTMsg', 'Question Template has been updated successfully');
    }

    public function destroy(QuestionTemplate $questionTemplate)
    {
        $questionTemplate->delete();
        return back()->with('successTMsg', 'Question template has been deleted successfully');
    }
}