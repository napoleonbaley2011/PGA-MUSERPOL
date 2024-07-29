<?php

namespace App\Models;

use Carbon\Carbon;
use App\Helpers\Util;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  use HasFactory;
  protected $dates = ['deleted_at'];
  public $timestamps = true;
  public $guarded = ['id'];
  protected $fillable = ['city_identity_card_id', 'management_entity_id', 'identity_card', 'first_name', 'second_name', 'last_name', 'mothers_last_name', 'surname_husband', 'birth_date', 'city_birth_id', 'account_number', 'country_birth', 'nua_cua', 'gender', 'location', 'zone', 'street', 'address_number', 'phone_number', 'landline_number', 'active', 'addmission_date'];

  protected $table = "public.employees";

  public function fullName($style = "uppercase", $order = "name_first")
  {
    return Util::fullName($this, $style, $order);
  }
  public function getFullNameAttribute()
  {
    return rtrim(preg_replace('/[[:blank:]]+/', ' ', join(' ', [$this->last_name, $this->mothers_last_name, $this->surname_husband, $this->first_name, $this->second_name])));
  }
  public function users()
  {
    return $this->hasMany(User::class);
  }
  public function note_requests()
  {
    return $this->hasMany(NoteRequest::class);
  }
}
