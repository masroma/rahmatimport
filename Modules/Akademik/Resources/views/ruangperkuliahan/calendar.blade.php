@extends('layouts.v1')
@section('title') {{$page}} @endsection
@section('content')
<div class="row">
    <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
    <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
      <!-- Search for small screen-->
      <div class="container">
        <div class="row">
          <div class="col s10 m6 l6">
            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Data {{$title}}</span></h5>
            <ol class="breadcrumbs mb-0">
              <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Dashboard</a>
              </li>
              {{-- <li class="breadcrumb-item"><a href="#">Table</a>
              </li> --}}
              <li class="breadcrumb-item active">{{$title}}
              </li>
            </ol>
          </div>
          <div class="col s2 m6 l6">

          </div>
        </div>
      </div>
    </div>
    <div class="col s12">
      <div class="container">
        <div class="section section-data-tables">
<div class="card">

</div>

<!-- Page Length Options -->
           <!-- Full Calendar -->

           <div id="app-calendar">
            <div class="row">

              <div class="col s12">
                <div class="card">
                  <div class="card-content">
                    <h4 class="card-title">
                     Management Ruangan
                    </h4>
                    <div class="row">
                      <div class="col m3 s12">
                        <div id='external-events'>
                          <h6>Daftar Kelas</h6>
                          <div class="fc-events-container mb-5" style="
                          height: 450px;
                          overflow: scroll;">
                             @foreach($getkelas as $dk)
                                <div class='fc-event' data-color='{{ $dk->color }}'>{{ $dk->nama_kelas }}{{ $dk->kode }}</div>
                            @endforeach


                          </div>
                        </div>

                          <p>
                            <label>
                              <input type="checkbox" id="drop-remove" />
                              <span>Remove After Drop</span>
                            </label>
                          </p>
                      </div>
                      <div class="col m9 s12">
                        <div id='fc-external-drag'></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- START RIGHT SIDEBAR NAV -->



</div><!-- START RIGHT SIDEBAR NAV -->

</div>
      </div>
      <div class="content-overlay"></div>
    </div>
  </div>



  @stop
  @section('script')
  <script>

    </script>

@endsection
