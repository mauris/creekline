<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline\Repository;

/**
 * UrlRepository class
 *
 * A repository that handles a URL
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline\Repository
 * @since 1.0.0
 */
abstract class UrlRepository implements RepositoryInterface
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public static function factory($url)
    {
        if (substr($url, 0, 6) == 'git://') { // git
            return new Git($url);
        } elseif (substr($url, 0, 7) == 'http://' || substr($url, 0, 8) == 'https://') { // HTTP
            $parts = parse_url($url);
            if ($parts['host'] == 'github.com' || $parts['host'] = 'www.github.com') {
                return new Github($url);
            } elseif ($parts['host'] == 'bitbucket.org' || $parts['host'] = 'www.bitbucket.org') {
                return new BitBucketGit($url);
            }
        } elseif (preg_match('{^(.+)\@(.+)\:(.+)$}is', $url)) { // SSH scheme
            return new Git($url);
        }
        return null;
    }
}
