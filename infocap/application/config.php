<?php
/*
*  -----------------------------------------------------------------------------
*  Small Framework :: PHP
*  -----------------------------------------------------------------------------
*  Copyright notices and stuff...
*
*  @package    Small Framework :: PHP
*  @author     Ngoy Pedro C. Lufo (change this for the overall project)
*  @version    0.0.1 development
*  @copyright  Copyright (c) 2018, Ngoy Pedro C. Lufo.
*/
require 'functions.php';

/* Core functionality */
spl_autoload_register('ClassAutoload');

define("CLS_INC_PATH", implode(';', build_include_path()));
