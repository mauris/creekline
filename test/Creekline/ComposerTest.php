<?php
namespace Creekline;

use Packfire\FuelBlade\Container;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-05-10 at 14:28:43.
 */
class ComposerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Composer
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers Creekline\Composer::__invoke
     */
    protected function setUp()
    {
        $this->object = new Composer;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Creekline\Composer::download
     * @expectedException \RuntimeException
     */
    public function testDownloadFail()
    {
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Failure';
        call_user_func($this->object, $c);
        $this->object->download();
    }

    /**
     * @covers Creekline\Composer::download
     * @expectedException \RuntimeException
     */
    public function testDownloadFileMissing()
    {
        $cwd = getcwd();
        chdir(sys_get_temp_dir());
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Success';
        call_user_func($this->object, $c);
        $this->object->download();
        chdir($cwd);
    }

    /**
     * @covers Creekline\Composer::download
     */
    public function testDownload()
    {
        $cwd = getcwd();
        chdir(sys_get_temp_dir());
        file_put_contents('composer.phar', '<?php ');
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Success';
        call_user_func($this->object, $c);
        $this->object->download();
        unlink('composer.phar');
        chdir($cwd);
    }

    /**
     * @covers Creekline\Composer::install
     */
    public function testInstall()
    {
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Composer';
        call_user_func($this->object, $c);
        $result = $this->object->install();
        $this->assertEquals(
            array(
                'symfony/process' => 'v2.2.1',
                'symfony/finder' => 'v2.2.1'
            ),
            $result
        );
    }

    /**
     * @covers Creekline\Composer::install
     * @expectedException \RuntimeException
     */
    public function testInstallFail()
    {
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Failure';
        call_user_func($this->object, $c);
        $this->object->install();
    }

    /**
     * @covers Creekline\Composer::update
     */
    public function testUpdate()
    {
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Composer';
        call_user_func($this->object, $c);
        $result = $this->object->update();
        $this->assertEquals(
            array(
                'symfony/process' => 'v2.2.1',
                'symfony/finder' => 'v2.2.1'
            ),
            $result
        );
    }

    /**
     * @covers Creekline\Composer::update
     * @expectedException \RuntimeException
     */
    public function testUpdateFail()
    {
        $c = new Container();
        $c['processor'] = '\\Creekline\\MockProcess\\Failure';
        call_user_func($this->object, $c);
        $this->object->update();
    }
}
