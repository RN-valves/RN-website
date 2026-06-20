<!-- <form method="GET" action="{{ route('search') }}" class="input-group search-form" id="search-form">
   @csrf
   <div class="search-wrapper d-flex" id="search-wrapper">
      <input type="text" name="q" id="q" class="search-input" value="@if(!empty(request('q'))) {{ request('q') }} @endif" class="form-control my-0 py-1 red-border" placeholder="Search Products" aria-label="Search">
      <div class="input-group-append">
         <button type="submit" class="input-group-text red lighten-3 search-button" id="basic-text1">
            <i class="fas fa-search text-grey" aria-hidden="true"></i>
         </button>
      </div>
   </div>
   
</form> -->
<style>
   .red-border {
      transition: width 0.3s ease-in-out;
      width: 40px !important;
   }

   .red-border:focus {
      width: 140px !important;
   }

   @media (max-width: 768px) {
      .red-border {
         width: 140px !important;
         opacity: 1 !important;
         transform: none !important;
         transition: none !important;
      }
   }
</style>
<form method="GET" action="{{ route('search') }}" class="input-group">
   @csrf

   <input type="text" name="q" id="q" value="@if(!empty(request('q'))) {{ request('q') }} @endif" class="form-control my-0 py-1 red-border" placeholder="Search...." aria-label="Search">
   <div class="input-group-append">
      <button type="submit" class="input-group-text red lighten-3" id="basic-text1">
         <i class="fas fa-search text-grey" aria-hidden="true"></i>
      </button>

   </div>
</form>

<script>
   document.addEventListener('DOMContentLoaded', function() {
      const input = document.querySelector('#q');
      const wrapper = document.querySelector('#search-wrapper');

      function toggleExpanded() {
         if (input.value.trim() !== '') {
            wrapper.classList.add('expanded');
         } else {
            wrapper.classList.remove('expanded');
         }
      }

      toggleExpanded(); // Run on load
      input.addEventListener('input', toggleExpanded); // Run on user typing
   });
</script>