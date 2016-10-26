@extends('layouts.blogfull')

@section('content')
    <section class="moduler wrapper_404">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h1 class="wow fadeInUp animated cd-headline slide" data-wow-delay=".4s" >401</h1>
                        <h2 class="wow fadeInUp animated" data-wow-delay=".6s">Opps! You have some problems with permission</h2>
                        <a href="{{url('/')}}" class="btn btn-dafault btn-home wow fadeInUp animated" data-wow-delay="1.1s">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
