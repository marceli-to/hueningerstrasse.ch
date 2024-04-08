<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Actions\GetData;
use App\Actions\ExportData;

class BusinessController extends Controller
{
  public function index()
  {
    // get data from api or storage
    $data = (new GetData)->execute();

    // filter out items with "object_category": "APARTMENT"
    $apartments = collect($data)->filter(function ($item, $key) {
      return $item['object_category'] == 'INDUSTRY';
    });

    // sort apartments by number
    $apartments = collect($apartments)->sortBy('reference');

    return view('pages.business', ['apartments' => $apartments]);
  }
}
