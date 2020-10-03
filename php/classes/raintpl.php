<?php
/**
 *
 * @author CHAUTARD
 *
 */

include "raintpl/rain.tpl.class.php";

raintpl::configure("base_url", null );
raintpl::configure("path_replace", false);
raintpl::configure("tpl_dir", str_replace('classes', 'templates', __DIR__ ) . DIRECTORY_SEPARATOR);
raintpl::configure("cache_dir", str_replace('classes', 'cacheRainTpl', __DIR__ ) . DIRECTORY_SEPARATOR );

//initialize a Rain TPL object
$tpl = new RainTPL;
