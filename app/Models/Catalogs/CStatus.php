<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 May 2018 05:11:09 +0000.
 */

namespace App\Models\Catalogs;

use Reliese\Database\Eloquent\Model as Eloquent;


class CStatus extends Eloquent
{
	public static $ACTIVO = 1;
	public static $INACTIVO = 2;
	public static $ELIMINADO = 3;
	public static $TEMPORAL = 4;

}
