<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\AnalysisController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalysisRegressionTest extends TestCase
{
    use RefreshDatabase;
    private function callPrivateMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function test_descriptive_stats()
    {
        $controller = new AnalysisController();
        $scores = [1, 2, 3, 4, 5];
        $stats = $this->callPrivateMethod($controller, 'calculateDescriptiveStats', [$scores]);
        
        $this->assertEquals(5, $stats['n']);
        $this->assertEquals(3.0, $stats['mean']);
        $this->assertEquals(1.0, $stats['min']);
        $this->assertEquals(5.0, $stats['max']);
        // Var = 2.5, StdDev = sqrt(2.5) = 1.58113883
        $this->assertEquals(1.5811, round($stats['std_dev'], 4));
    }

    public function test_t_probability()
    {
        $controller = new AnalysisController();
        $p = $this->callPrivateMethod($controller, 'tProbability', [2.0, 10]);
        $this->assertEquals(0.0734, round($p, 4));
    }

    public function test_f_probability()
    {
        $controller = new AnalysisController();
        $p = $this->callPrivateMethod($controller, 'fProbability', [4.1, 3, 10]);
        $this->assertEquals(0.0388, round($p, 4));
    }

    public function test_analysis_route_renders_successfully()
    {
        $response = $this->get('/analysis');
        $response->assertStatus(200);
    }
}
