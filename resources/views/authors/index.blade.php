@extends('layouts.app')

@section('content')
<div
    class="py-8 px-8 max-w-sm mx-auto bg-white rounded-xl shadow-lg space-y-2 sm:py-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-6">
    <img class="block mx-auto h-24 rounded-full sm:mx-0 sm:shrink-0" src="/img/erin-lindford.jpg" alt="Woman's Face">
    <div class="text-center space-y-2 sm:text-left">
        <div class="space-y-0.5">
            <p class="text-lg text-black font-semibold">
                Erin Lindford
            </p>
            <p class="text-slate-500 font-medium">
                Product Engineer
            </p>
        </div>
        <button
            class="px-4 py-1 text-sm text-purple-600 font-semibold rounded-full border border-purple-200 hover:text-white hover:bg-purple-600 hover:border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:ring-offset-2">Message</button>
    </div>
</div>



<div>
    <ul role="list" class="p-6 divide-y divide-slate-200">
        {#each people as person}
          <!-- Remove top/bottom padding when first/last child -->
          <li class="flex py-4 first:pt-0 last:pb-0">
            <img class="h-10 w-10 rounded-full" src="{person.imageUrl}" alt="" />
            <div class="ml-3 overflow-hidden">
              <p class="text-sm font-medium text-slate-900">{person.name}</p>
              <p class="text-sm text-slate-500 truncate">{person.email}</p>
            </div>
          </li>
        {/each}
      </ul>
</div>
@endsection
