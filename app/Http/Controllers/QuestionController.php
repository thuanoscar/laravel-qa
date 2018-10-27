<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['questions'] = Question::with('user')->latest()->paginate(10);
        return view('questions.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Gate::denies('create-question')){
            abort(403,'Access denied');
        }
        $data['title'] = old('title');
        $data['body'] = old('body');
        return view('questions.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success','You question has been');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
      $question->increment('views');
      return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // $this->authorize('update', $question);
        if(\Gate::denies('update-question',$question)){
            abort(403,'Access denied');
        }
        $question = Question::findOrFail($question->id);
        $data['title'] = $question->title;
        $data['body'] = $question->body;
        $data['id'] = $question->id;
        return view('questions.edit',$data);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request,Question $question)
    {
        if(\Gate::denies('update-question',$question)){
            abort(403,'Access denied');
        }
        $question->update($request->only('title','body'));
        return redirect('/questions')->with('success','Your question has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if(\Gate::denies('delete-question',$question)){
            abort(403,'Access denied');
        }
        $question->delete();
        return redirect('/questions')->with('success','Your question has been deleted');
    }
}
