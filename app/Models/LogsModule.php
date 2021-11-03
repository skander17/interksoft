<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Log;

/**
 * @property string $module nombre del modulo
 * @property string $action, el tipo de operacion: list, create, update, get, delete, stast, report
 * @property string $path  la ruta de la interfaz grafica que llama al metodo.
 * @property string $ip, ip del cliente que realizo la peticion
 * @property string $request, cuerpo del request
 * @property string $headers, cabeceras del request
 * @property string $username  el nombre del usuario que hizo la operacion
 * @property string  $useremail  el email del usuario que hizo la operacion
 * @property string  $role  el role del usuario que hizo la operacion
 */
class LogsModule extends Model
{
    use HasFactory;
    protected $table = 'logs_module';
    protected $fillable = [
        'id',
        'module',
        'action',
        'path',
        'ip',
        'request',
        'headers',
        'username',
        'useremail',
        'role',
        'created_at',
        'updated_at',

    ];

    protected $appends = [
        'formattedCreatedAt',
    ];

}
