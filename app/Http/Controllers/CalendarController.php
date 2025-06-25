<?php
namespace App\Http\Controllers;

use App\Models\Category;

class CalendarController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }









}
?>