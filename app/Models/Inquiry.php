<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
  protected $fillable = [
    'firstname',
    'name',
    'street',
    'location',
    'email',
    'phone',
    'message',
    'interest'
  ];
}
