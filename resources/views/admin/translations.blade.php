@extends('layouts.admin')
@section('head_title')
Website Language Translation
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">
<style>
.accordion {
	background-color: #eee;
	cursor: pointer;
	padding: 10px 18px;
	width: 100%;
	border: none;
	text-align: left;
	outline: none;
	font-size: 15px;
	transition: 0.4s;
}

.panel {

	display: none;
	background-color: white;
	overflow: hidden;
}
.accordion:after {
	content: '\02795'; /* Unicode character for "plus" sign (+) */
	font-size: 13px;
	color: #fff;
	float: right;
	margin-left: 5px;
	position: absolute;
	right: 20px;
	top: 10px;
}

.transdiv.active:after {
	content: "\2796"; /* Unicode character for "minus" sign (-) */
}

.thdr {padding: 20px;
    background: #f7f7f7;margin-left: 0px;}
    
    .ltrans {padding: 20px;}
    
  .mt10 {margin-top:10px!important;}
  
  .mt0 {margin-top:0px!important;}
  
</style>
<!-- Breadcrumb-->
<!--<div class="breadcrumb-holder">-->
<!--	<div class="container">-->
<!--		<ul class="breadcrumb">-->
<!--			<li class="breadcrumb-item"><a href="index.html">Home</a></li>-->
<!--			<li class="breadcrumb-item active">Website Language Translation </li>-->
<!--		</ul>-->
<!--	</div>-->

<!--</div>-->

<div class="container">
<br><br>
  <div class="app-title">
            <div>
                <h1><i class="fa fa-language" aria-hidden="true"></i> Website Language Translation</h1>
            </div>
           
        </div>
        <br>

<!-- Main content -->
<section class="section-padding">
	<div class="box-body">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					{{--<h3 class="box-title">Hover Data Table</h3>--}}
				</div><!-- /.box-header -->
				@if (Session::has('message'))<span class="alert-success">{!! Session::get('message') !!}</span>@endif
				@if (Session::has('error'))<span class="alert-danger">{!! Session::get('error') !!}</span>@endif
				<div class="box-body">



					<div class="col-md-12 cls-vertical-align">


					@foreach($results as $index => $key)
						{{-- 	{{ dd($index)  }} --}}
						{{-- {{ dd($results['auth']['failed']['en']) }} --}}

						<div class="row col-md-12 transdiv accordion" style="background: #373a3a;margin-left:0px;margin-bottom:0px;border-top: 1px solid #fff;color:#fff;">
							@if($index == 'home_contents')
							Home Page Contents
							@elseif($index == 'ad_details_listing')
							Ad Details Listing
							@else
							{{ ucfirst($index) }}
							@endif

						</div>

						<div class="panel mt0">
							<div class="row col-md-12 transdiv thdr">
								<div class="col-md-3 landiv">Keywords</div>
								<div class="col-md-4 landiv">English</div>
								<div class="col-md-4 landiv">Arabic</div>
								<div class="col-md-1 landiv">Action</div>

							</div>

							@foreach($key as $subindex => $subkey)


                         <div class="ltrans">
							<form action="" name="form1" id="form1" class="formSubmit">
								<div class="row form-group">
									{!! csrf_field() !!}
									<div class="col-md-3 transdtl"><span>{{ $subindex }}</span></div>

									<input type="hidden" name="page" value="{!! $index !!}">
									<input type="hidden" name="key" value="{!! $subindex !!}">

									<div class="col-md-4"><textarea name="value" class="form-control">@if($subkey['en']){{ $subkey['en'] }} @endif</textarea></div>

									<div class="col-md-4"><textarea name="value_ar" class="form-control rtl">@if($subkey['ar']){{ $subkey['ar'] }} @endif</textarea></div>


									<div class="col-md-1 mt10"><button name="save_btn" id="save_btn" class="btn btn-primary">Save</button></div>
								</div>
							</form>
							</div>

							@endforeach
						</div>

						@endforeach
					</div>

				</div><!-- /.box-body -->
			</div><!-- /.box -->


		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->
</div>


@endsection

@section('page-js')
<script src="{{ asset('assets/js/iziToast.min.js')}}"></script>
<script>
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var panel = this.nextElementSibling;
			if (panel.style.display === "block") {
				panel.style.display = "none";
			} else {
				panel.style.display = "block";
			}
		});
	}
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".formSubmit").submit(function(e){
			e.preventDefault();
			//console.log($(this).html());

			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: '/admin/website-languages',
				type: 'POST',
				data:$(this).serialize(),
				success:function(result){
					//console.log(result);
					if (result.success == true) {						      
						iziToast.success({
							title: 'Status',
							targetFirst: true,
							toastOnce:true,
							message: result.msg
						});

					}
					else
					{
						iziToast.error({
							title: 'Status',
							targetFirst: true,
							toastOnce:true,
							message: result.msg
						});
					}

				}

			});
		});
	});
</script>
@endsection