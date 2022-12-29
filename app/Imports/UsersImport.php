<?php

namespace App\Imports;

use App\Student;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;

class UsersImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if($key > 0){
                $user = new User();
                $user->first_name = $row[1];
                $user->last_name = $row[1];
                $user->email = $row[2];
                $user->role = "STUDENT";
                $user->photo = $row[5];
                $user->password=Hash::make($row[0]);
                $user->save();

                
                $student = new Student();


                $student->reg_no = $row[0];
                $student->user_id = $user->id;
                $student->department = $row[4];
                $student->faculity = $row[6];
                $student->save(); 
            }
            
        }
    }
}
