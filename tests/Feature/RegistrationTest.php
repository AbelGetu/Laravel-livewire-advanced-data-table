<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{ 
   use RefreshDatabase;

//    /** @test */
//    function registration_page_contains_livewire_component()
//    {
//      $this->get('/register')->assertSeeLivewire('auth.register');
//    }

   /** @test */
   function can_register()
   {
        Livewire::test('auth.register')
            ->set('name', 'Abel')
            ->set('email', 'abelgetu27@gmail.com')
            ->set('password', 'secret')
            ->set('passwordConfirmation', 'secret')
            ->call('register')
            ->assertRedirect('/');

        $this->assertTrue(User::whereEmail('abelgetu27@gmail.com')->exists());
        $this->assertEquals('abelgetu27@gmail.com', auth()->user()->email);
   }

   /** @test */
   function email_is_required()
   {
        Livewire::test('auth.register')
                ->set('name', 'Abel')
                ->set('email', 'abelgetu27@gmail.com')
                ->set('password', 'secret')
                ->set('passwordConfirmation', 'secret')
                ->call('register')
                ->assertHasErrors(['email' => 'required']);
   }

   /** @test */
   function email_is_valid_email()
   {
        Livewire::test('auth.register')
                ->set('name', 'Abel')
                ->set('email', 'abelgetu27@gmail.com')
                ->set('password', 'secret')
                ->set('passwordConfirmation', 'secret')
                ->call('register')
                ->assertHasErrors(['email' => 'email']);
   }

    /** @test */
    function email_hasnt_been_taken_already()
    {
          User::create([
               'name' => 'Abel',
               'email' => 'abelgetu27@gmail.com',
               'password' => Hash::make('secret')
          ]);

         Livewire::test('auth.register')
                 ->set('name', 'Abel')
                 ->set('email', 'abelgetu27@gmail.com')
                 ->set('password', 'secret')
                 ->set('passwordConfirmation', 'secret')
                 ->call('register')
                 ->assertHasErrors(['email' => 'unique']);
    }

        /** @test */
        function password_is_required()
        {    
             Livewire::test('auth.register')
                     ->set('name', 'Abel')
                     ->set('email', 'abelgetu277@gmail.com')
                     ->set('password', '')
                     ->set('passwordConfirmation', 'secret')
                     ->call('register')
                     ->assertHasErrors(['password' => 'required']);
        }
}
