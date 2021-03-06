<?php
/**
 * Creekline
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Creekline;

use Packfire\FuelBlade\ConsumerInterface;

/**
 * Composer class
 *
 * The composer interaction class
 *
 * @author Sam-Mauris Yong / mauris@hotmail.sg
 * @copyright Copyright (c) 2013, Sam-Mauris Yong
 * @license http://www.opensource.org/licenses/bsd-license New BSD License
 * @package Creekline
 * @since 1.0.0
 */
class Composer implements ConsumerInterface
{
    protected $processor = '\\Symfony\\Component\\Process\\Process';

    protected $command = 'php composer.phar';

    public function detect()
    {
        $cmd = 'composer --version';
        $proc = $this->processor;
        $process = new $proc($cmd);
        $result = $process->run() === 0 && substr($process->getOutput(), 0, 8) == 'Composer';
        if ($result) {
            $this->command = 'composer';
        }
        return $result;
    }

    public function download()
    {
        $cache = sys_get_temp_dir() . '/composer.phar';
        if (file_exists($cache)) {
            copy($cache, 'composer.phar');
        } else {
            $cmd = 'php -r "eval(\'?>\'.file_get_contents(\'https://getcomposer.org/installer\'));"';
            $proc = $this->processor;
            $process = new $proc($cmd);
            if ($process->run() !== 0) {
                throw new \RuntimeException('Failed to download Composer. Output: ' . $process->getOutput());
            }
            if (!is_file('composer.phar')) {
                throw new \RuntimeException('Failed to download Composer: "composer.phar" still not found. Output: ' . $process->getOutput());
            }
            //caching
            copy('composer.phar', $cache);
        }
    }

    public function install()
    {
        $cmd = $this->command . ' install --prefer-source';
        $proc = $this->processor;
        $process = new $proc($cmd);
        $errCode = $process->run();
        $output = $process->getOutput();
        if ($errCode !== 0) {
            throw new \RuntimeException('Failed to install dependencies via Composer. Output: ' . $output);
        }
        return $this->processOutput($output);
    }

    public function update()
    {
        $cmd = $this->command . ' update';
        $proc = $this->processor;
        $process = new $proc($cmd);
        $errCode = $process->run();
        $output = $process->getOutput();
        if ($errCode !== 0) {
            throw new \RuntimeException('Failed to update dependencies via Composer. Output: ' . $output);
        }
        return $this->processOutput($output);
    }

    /**
     * Process Composer output into an array of dependencies and versions
     * @param string $output The Composer output to process
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    protected function processOutput($output)
    {
        $result = array();
        $entries = array();
        $matches = preg_match_all('{\- Installing (.*) \(v*(.*)\)}isU', $output, $entries, PREG_SET_ORDER);
        if ($matches) {
            foreach ($entries as $entry) {
                $result[$entry[1]] = $entry[2];
            }
        }
        return $result;
    }

    /**
     * FuelBlade consumer method
     * @param \Packfire\FuelBlade\ContainerInterface $c The container to get dependencies
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function __invoke($c)
    {
        if (isset($c['processor'])) {
            $this->processor = $c['processor'];
        }
    }
}
