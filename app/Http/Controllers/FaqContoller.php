<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FaqContoller extends Controller
{
    /**
     * Display a listing of the resource. (as we show data in table)
     */
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq.faq',[
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource. as we write return view()
     */
    public function create()
    {
        return view('admin.faq.add');
    }

    /**
     * Store a newly created resource in storage. (as we save data in the database)
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        Faq::insert([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    /**
     * Display the specified resource. (to show details view of a single item.)
     */
    public function show(string $id)
    {
        $faq = Faq::find($id);
        return view('admin.faq.view',[
            'faq' => $faq,
        ]);
    }

    /**
     * Show the form for editing the specified resource. as we write return view() to go to an edit page
     */
    public function edit(string $id)
    {
        $faq = Faq::find($id);
        return view('admin.faq.edit',[
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage. (where we go clicking an button)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        Faq::find($id)->update([
            'question'=>$request->question,
            'answer'=>$request->answer,
            'updated_at'=>Carbon::now(),
        ]);
        return back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faq::find($id)->delete();
        return back();
    }

}
