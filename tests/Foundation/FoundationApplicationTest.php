<?php

use Mockery as m;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class FoundationApplicationTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		m::close();
	}


	public function testSetLocaleSetsLocaleAndFiresLocaleChangedEvent()
	{
		$app = new Application;
		$app['config'] = $config = m::mock('StdClass');
		$config->shouldReceive('set')->once()->with('app.locale', 'foo');
		$app['translator'] = $trans = m::mock('StdClass');
		$trans->shouldReceive('setLocale')->once()->with('foo');
		$app['events'] = $events = m::mock('StdClass');
		$events->shouldReceive('fire')->once()->with('locale.changed', array('foo'));

		$app->setLocale('foo');
	}


	public function testServiceProvidersAreCorrectlyRegistered()
	{
		$provider = m::mock('Illuminate\Support\ServiceProvider');
		$class = get_class($provider);
		$provider->shouldReceive('register')->once();
		$app = new Application;
		$app->register($provider);

		$this->assertTrue(in_array($class, $app->getLoadedProviders()));
	}


	public function testInstallPathsKeysExist()
	{
		$app = new Application;

		$paths = $app->getDefaultInstallPaths();

		$this->assertArrayHasKey('app', $paths);
		$this->assertArrayHasKey('base', $paths);
		$this->assertArrayHasKey('commands', $paths);
		$this->assertArrayHasKey('config', $paths);
		$this->assertArrayHasKey('controllers', $paths);
		$this->assertArrayHasKey('lang', $paths);
		$this->assertArrayHasKey('migrations', $paths);
		$this->assertArrayHasKey('public', $paths);
		$this->assertArrayHasKey('start', $paths);
		$this->assertArrayHasKey('storage', $paths);
		$this->assertArrayHasKey('views', $paths);
	}

}

class ApplicationCustomExceptionHandlerStub extends Illuminate\Foundation\Application {

	public function prepareResponse($value)
	{
		$response = m::mock('Symfony\Component\HttpFoundation\Response');
		$response->shouldReceive('send')->once();
		return $response;
	}

	protected function setExceptionHandler(Closure $handler) { return $handler; }

}

class ApplicationKernelExceptionHandlerStub extends Illuminate\Foundation\Application {

	protected function setExceptionHandler(Closure $handler) { return $handler; }

}
