<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Shop;
use App\Transaction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Paypack\Paypack;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }

    public function importStudents(Request $request){

        // 
        $filePath = Storage::putFile("public/", $request->file('file'));
        // $filePath = str_replace("public/", "", $filePath);
        Excel::import( new UsersImport,$filePath);
        Log::info($filePath);
        
    }




    public function addCard(Request $request){

        $student =Student::where('reg_no',$request->reg_no)->first();
        $regnumber = Student::where('card_number',$request->card_number)->first();
        if($regnumber){
            return response()->json(['message'=>'Card already exist in system'],Response::HTTP_BAD_REQUEST);
        }
        if($student){
            Student::where('reg_no',$request->reg_no)->update(['card_number'=>$request->card_number]);
            return response()->json(['message'=>'Saved'],Response::HTTP_OK);
        }else{
            return response()->json(['message'=>'Invalid regnumber'],Response::HTTP_BAD_REQUEST);
        }
    }


    public function charge(Request $request){
        $regnumber = Student::where('card_number',$request->card_number)->first();
        if(!$regnumber){
            return response()->json(['message'=>'Invalid Card'],Response::HTTP_BAD_REQUEST);
        }

        $balance = $regnumber->balance - $request->amount;
        if($balance<0){
            return response()->json(['message'=>'Not enough funds!'],Response::HTTP_BAD_REQUEST);
        }else{
            Student::where('card_number',$request->card_number)->update(['balance'=>$balance]);
            $shop=Shop::where('user_id',$request->user);
            $balance1 = $shop->first()->balance+$request->amount;
            $shop->update(['balance'=>$balance1]);
            $transaction = new Transaction();
            $transaction->type='CHARGE';
            $transaction->student_id = $regnumber->user_id;
            $transaction->shop_id = $shop->first()->id;
            $transaction->amount=$request->amount;
            $transaction->save();
            return response()->json(['message'=>'Payment Received'],Response::HTTP_OK);
        }

    }


  public  function initTransaction(Request $request){
        $paypackInstance = new Paypack();
        $paypackInstance->config([
        'client_id' =>"79af0806-8626-11ed-b253-dead986dd4f7",
        'client_secret' => "f1acd81cae8d7e67bf23fa4785ffde11da39a3ee5e6b4b0d3255bfef95601890afd80709",
        ]);
        $cashin = $paypackInstance->Cashin([
            'phone' => $request->phone,
            'amount' => $request->amount,
        ]);
        $transaction = new Transaction();
        $transaction->student_id=$request->user;
        $transaction->amount=$cashin['amount'];
        $transaction->type='RECHARGE';
        $transaction->ref=$cashin['ref'];
        $transaction->save();
        

        
    }

    public function updatePayment(Request $request){


        $transaction = Transaction::where('ref',$request->data['ref'])->first();

        $student = Student::where('user_id',$transaction->student_id);

        $balance = $student->first()->balance + $request->data['amount'];
        $student->update(['balance'=>$balance]);
        return response()->json(['message'=>'Payment Received'],Response::HTTP_OK);
    }

}
