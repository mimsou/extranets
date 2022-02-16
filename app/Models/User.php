<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'role_lvl', 'employeur_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function initials(){
        $firstname = $this->firstname;
        $initials = strtoupper(trim($firstname[0]));
        if(Str::contains($firstname,'-')){
            $exploded_name = explode('-', $firstname);
            $initials .= $exploded_name[1][0];
        }
        $lastname = trim($this->lastname);
        $initials .= strtoupper($lastname[0]);

        return $initials;
    }

    public function getFullNameAttribute($value)
    {
        return "{$this->firstname} {$this->lastname}";
        return $this->firstname . ' ' . $this->lastname;
    }

    public function employerProjects()
    {
        $employer_id = $this->employeur_id;
        if(is_null($this->employeur_id)) return false;

        return Projet::has('employeur')
            ->orWhereHas('demandes', function($q) use ($employer_id) {
                $q->where('employeur_id', '=', $employer_id);
            });

//        $projects = Projet::with('demandes')
//            ->where(function($query) use($employer_id) {
//                $query
//                    ->where('employeur_id', '=', $employer_id)
//                    ->orWhereHas('demandes', function($q) use ($employer_id) {
//                        $q->where('employeur_id', '=', $employer_id);
//                    });
//            });
//        $projects = Projet::where(function($query) use($employer_id) {
//            $query->where('employeur_id', '=', $employer_id)
//                    ->orwhereHas('demandes', function($q) use ($employer_id) {
//                        $q->where('employeur_id', '=', \Auth::user()->employeur_id);
//                    });
//        });

//        return $projects;
    }

    public function assignedUsers(){
        return $this->belongsToMany('App\Models\Demande', 'demande_users');
    }

    public function group_assoc(){
        return $this->belongsTo(AssocUserMap::class,'id','user_id');
    }
}
