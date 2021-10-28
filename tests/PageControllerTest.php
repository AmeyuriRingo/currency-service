<?php

class PageControllerTest extends TestCase
{
    /**
     * Test home page.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test list page.
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->call('GET', '/list');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test recommendations page.
     *
     * @return void
     */
    public function testRecommendations()
    {
        $response = $this->call('GET', '/recommendations?start_date=2021-10-17&end_date=2021-10-18');
        $this->assertEquals(200, $response->status());
    }
}
