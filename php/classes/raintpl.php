<?php
/**
 * raintpl.ph
 * 
 * Version : 1.0.0
 * Date : 2020-10-06
 * @author CHAUTARD
 *
 */

include "raintpl/rain.tpl.class.php";

raintpl::configure("base_url", null );
raintpl::configure("path_replace", false);
raintpl::configure("tpl_dir", str_replace('classes', 'html', __DIR__ ) . DIRECTORY_SEPARATOR);
raintpl::configure("cache_dir", str_replace('classes', 'cacheRainTpl', __DIR__ ) . DIRECTORY_SEPARATOR );

//initialize a Rain TPL object
$tpl = new RainTPL;
