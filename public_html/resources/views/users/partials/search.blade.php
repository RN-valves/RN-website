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
   /* Premium Search Box */
   .rn-search-form {
      display: flex;
      align-items: center;
      background: transparent;
      border: none;
      border-radius: 0;
      overflow: visible;
      padding: 0 4px;
      transition: none;
      box-shadow: none;
   }
   .rn-search-form:focus-within {
      border-color: transparent;
      background: transparent;
      box-shadow: none;
   }
   .rn-search-input {
      border: none !important;
      background: transparent !important;
      box-shadow: none !important;
      outline: none !important;
      padding: 7px 8px 7px 2px !important;
      font-size: 13px;
      color: #1e293b;
      width: 110px;
      transition: width 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
      font-family: 'Neo Sans', 'Neo Sans Std', sans-serif;
   }
   .rn-search-input:focus {
      width: 170px;
   }
   .rn-search-input::placeholder {
      color: #94a3b8;
      font-size: 13px;
   }
   .rn-search-btn {
      background: transparent;
      border: none;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: #64748b;
      font-size: 14px;
      flex-shrink: 0;
      transition: color 0.25s ease;
   }
   .rn-search-btn:hover {
      color: #003366;
   }
   @media (max-width: 768px) {
      .rn-search-input { width: 90px; }
      .rn-search-input:focus { width: 120px; }
   }
</style>

<form method="GET" action="{{ route('search') }}" class="rn-search-form" id="search-form">
   @csrf
   <input type="text" name="q" id="q"
      value="@if(!empty(request('q'))) {{ request('q') }} @endif"
      class="rn-search-input"
      placeholder="Search products..."
      autocomplete="off"
      aria-label="Search">
   <button type="submit" class="rn-search-btn" id="basic-text1" aria-label="Search">
      <i class="fas fa-search" aria-hidden="true"></i>
   </button>
</form>                                                                                                  