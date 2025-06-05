<?php
namespace App\Http\Controllers;

class CalendarController extends Controller
{
public function index()
    {
        $categories = Calendar::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }









}
?>