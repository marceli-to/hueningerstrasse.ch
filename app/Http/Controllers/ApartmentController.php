<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Actions\GetData;
use App\Actions\ExportData;

class ApartmentController extends Controller
{
  public function index()
  {
    // get data from api or storage
    $data = (new GetData)->execute();

    // filter out items with "object_category":"APARTMENT"
    $data = collect($data)->filter(function ($item, $key) {
      return $item['object_category'] == 'APARTMENT';
    });

    // init array of apartments with buildings
    $apartments = ['building_1', 'building_2', 'building_3'];

    // group apartments by building
    $apartments = collect($data)->sortBy('floor')->groupBy(function ($item, $key) {
      $ref_house = substr($item['ref_house'], 0, 2);
      if (in_array($ref_house, ['01', '02', '03', '04']))
      {
        return 'building_1';
      } 
      elseif (in_array($ref_house, ['05', '06', '07', '08']))
      {
        return 'building_2';
      } 
      elseif (in_array($ref_house, ['09', '10']))
      {
        return 'building_3';
      }
    });

    // addresses
    $addresses = [
      'building_1' => 'Wiedingstrasse 87a–d',
      'building_2' => 'Austrasse 50–56',
      'building_3' => 'Austrasse 46/48',
    ];

    $reference_date = [
      'building_1' => '01.06.2024',
      'building_2' => '01.08.2024',
      'building_3' => '01.05.2024',
    ];

    return view('pages.apartments', ['apartments' => $apartments, 'addresses' => $addresses, 'reference_date' => $reference_date]);
  }
}
