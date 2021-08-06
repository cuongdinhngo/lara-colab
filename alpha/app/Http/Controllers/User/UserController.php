<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\User\UserInterface;
use Illuminate\Http\Request;
use Cuongnd88\Jutility\Facades\CSV;
use App\Models\User;
use SimpleDatatable;

class UserController extends Controller
{
    protected $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;        
    }

    public function postCSV(Request $request)
    {
        $csv = CSV::read(
                    $request->csv,
                    config('csv.user.header'),
                    config('csv.user.validator')
                );
        $data = $csv->get();
        dump($data);
        $errorList = $csv->validatorErrors();
        dump($errorList);
    }

    public function downloadCSV()
    {
        $data = User::all()->toArray();
        $header = ['ID','Fullname','Email','Mobile number', 'Email verified data time', 'Created date time', 'Updated date time'];
        CSV::save('user-data', $data, $header);
    }

    public function index(Request $request)
    {
        $users = SimpleDatatable::buildQuery(User::query())
                    ->setPerPage(10)
                    ->addIncrement(function($value) {
                        return "#{$value["increment"]}";
                    })
                    ->editColumn('id', function($value) {
                        return "[{$value["id"]}]";
                    })
                    ->editColumn('name', 'user.partials.name')
                    ->addColumn('action', 'user.partials.action')
                    ->make();

        return view('user.index', ['users' => $users]);
    }
}
