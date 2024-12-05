<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        ];
    }
    public function person(){
        return $this->belongsTo(Person::class);
    }
    public function sales(){
        return $this->hasMany(Sale::class);
    }
    public function getImagenAttribute()
    {
        if($this->foto)
        {
            return file_exists(public_path('storage/users/'.$this->foto))?asset('storage/users/'.$this->foto):$this->defaultImage();
        }
        else{
            return $this->defaultImage();
        }

    }
    public function defaultImage()
    {
        if($this->nombre){
            $nombre=$this->nombre;
        }else{
            $nombre=$this->person->nombre;

        }
        $name=trim(collect(explode(' ',$nombre))->map(function($segment){
            return mb_substr($segment,0,1);
        })->join(' '));
        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random&color=0000ff';
    }
    public function scopeQuestion($query){
        return $query->join('people as p','p.id','users.person_id')
        ->join('model_has_roles as hr','hr.model_id','users.id')
        ->join('roles as r','r.id','hr.role_id')
        ->select('r.name as role','users.person_id','users.email','p.nombre','p.apellido','p.telefono','p.ci','p.estado','users.foto','p.id');
    }
    public function productions(){
        return $this->hasMany(Production::class);
    }
    public function getFullNameAttribute(){
        return $this->person->nombre.' '.$this->person->apellido;
    }
    public function user_productions()
    {
        return $this->belongsToMany(Production::class)->withPivot('entrada','salida')
        ->using(UserProduction::class);
    }
    public function getFullPriceAttribute()
    {
        return $this->sales->pluck('products')->collapse()->sum('pivot.precio');

    }
    public function buys(){
        return $this->hasMany(Buy::class);
    }
}
