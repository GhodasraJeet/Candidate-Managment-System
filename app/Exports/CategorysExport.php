<?php

namespace App\Exports;

use App\Category;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class CategorysExport implements FromCollection,WithMapping,WithHeadings
{
    use Exportable;
    public function __construct(int $page,String $token)
    {
        $this->page = $page;
        $this->token=$token;
    }

    public function headings() : array
    {
        return [
            'id',
            'name',
            'created_at'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/category");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        $a=json_decode($output,true);
        curl_close($ch);
        dd($a);
        // $category = Curl::to('http://localhost/candidate/public/api/category?page='.$this->page)
        //     ->withBearer($this->token)
        //     ->asJson()
        //     ->get();
            // return $a['data']['data'];
// dd($category);
            // return Category::all();
            // return new Collection($category);
        // return $a->data;
    }
    public function map($category) : array
    {
        // dd($category);
        return[
            $category['id'],
            $category['name'],
            $category['created_at']
        ];
    }
    // public function query()
    // {
        // dd('aa');
    //     return Category::all();
    // }
    // public function view() : View
    // {
    //     return view('example', [
    //         'invoices' => Category::all()
    //     ]);
    // }
    // public function map($invoice): array
    // {
    //     return [
    //         $invoice->invoice_number,
    //         Date::dateTimeToExcel($invoice->created_at),
    //     ];
    // }
}
