<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\QueryReceived;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $query_class = [1,2];

    protected function rules() {
        return [
            'name' => 'required|string|max:50',
            'kana' => 'required|string|max:50|regex:/^[ァ-ヶー　]*$/u',
            'email' => ['required','email','max:100'],
            'class' => ['required',Rule::in($this->query_class)],
            'query' => 'required|string|max:1000'
        ];
    }

    protected $messages = [
        'kana.regex' => '全角カタカナで入力してください'
    ];


    public function query(Request $request) {
        // バリデーションスタート
        $validator = Validator::make(
            $request->post(), $this->rules(), $this->messages
        );

        $data = [];
        if($validator->fails()){
            $data['data']['errors'] = $validator->errors();
            return response()->json($data);
        }

        $date_flag = false;
        $date = Carbon::now()->format('Y/m/d');
        if(!empty($request->post('date'))) {
            $date_flag = true;
            $date = Carbon::parse($request->post('date'))->addDays(7)->format('Y/m/d');
        }

        // 問合せ者に問合せ完了メール
        Mail::to($request->post('email'))
        ->send(new QueryReceived(
            $request->post('name'), $date, $date_flag
        ));

        $data['data']['success'] = true;
        return response()->json($data);

    }

}
