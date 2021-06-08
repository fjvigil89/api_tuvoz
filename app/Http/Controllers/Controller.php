<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API TuVoz",
 *      description="Documentación API TuVoz",
 *      @OA\Contact(
 *          email="frankjosue.vigilvega@gmail.com"
 *      )
 * )
 * 
 * @OA\Tag(
 *     name="Usuarios",
 *     description="Todo sobre los Usuarios",
 *     @OA\ExternalDocumentation(
 *         description="Más",
 *         url="https://gitlab.com/frankjosue.vigilvega/voicerecord/-/blob/master/app/User.php"
 *     )
 * )
 * @OA\Tag(
 *     name="Tratamientos",
 *     description="Accesos a los Tratamientos",
 *      @OA\ExternalDocumentation(
 *         description="Más",
 *         url="https://gitlab.com/frankjosue.vigilvega/voicerecord/-/blob/master/app/Treatment.php"
 *     )
 * )
 * @OA\Tag(
 *     name="Frases",
 *     description="Sobre las Frases",
 *    @OA\ExternalDocumentation(
 *         description="Más",
 *         url="https://gitlab.com/frankjosue.vigilvega/voicerecord/-/blob/master/app/Phrase.php"
 *     )
 * )
 * @OA\Server(
 *     description="Web TuVoz",
 *     url="http://155.210.158.136:8000"
 * )
 * @OA\ExternalDocumentation(
 *     description="Nuestros repositorios",
 *     url="https://gitlab.com/frankjosue.vigilvega"
 * )
 * 
 * @OAS\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
