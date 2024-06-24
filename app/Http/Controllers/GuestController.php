<?php

namespace App\Http\Controllers;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function index():View
    {
        $pages = Page::limit(4)->get();
        return view('guest.index', ['pages' => $pages]);
    }
}
