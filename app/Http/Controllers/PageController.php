<?php
namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;



class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $pages = Page::all();
        return view('pages.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $page = new Page();
        $page->name = $request->name;
        $page->user_id = auth()->id();
        $page->date = $request->date;
        $page->save();
        $id = $page->id;
        foreach ($request->images as $fille){
            $extension  = $fille->getClientOriginalExtension();
            $image = new Image();
            $image->page_id = $id;
            $image->name = md5(bcrypt(date('l jS \of F Y h:i:s A'))).'.'.$extension;
            $fille->move(public_path(env('UPLOADS_IMAGE')), $image->name);
            $image->save();
        }
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
         $page = Page::findOrFail($page);
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page):RedirectResponse
    {
         $page->update($request->all());
        return redirect()->back()->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page):RedirectResponse
    {
        foreach ($page->images as $image) {
            $image->delete();
        }
        
        $page->delete();
        return redirect()->back()->with('success', 'Deleted');
    }
}
