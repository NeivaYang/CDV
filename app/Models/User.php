<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nome', 'email', 'password', 'celular', 'codigo_idioma', 'situacao', 'admin', 'id_cargo', 'id_cdc', 'codigo', 'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates =  ['deleted_at'];

    public static function getListaDeIdiomas(){
        $idiomas = [
            ['chave'=>'0','valor'=>'pt-br'],
            ['chave'=>'1','valor'=>'en'],
            ['chave'=>'2','valor'=>'es'],
        ];
        return $idiomas;
    }

    public static function validaEmail($email, $id = null){
        $user = User::select('id')->where('email', $email)->first();
        if(empty($user)){
            return true;
        }else if($id != null && $user['id'] == $id){
            return true;
        }else{
            return false;
        }
    }

    public static function verificarUserAtivo($email){
        $user = User::select('situacao')->where('email', $email)->first();
        if(empty($user) || $user['situacao'] == 0 ){
            return false;
        }else{
            return true;
        }
    }

    public static function verificarUserAdmin($email){
        $user = User::select('admin')->where('email', $email)->first();
        if(empty($user) || $user['admin'] == 0 ){
            return false;
        }else{
            return true;
        }
    }

    public static function gerarCodigoUser($nomecompleto)
    {
        $codigo = '';
        $maior = '0';

        $x = explode(" ", $nomecompleto);
        $letra1 = substr($x[0],0,1);
        $y = count($x)-1;
        $letra2 = substr($x[$y],0,1);
        $sigla = strtoupper($letra1.$letra2);

        $users = User::whereRaw('substr(codigo, 1,  2) = "'.$sigla.'"')->max('codigo');
        if ($users) {
            $maior = substr($users,2,2);
        }
        $codigo = $sigla.(str_pad(($maior+1),2,"0",STR_PAD_LEFT));

        return $codigo;
    }
}
