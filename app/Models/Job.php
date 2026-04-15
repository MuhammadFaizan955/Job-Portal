<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

   public function JobType()
   {
       return $this->belongsTo(JobType::class, 'job_type_id'); // Make sure foreign key is correct
   }

   public function category()
   {
       return $this->belongsTo(Category::class);
   }
    public function jobApplications(){
         return $this->hasMany(jobApplication::class);
    }

    public function user(){
         return $this->belongsTo(User::class);
    }
}
