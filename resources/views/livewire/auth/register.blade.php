<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
   <div class="max-w-md w-full space-y-8">
     <div>
       <img class="mx-auto h-10 w-auto" src="{{ asset('img/logo-dark.svg') }}" alt="Surge Logo">
       {{-- <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign up to your account</h2> --}}
     </div>
     <form class="mt-8 space-y-6" wire:submit.prevent="register">
       <input type="hidden" name="remember" value="true">
       <div class="rounded-md shadow-sm -space-y-px">
         <div class="m-2">
            <label for="name">Name</label>
            <input wire:model.lazy="name" id="name" name="name" type="text" autocomplete="text" class="@error('name') border-red-500 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Name">
            @error('name') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
         </div>
         <div class="m-2">
           <label for="email">Email address</label>
           <input wire:model="email" id="email" name="email" type="email" autocomplete="email" class="@error('email') border-red-500 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
           @error('email') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
         </div>
         <div class="m-2">
           <label for="password">Password</label>
           <input wire:model.lazy="password" id="password" name="password" type="password" autocomplete="current-password" class="@error('password') border-red-500 @enderror appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
           @error('password') <div class="mt-1 text-red-500 text-sm">{{ $message }}</div> @enderror
         </div>
         <div class="m-2">
            <label for="passwordConfirmation">Password Confirmation</label>
            <input wire:model.lazy="passwordConfirmation" id="passwordConfirmation" name="passwordConfirmation" type="password" autocomplete="current-password" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password Confirmation">
          </div>
       </div>
 
       <div>
         <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          
           Register
         </button>
       </div>
       <div class="flex items-center justify-center">
         <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Already have an account? Login</a>
       </div>
     </form>
   </div>
 </div>

