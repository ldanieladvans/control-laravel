@extends('template.applayout')

@section('app_css')
	@parent

@endsection

@section('app_content')
<div class="container">
    <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Contacts Design</h3>
              </div>


              <form class="form-horizontal form-label-left" novalidate action="{{ route('client.csearch') }}" method='POST'>

                	{{ csrf_field() }}
	              <div class="title_right">
	                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
	                  <div class="input-group">
	                    <input id="csearch" name="csearch" type="text" class="form-control" placeholder="Buscar por nombre...">
	                    <span class="input-group-btn">
	                      <button class="btn btn-default" type="submit">Buscar</button>
	                    </span>
	                  </div>
	                </div>
	              </div>
              </form>


            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12 text-center">

                      </div>

                      <div class="clearfix"></div>

                      @foreach($clients as $client)
	                      <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
	                        <div class="well profile_view">
	                          <div class="col-sm-12">
	                            <h4 class="brief"><i>Digital Strategist</i></h4>
	                            <div class="left col-xs-7">
	                              <h2>Nicole Pearson</h2>
	                              <p><strong>About: </strong> Web Designer / UI. </p>
	                              <ul class="list-unstyled">
	                                <li><i class="fa fa-building"></i> Address: </li>
	                                <li><i class="fa fa-phone"></i> Phone #: </li>
	                              </ul>
	                            </div>
	                            <div class="right col-xs-5 text-center">
	                              <img src="images/user.png" alt="" class="img-circle img-responsive">
	                            </div>
	                          </div>
	                          <div class="col-xs-12 bottom text-center">
	                            <div class="col-xs-12 col-sm-6 emphasis">
	                              <p class="ratings">
	                                <a>4.0</a>
	                                <a href="#"><span class="fa fa-star"></span></a>
	                                <a href="#"><span class="fa fa-star"></span></a>
	                                <a href="#"><span class="fa fa-star"></span></a>
	                                <a href="#"><span class="fa fa-star"></span></a>
	                                <a href="#"><span class="fa fa-star-o"></span></a>
	                              </p>
	                            </div>
	                            <div class="col-xs-12 col-sm-6 emphasis">
	                              <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
	                                </i> <i class="fa fa-comments-o"></i> </button>
	                              <button type="button" class="btn btn-primary btn-xs">
	                                <i class="fa fa-user"> </i> View Profile
	                              </button>
	                            </div>
	                          </div>
	                        </div>
	                      </div>
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
</div>
@endsection

@section('app_js') 
	@parent
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>

    <script>
      $( function() {
          $('#alertmsgcta').click(function() {
              console.log('alertmsgcta button clicked');
          });

           $('#clientsearch').click(function() {
              alert('alertmsgcta button clicked');
          });
          
          setTimeout(function() {
              $('#alertmsgcta').trigger('click');
          }, 4e3);
      });
    </script>
@endsection