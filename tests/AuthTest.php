<?php
class AuthTest extends TestCase {


    public function testLoginNegative()
    {
        $this->call('POST', 'auth/login', ['email' => 'invalid@invalid.invalid','password' => 'test' ]);

        $this->assertSessionHasErrors();
    }

    public function testLoginPositive()
    {

        $this->call('POST', 'auth/login', ['email' => 'test@test.com','password' => 'test' ]);

        $errors = Session::get('errors') ? true : false;

        $this->assertFalse( $errors ) ;
    }

}
