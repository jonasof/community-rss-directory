<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feed\Importer;

class FeedImportController extends Controller
{
    public function parse(Request $request, Importer $importer)
    {
        return  $importer->getImportableItems($request->file("feeds")->get());
    }
}