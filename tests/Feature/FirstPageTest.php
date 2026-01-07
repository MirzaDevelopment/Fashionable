<?php
/*
Tets regarding the first page (view render, and product existance)
*/
namespace Tests\Feature;
use Tests\TestCase;

class FirstPageTest extends TestCase
{
 
    public function test_first_page_can_be_rendered(): void
    {
     $response = $this->get('/shop');
    $response->assertViewIs('firstpage');
    }

}
