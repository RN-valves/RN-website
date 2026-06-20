<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Mail\Attachable;
use Illuminate\Mail\Attachment;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements Attachable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard_name = 'web';
    protected $guard = 'user';
    
    protected $fillable = [
        'country_id',
        'state_id',
        'city_id',
        'pincode_id',
        'user_type',
        'user_code',
        'name',
        'email',
        'mobile',
        'uuid',
        'password',
        'zipcode',
        'address',
        'date_of_join',
        'local_password',
        'profession',
        'gst_number',
        'sales_user_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'local_password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_join' => 'immutable_datetime',
        ];
    }

    public function getRouteKeyName(){
        return 'uuid';
    }
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }
    public function state(){
        return $this->belongsTo(State::class,'state_id');
    }
    public function sales_user(){
        return $this->belongsTo(User::class,'sales_user_id');
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function reporting_users(){
        return $this->hasMany(ReportUser::class,'user_id');
    }
    public function addresses(){
        return $this->hasMany(UserAddress::class,'user_id');
    }
    public function logables(){
        return $this->morphMany(RemarkLog::class, 'logable');
    }

    public function customerEditLogs(){
        return $this->hasMany(EditLog::class, 'customer_id');
    }

    public function userEditLogs(){
        return $this->hasMany(EditLog::class, 'user_id');
    }

    public static function getSingleUser($id){
        return self::where('id','=',$id)
            ->first();
    }

    public function toMailAttachment(): Attachment
    {
        return Attachment::fromPath(url(frontPage()->logo??''));
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id');
    }

    public static function professions(){
        return array('Distributor','Retailer','Dealer', 'Architect', 'Interier-Designer', 'Consultant', 'Contractor', 'Plumber', 'Consumer');
    }

    public static function last_order($user_id){
        return Order::where(['user_id'=>$user_id, 'is_payment'=>'Yes'])->latest()->first();
    }

    public static function getEmployeeList(){
        return User::where('user_type','=','Employee')
            ->where('users.status','=','Active')
            ->get();
    }
}
