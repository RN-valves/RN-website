<div style="background: #ffffff;">
         <div class="container-fluid">
            <div class="product-information padding-top-30 padding-bottom-50">
               <div class="tab-content description-tab-content">
                  <div class="tab-pane fade  show active">
                     <div class="comment-area">
                        <div class="row">
                           <div class="col-sm-12">
                              @if(Session::has('success_message_rating'))
                              <p class="alert alert-success">
                                 {{Session::get('success_message_rating')}}
                              </p>
                              @endif
                              @if(Session::has('error_message_rating'))
                              <p class="alert alert-danger">
                                 {{Session::get('error_message_rating')}}
                              </p>
                              @endif
                           </div>
                           <div class="col-md-4">
                              <div class="reviews_bxx">
                                 <h4 class="tabsectiontitle" style="margin-top: 0px;">
                                    RN Customer Reviews
                                 </h4>
                                 <div class="review_avarage">@if(!empty($ratings)) {{$ratings->avg('rating')}} @endif</div>
                                 <div class="star_boxxx">
                                    <?php
                                       $i = 1;
                                       $aveg = $ratings->avg('rating');
                                       while ($i<=$aveg) {
                                         $i++;
                                       ?>
                                    <i class="fas fa-star"></i>
                                    <?php } ?>
                                 </div>
                                 <div class="based_review">Based on {{$ratings->count('user_id')}} customer ratings</div>
                                 @guest
                                 <div class="rvw_text">Only registered users can write reviews. Please <a href="{{route('login')}}">Sign in</a> or <a href="{{route('register')}}">create an account</a>
                                 </div>
                                 @else
                                 <div>
                                    <a href="#" data-toggle="modal" data-target="#reviews_popup" class="btn btn-dark revbtn ajax_pp_js addtocartbtn"><i class="fa fa-pencil"></i>
                                    Write a reviews</a>
                                 </div>
                                 @endguest
                              </div>
                           </div>
                           <div class="col-md-8">
                              <h5 class="comments-title padding-bottom-5">
                                 {{$ratings->count()}} Reviews
                                 <div style="float: right;">
                                    <!-- <span style="font-size: 13px; font-weight: 600;">Sort by</span>
                                       <form class="sortReview" id="sortReview">
                                       <select class="sort_select" id="sort_review" name="sort_review">
                                          <option value="">Select Filter</option>
                                          <option value="Newest">Newest</option>
                                          <option value="Oldest">Oldest</option>
                                          <option value="Highest rated">Highest rated</option>
                                          <option value="Lowest rated">Lowest rated</option>
                                       </select>
                                       </form> -->
                                 </div>
                              </h5>
                              <div class="clear"></div>
                              <ul class="comment-list">
                                 <!-----loop start---->
                                 @if($ratings->count()>0)
                                 @foreach($ratings as $rating)
                                 <li>
                                    <div class="single-comment-wrap align-items-center">
                                       <div class="content bg-none">
                                          <span class="star_boxxx">
                                          <?php 
                                             $i = 1;
                                             $aveg = $rating['rating'];
                                             while ($i<=$aveg) {
                                               $i++;
                                             ?>
                                          <i class="fas fa-star"></i>
                                          <?php } ?>
                                          </span>
                                          <span class="date">{{$rating['created_at']->toFormattedDateString()}}</span>
                                          <div class="title-area">
                                             <h5 class="title">{{$rating['review_title']}}</h5>
                                          </div>
                                          <div class="padding-10">
                                             <p>{!! $rating['review'] !!}</p>
                                          </div>
                                          <div class="cstmr__name">
                                             <span>
                                             <img src="{{asset('public/images/avatar.png')}}" alt="User Icon">
                                             </span>
                                             {{$rating['user']['name']}}
                                          </div>
                                       </div>
                                    </div>
                                 </li>
                                 <!-----loop end---->
                                 @endforeach
                                 @endif
                              </ul>
                           </div>
                        </div>
                        <!-- comment form wrap -->
                     </div>
                  </div>
                  <!--// Tab Panel-->
               </div>
            </div>
            <!--// Product Information-->
         </div>
      </div>



<!--review popup form-->
<div class="modal fade" id="reviews_popup"  aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog review_form">
      <div class="modal-content">
         <form method="POST" action="">
            @csrf
            <input type="hidden" name="product_id" value="{{$getProduct['id']}}">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel">Add Reviews</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <span name="ratingForm" id="ratingForm">
                  <div class="star_boxxx mb-3">
                     <fieldset class="rating">
                        <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                        <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                        <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                        <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                        <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                     </fieldset>
                  </div>
                  <div class="form-group">
                     <label>Title</label>
                     <input type="text" class="form-control @error('review_title') is-invalid @enderror" placeholder="Name" id="review_title" name="review_title" value="{{old('review_title')}}">
                     @error('review_title')
                     <span class="invalid-feedback" role="alert">
                     {{$message}}
                     </span>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label>Write Your Reviews</label>
                     <textarea class="form-control @error('review') is-invalid @enderror" id="message-text" name="review" placeholder="Message">
                     {{old('review')}}
                     </textarea>
                     @error('review')
                     <span class="invalid-feedback" role="alert">
                     {{$message}}
                     </span>
                     @enderror
                  </div>
               </span>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-dark btn-lg">Submit Reviews</button>
            </div>
         </form>
      </div>
   </div>
</div>
<!--review popup form-->