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

/**
 * Join two (or more) specified paths to the base path.
 * @return string The joined path.
 */
function join_path(string $base, string ...$paths)
{
    foreach ($paths as $path)
        $base .= DIRECTORY_SEPARATOR . $path;
    return $base;
}


/**
 * Checks if directory has files in them.
 * @return bool
 */
function has_files(Directory $dir)
{
    while (false !== ($entry = $dir->read())) :
        $file = join_path($dir->path, $entry);
        if (file_exists($file) && !is_dir($file))
            return true;
    endwhile;

    return false;
}


/**
 * Walk directories gathering those with files in them.
 */
function walk($dir, &$paths = null)
{
    $dir = dir($dir);
    while (false !== ($entry = $dir->read())) :
        $path = $dir->path . DIRECTORY_SEPARATOR . $entry;
        if (is_dir($path) && !strstr($entry, '.')) :
            $folder = dir($path);
            if (has_files($folder)) :
                $paths[] = $path;
            endif;
            $folder->close();
            walk($path, $paths);
        endif;
    endwhile;
    $dir->close();
}


// Builds the class include path to be used by the class autoloader.
function build_include_path()
{
    walk(__DIR__, $paths);
    return $paths;
}


/**
 * The Class autoload function.
 * @return void
 */
function ClassAutoload($qualified_name)
{
    $paths = explode(';', CLS_INC_PATH);
    $class = explode('\\', strtolower($qualified_name));
    $cls = array_pop($class);

    foreach ($paths as $path) :
        $file = join_path($path, "$cls.php");

        if (!file_exists($file))
            continue;
        include($file);
        return;
    endforeach;

    trigger_error("Unable to include '$cls.php', class not found.", E_USER_ERROR);
}

function alert($head, $msg, $level)
{
    $icon = ($level == 'success' ? 'fa-check-square' : ($level == 'info' ? 'fa-info-circle' : ($level == 'warning' ? 'fa-warning' : 'fa-times-circle')));

    echo "<div class=\"alert alert-$level\" role=\"alert\">"
        . "<h4 class=\"alert-heading\">$head</h4>"
        . "<p>$msg</p>"
        . "</div>";
}

function get_gender($gender)
{
    if ($gender == '0')
        return 'Rather Not Say';
    else
        return $gender == '1' ? 'Male' : 'Female';
}

function format_number($number)
{
    $pattern = '/(\+27|0)([0-9]{9})/';
    if (preg_match($pattern, $number, $matches)) {
        $new = '0';
        for ($s = 0, $e = 2; $s < 6; $s += 2, $e++)
            $new .= substr($matches[2], $s, $e) . ' ';
        return $new;
    }
}


/*
* A pagination class would probably be more suited here, and with proper abstraction
* it could be used to create pagination for different table records. But for now I've
* for a function that does this instead.
*/
function paginator($link, $table, $data, $page)
{
    $read = new Small\Database\Read;
    $read->Select($table, '*');
    $rows = $read->getRowCount();

    if ($rows > 10) {
        $pages = ceil($rows / 10);
        $maxlinks = 4;

        $paginator = '<ul class="pagination">';

        if ($page > 1) {
            $data['page'] = (string) ($page - 1);
            $backlink = "$link&" . http_build_query($data);
            $paginator .= <<<HERE
            <li class="page-item">
                <a id="prev" class="page-link" href="$backlink" aria-label="Back">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
HERE;
        }

        for ($p = $page - $maxlinks; $p <= $page - 1; $p++) {
            if ($p >= 1) {
                $data['page'] = (string) ($p);
                $plink = "$link&" . http_build_query($data);
                $paginator .= "<li class=\"page-item\"><a class=\"page-link\" href=\"{$plink}\">{$p}</a></li>";
            }
        }

        $data['page'] = (string) ($page);
        $active = "$link&" . http_build_query($data);
        $paginator .= '<li class="page-item active"><a class="page-link" href="' . $active . '">' . $page . '</a></li>';

        for ($n = $page + 1; $n <= $page + $maxlinks; $n++) {
            if ($n <= $pages) {
                $data['page'] = (string) ($n);
                $nlink = "$link&" . http_build_query($data);
                $paginator .= "<li class=\"page-item\"><a class=\"page-link\" href=\"{$nlink}\">{$n}</a></li>";
            }
        }

        if ($page < $pages) {
            $data['page'] = (string) ($page + 1);
            $nextlink = "$link&" . http_build_query($data);
            $paginator .= <<<HERE
            <li class="page-item">
                <a id="next" class="page-link" href="$nextlink" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
HERE;
        }

        $paginator .= '</ul>';

        return $paginator;
    }
}
